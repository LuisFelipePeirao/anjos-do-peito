<?php

namespace App\Http\Controllers;

use App\Models\Beneficiaria;
use App\Models\Cep;
use App\Models\Crianca;
use App\Models\Endereco;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class BeneficiaryController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();
        $status = $request->string('status', 'active')->toString();

        $query = Beneficiaria::query()
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
            ->orderBy('nome');

        return view('pages.beneficiaries.index', [
            'beneficiaries' => $query->get()->map(fn (Beneficiaria $beneficiaria) => [
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
                    ],
                ],
            ]),
            'kpis' => [
                ['label' => 'Beneficiárias ativas', 'value' => Beneficiaria::where('situacao', 'ativo')->count(), 'context' => 'Beneficiárias com acompanhamento ativo', 'tone' => 'rose', 'icon' => 'people-o'],
                ['label' => 'Total cadastrado', 'value' => Beneficiaria::count(), 'context' => 'Beneficiárias cadastradas no sistema', 'tone' => 'green', 'icon' => 'check'],
                ['label' => 'Cadastros inativos', 'value' => Beneficiaria::where('situacao', 'inativo')->count(), 'context' => 'Sem acompanhamento ativo', 'tone' => 'amber', 'icon' => 'report-problem-o'],
            ],
            'search' => $search,
            'status' => $status,
        ]);
    }

    public function create(): View
    {
        return view('pages.beneficiaries.create', $this->formOptions());
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedBeneficiary($request);

        DB::transaction(function () use ($data) {
            $addressId = $this->persistAddress($data);

            Beneficiaria::create([
                ...$this->beneficiaryAttributes($data),
                'id_endereco' => $addressId,
                'situacao' => 'ativo',
            ]);
        });

        return redirect()->route('beneficiaries.index')->with('status', 'Beneficiária criada com sucesso.');
    }

    public function show(Request $request, Beneficiaria $beneficiaria): View
    {
        $beneficiaria->load(['endereco.cep', 'criancas']);
        $childToEdit = $request->filled('editar_crianca')
            ? $beneficiaria->criancas->firstWhere('id', (int) $request->input('editar_crianca'))
            : null;

        $tab = $request->string('tab', 'overview')->toString();
        $tabs = ['overview', 'attendances', 'pumps', 'donations', 'history', 'babies'];

        return view('pages.beneficiaries.show', [
            'beneficiaria' => $beneficiaria,
            'childToEdit' => $childToEdit,
            'sexOptions' => $this->sexOptions(),
            'tab' => in_array($tab, $tabs, true) ? $tab : 'overview',
        ]);
    }

    public function edit(Beneficiaria $beneficiaria): View
    {
        $beneficiaria->load('endereco.cep');

        return view('pages.beneficiaries.edit', [
            'beneficiaria' => $beneficiaria,
            ...$this->formOptions(),
        ]);
    }

    public function update(Request $request, Beneficiaria $beneficiaria): RedirectResponse
    {
        $data = $this->validatedBeneficiary($request, $beneficiaria);

        DB::transaction(function () use ($beneficiaria, $data) {
            $addressId = $this->persistAddress($data, $beneficiaria->endereco);
            $beneficiaria->update([...$this->beneficiaryAttributes($data), 'id_endereco' => $addressId]);
        });

        return redirect()->route('beneficiaries.show', $beneficiaria)->with('status', 'Beneficiária atualizada com sucesso.');
    }

    public function deactivate(Beneficiaria $beneficiaria): RedirectResponse
    {
        $beneficiaria->update(['situacao' => 'inativo']);

        return redirect()->route('beneficiaries.show', $beneficiaria)->with('status', 'Beneficiária inativada com sucesso.');
    }

    public function storeChild(Request $request, Beneficiaria $beneficiaria): RedirectResponse
    {
        $beneficiaria->criancas()->create($this->validatedChild($request));

        return redirect()->route('beneficiaries.show', $beneficiaria)->with('status', 'Bebê cadastrado com sucesso.');
    }

    public function updateChild(Request $request, Beneficiaria $beneficiaria, Crianca $crianca): RedirectResponse
    {
        $this->ensureChildBelongsToBeneficiary($beneficiaria, $crianca);
        $crianca->update($this->validatedChild($request));

        return redirect()->route('beneficiaries.show', $beneficiaria)->with('status', 'Dados do bebê atualizados com sucesso.');
    }

    public function destroyChild(Beneficiaria $beneficiaria, Crianca $crianca): RedirectResponse
    {
        $this->ensureChildBelongsToBeneficiary($beneficiaria, $crianca);
        $crianca->delete();

        return redirect()->route('beneficiaries.show', $beneficiaria)->with('status', 'Bebê removido com sucesso.');
    }

    private function validatedBeneficiary(Request $request, ?Beneficiaria $beneficiaria = null): array
    {
        $request->merge([
            'cpf' => preg_replace('/\D/', '', (string) $request->input('cpf')),
            'cep' => preg_replace('/\D/', '', (string) $request->input('cep')) ?: null,
        ]);

        $addressStarted = collect(['cep', 'logradouro', 'bairro', 'cidade', 'uf', 'numero', 'complemento'])
            ->contains(fn (string $field) => filled($request->input($field)));

        $data = $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'cpf' => ['required', 'string', 'regex:/^\d{11}$/', fn (string $attribute, string $value, $fail) => $this->isValidCpf($value) ?: $fail('Informe um CPF válido.'), Rule::unique('beneficiarias', 'cpf')->ignore($beneficiaria?->id)],
            'email' => ['required', 'email', 'max:255'],
            'telefone' => ['required', 'string', 'max:30'],
            'telefone_alternativo' => ['nullable', 'string', 'max:30'],
            'origem_cadastro' => ['required', Rule::in(array_keys($this->origins()))],
            'cep' => [Rule::requiredIf($addressStarted), 'nullable', 'string', 'regex:/^\d{8}$/'],
            'logradouro' => ['nullable', 'string', 'max:255'],
            'bairro' => ['nullable', 'string', 'max:255'],
            'cidade' => [Rule::requiredIf($addressStarted), 'nullable', 'string', 'max:255'],
            'uf' => [Rule::requiredIf($addressStarted), 'nullable', Rule::in(array_keys($this->states()))],
            'numero' => ['nullable', 'string', 'max:255'],
            'complemento' => ['nullable', 'string', 'max:255'],
        ]);

        return $data;
    }

    private function validatedChild(Request $request): array
    {
        return $request->validate([
            'nome' => ['required', 'string', 'max:255'],
            'data_nascimento' => ['required', 'date', 'before_or_equal:today'],
            'sexo' => ['required', Rule::in(array_keys($this->sexOptions()))],
        ]);
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

    private function formOptions(): array
    {
        return ['origins' => $this->origins(), 'states' => $this->states()];
    }

    private function origins(): array
    {
        return ['busca_espontanea' => 'Busca espontânea', 'encaminhamento_ubs' => 'Encaminhamento UBS', 'indicacao' => 'Indicação', 'acao_social' => 'Ação social'];
    }

    private function states(): array
    {
        return collect(['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'])->mapWithKeys(fn (string $state) => [$state => $state])->all();
    }

    private function sexOptions(): array
    {
        return ['masculino' => 'Masculino', 'feminino' => 'Feminino', 'indefinido' => 'Prefiro não informar'];
    }

    private function formatCpf(string $cpf): string
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
    }

    private function isValidCpf(string $cpf): bool
    {
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            return false;
        }

        for ($position = 9; $position < 11; $position++) {
            $sum = 0;

            for ($index = 0; $index < $position; $index++) {
                $sum += (int) $cpf[$index] * (($position + 1) - $index);
            }

            $digit = ($sum * 10) % 11;
            $digit = $digit === 10 ? 0 : $digit;

            if ($digit !== (int) $cpf[$position]) {
                return false;
            }
        }

        return true;
    }
}
