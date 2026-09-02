<?php

namespace App\Services;

use App\Http\Requests\Beneficiaries\StoreBeneficiaryRequest;
use App\Http\Requests\Beneficiaries\StoreChildRequest;
use App\Models\Beneficiaria;
use App\Models\Cep;
use App\Models\Crianca;
use App\Models\Endereco;
use Illuminate\Support\Facades\DB;

class BeneficiaryService
{
    public function indexData(array $filters): array
    {
        $search = $filters['search'];
        $status = $filters['status'];

        $beneficiaries = Beneficiaria::query()
            ->when($status === 'active', fn ($query) => $query->where('situacao', 'ativo'))
            ->when($status === 'inactive', fn ($query) => $query->where('situacao', 'inativo'))
            ->when($search !== '', function ($query) use ($search) {
                $cpf = preg_replace('/\D/', '', $search);

                $query->where(function ($query) use ($search, $cpf) {
                    $query->where('nome', 'like', "%{$search}%");

                    if ($cpf !== '') {
                        $query->orWhere('cpf', 'like', "%{$cpf}%");
                    }
                });
            })
            ->orderBy('nome')
            ->get()
            ->map(fn (Beneficiaria $beneficiaria) => [
                'nome' => $beneficiaria->nome,
                'cpf' => $this->formatCpf($beneficiaria->cpf),
                'email' => $beneficiaria->email,
                'telefone' => $beneficiaria->telefone,
                'status' => $beneficiaria->situacao === 'ativo' ? 'Ativa' : 'Inativa',
                '_actions' => [
                    'view' => route('beneficiaries.show', $beneficiaria),
                    'items' => [
                        ['icon' => 'visibility-o', 'route' => route('beneficiaries.show', $beneficiaria), 'title' => 'Visualizar beneficiária'],
                        ['icon' => 'edit-o', 'route' => route('beneficiaries.edit', $beneficiaria), 'title' => 'Editar beneficiária'],
                        ['icon' => 'delete-o', 'route' => route('beneficiaries.deactivate', $beneficiaria), 'title' => 'Inativar beneficiária'],
                    ],
                ],
            ]);

        return [
            'beneficiaries' => $beneficiaries,
            'kpis' => $this->kpis(),
            'search' => $search,
            'status' => $status,
        ];
    }

    public function formOptions(): array
    {
        return [
            'origins' => StoreBeneficiaryRequest::origins(),
            'states' => StoreBeneficiaryRequest::states(),
        ];
    }

    public function create(array $data): void
    {
        DB::transaction(function () use ($data) {
            $addressId = $this->persistAddress($data);

            Beneficiaria::create([
                ...$this->beneficiaryAttributes($data),
                'id_endereco' => $addressId,
                'situacao' => 'ativo',
            ]);
        });
    }

    public function showData(Beneficiaria $beneficiaria, ?int $childId, string $tab): array
    {
        $beneficiaria->load(['endereco.cep', 'criancas']);
        $tabs = ['overview', 'attendances', 'pumps', 'donations', 'history', 'babies'];

        return [
            'beneficiaria' => $beneficiaria,
            'childToEdit' => $childId ? $beneficiaria->criancas->firstWhere('id', $childId) : null,
            'sexOptions' => StoreChildRequest::sexOptions(),
            'tab' => in_array($tab, $tabs, true) ? $tab : 'overview',
        ];
    }

    public function editData(Beneficiaria $beneficiaria): array
    {
        $beneficiaria->load('endereco.cep');

        return [
            'beneficiaria' => $beneficiaria,
            ...$this->formOptions(),
        ];
    }

    public function update(Beneficiaria $beneficiaria, array $data): void
    {
        DB::transaction(function () use ($beneficiaria, $data) {
            $addressId = $this->persistAddress($data, $beneficiaria->endereco);
            $beneficiaria->update([...$this->beneficiaryAttributes($data), 'id_endereco' => $addressId]);
        });
    }

    public function deactivate(Beneficiaria $beneficiaria): void
    {
        $beneficiaria->update(['situacao' => 'inativo']);
    }

    public function storeChild(Beneficiaria $beneficiaria, array $data): void
    {
        $beneficiaria->criancas()->create($data);
    }

    public function updateChild(Beneficiaria $beneficiaria, Crianca $crianca, array $data): void
    {
        $this->ensureChildBelongsToBeneficiary($beneficiaria, $crianca);
        $crianca->update($data);
    }

    public function destroyChild(Beneficiaria $beneficiaria, Crianca $crianca): void
    {
        $this->ensureChildBelongsToBeneficiary($beneficiaria, $crianca);
        $crianca->delete();
    }

    private function kpis(): array
    {
        return [
            ['label' => 'Beneficiárias ativas', 'value' => Beneficiaria::where('situacao', 'ativo')->count(), 'context' => 'Beneficiárias com acompanhamento ativo', 'tone' => 'rose', 'icon' => 'people-o'],
            ['label' => 'Total cadastrado', 'value' => Beneficiaria::count(), 'context' => 'Beneficiárias cadastradas no sistema', 'tone' => 'green', 'icon' => 'check'],
            ['label' => 'Cadastros inativos', 'value' => Beneficiaria::where('situacao', 'inativo')->count(), 'context' => 'Sem acompanhamento ativo', 'tone' => 'amber', 'icon' => 'report-problem-o'],
        ];
    }

    private function persistAddress(array $data, ?Endereco $address = null): ?int
    {
        $addressFields = ['cep', 'logradouro', 'bairro', 'cidade', 'uf', 'numero', 'complemento'];
        $hasAddress = collect($addressFields)->contains(fn (string $field) => filled($data[$field] ?? null));

        if (! $hasAddress) {
            return null;
        }

        $cep = $address?->cep ?? new Cep();
        $cep->fill([
            'cep' => (int) $data['cep'],
            'cidade' => $data['cidade'],
            'uf' => $data['uf'],
            'bairro' => $data['bairro'] ?? null,
            'logradouro' => $data['logradouro'] ?? null,
        ])->save();

        $address ??= new Endereco();
        $address->fill([
            'id_cep' => $cep->id,
            'numero' => $data['numero'] ?? null,
            'complemento' => $data['complemento'] ?? null,
        ])->save();

        return $address->id;
    }

    private function beneficiaryAttributes(array $data): array
    {
        return [
            ...collect($data)->only(['nome', 'cpf', 'email', 'telefone', 'origem_cadastro'])->all(),
            'telefone_alternativo' => $data['telefone_alternativo'] ?? '',
        ];
    }

    private function ensureChildBelongsToBeneficiary(Beneficiaria $beneficiaria, Crianca $crianca): void
    {
        abort_unless($crianca->id_beneficiaria === $beneficiaria->id, 404);
    }

    private function formatCpf(string $cpf): string
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
    }
}
