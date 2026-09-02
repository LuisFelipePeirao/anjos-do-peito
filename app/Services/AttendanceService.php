<?php

namespace App\Services;

use App\Http\Requests\Attendances\StoreAttendanceRequest;
use App\Models\Atendimento;
use App\Models\Beneficiaria;
use App\Models\Crianca;
use App\Models\LocalAtendimento;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    public function indexData(array $filters): array
    {
        $search = $filters['search'];
        $status = $filters['status'];
        $modality = $filters['modality'];

        $attendances = Atendimento::query()
            ->with(['beneficiaria', 'usuario', 'detalhe'])
            ->when($status !== 'all', fn ($query) => $query->where('situacao', $status))
            ->when($modality !== 'all', fn ($query) => $query->where('modalidade', $modality))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->whereHas('beneficiaria', fn ($query) => $query->where('nome', 'like', "%{$search}%"))
                        ->orWhereHas('usuario', fn ($query) => $query->where('nome', 'like', "%{$search}%"))
                        ->orWhereHas('detalhe', fn ($query) => $query->where('resumo', 'like', "%{$search}%"));
                });
            })
            ->orderByDesc('data_hora')
            ->get()
            ->map(fn (Atendimento $atendimento) => [
                'date' => $atendimento->data_hora?->format('d/m/Y') ?? '-',
                'time' => $atendimento->data_hora?->format('H:i') ?? '-',
                'beneficiary' => $atendimento->beneficiaria?->nome ?? '-',
                'professional' => $atendimento->usuario?->nome ?? '-',
                'modality' => $this->modalityLabel($atendimento->modalidade),
                'status' => $this->statusLabel($atendimento->situacao).($atendimento->rascunho ? ' (Rascunho)' : ''),
                '_actions' => [
                    'view' => route('attendances.show', $atendimento),
                    'items' => [
                        ['icon' => 'visibility-o', 'route' => route('attendances.show', $atendimento), 'title' => 'Visualizar atendimento'],
                        ...($this->canEdit($atendimento) ? [['icon' => 'edit-o', 'route' => route('attendances.edit', $atendimento), 'title' => 'Editar atendimento']] : []),
                        ['icon' => 'delete-o', 'route' => route('attendances.destroy', $atendimento), 'title' => 'Excluir atendimento', 'variant' => 'danger', 'confirmation' => ['method' => 'DELETE']],
                    ],
                ],
            ]);

        return [
            'attendances' => $attendances,
            'kpis' => $this->kpis(),
            'search' => $search,
            'status' => $status,
            'modality' => $modality,
        ];
    }

    public function createData(): array
    {
        return [
            'mode' => 'create',
            'attendanceData' => $this->emptyAttendanceData(),
            ...$this->formOptions(),
        ];
    }

    public function store(array $data): Atendimento
    {
        $data = $this->normalizeClinicalData($data);

        return DB::transaction(function () use ($data) {
            $attendance = Atendimento::create($this->attendanceAttributes($data));
            $attendance->detalhe()->create($this->detailAttributes($data));

            return $attendance;
        });
    }

    public function showData(Atendimento $attendance, string $tab): array
    {
        $attendance->load(['beneficiaria.criancas', 'crianca', 'usuario', 'local', 'detalhe']);
        $tabs = ['overview', 'evolution', 'history'];

        return [
            'attendance' => $attendance,
            'attendanceData' => $this->attendanceData($attendance),
            'kpis' => $this->showKpis($attendance),
            'evolution' => $this->evolution($attendance),
            'history' => $this->history($attendance),
            'canEdit' => $this->canEdit($attendance),
            'tab' => in_array($tab, $tabs, true) ? $tab : 'overview',
        ];
    }

    public function editData(Atendimento $attendance): array
    {
        abort_unless($this->canEdit($attendance), 403);
        abort_if($attendance->situacao === 'em_atendimento', 409);

        $attendance->load(['detalhe', 'local', 'crianca']);

        return [
            'mode' => 'edit',
            'attendance' => $attendance,
            'attendanceData' => $this->attendanceData($attendance),
            ...$this->formOptions(),
        ];
    }

    public function update(Atendimento $attendance, array $data): void
    {
        abort_unless($this->canEdit($attendance), 403);
        abort_if($attendance->situacao === 'em_atendimento', 409);

        $data = $this->normalizeClinicalData($data);

        DB::transaction(function () use ($attendance, $data) {
            $attendance->update($this->attendanceAttributes($data));
            $attendance->detalhe()->updateOrCreate(['id_atendimento' => $attendance->id], $this->detailAttributes($data));
        });
    }

    public function start(Atendimento $attendance): void
    {
        abort_unless($attendance->situacao === 'agendado', 409);

        $attendance->update(['situacao' => 'em_atendimento']);
    }

    public function continuationData(Atendimento $attendance): array
    {
        abort_unless($attendance->situacao === 'em_atendimento', 409);

        $attendance->load(['beneficiaria', 'crianca', 'usuario', 'local', 'detalhe']);

        return [
            'attendance' => $attendance,
            'attendanceData' => $this->attendanceData($attendance),
        ];
    }

    public function saveContinuation(Atendimento $attendance, array $data): void
    {
        abort_unless($attendance->situacao === 'em_atendimento', 409);

        DB::transaction(function () use ($attendance, $data) {
            $attendance->update([
                'situacao' => $data['save_as'] === 'final' ? 'realizado' : 'em_atendimento',
                'rascunho' => $data['save_as'] === 'draft',
            ]);
            $attendance->detalhe()->updateOrCreate(['id_atendimento' => $attendance->id], $this->detailAttributes($data));
        });
    }

    public function childrenOptions(Beneficiaria $beneficiaria): array
    {
        return $beneficiaria->criancas()
            ->orderBy('nome')
            ->get(['id', 'nome'])
            ->map(fn (Crianca $crianca) => ['value' => $crianca->id, 'label' => $crianca->nome])
            ->values()
            ->all();
    }

    public function destroy(Atendimento $attendance): void
    {
        $attendance->delete();
    }

    public function storeLocation(array $data): void
    {
        LocalAtendimento::create($data);
    }

    private function attendanceAttributes(array $data): array
    {
        return [
            'data_hora' => filled($data['date'] ?? null) && filled($data['time'] ?? null) ? Carbon::parse($data['date'].' '.$data['time']) : null,
            'duracao_prevista' => $data['duration'] ?? null,
            'modalidade' => $data['modality'] ?? 'presencial',
            'id_local' => $data['location'] ?? null,
            'situacao' => $data['status'],
            'rascunho' => $data['save_as'] === 'draft',
            'id_beneficiaria' => $data['beneficiary'],
            'id_crianca' => $data['child'] ?? null,
            'id_usuario' => $data['professional'] ?? null,
        ];
    }

    private function normalizeClinicalData(array $data): array
    {
        if (($data['status'] ?? null) !== 'agendado') {
            return $data;
        }

        return array_merge($data, array_fill_keys(['summary', 'objective', 'complaint', 'evaluation', 'conduct', 'notes'], null));
    }

    private function detailAttributes(array $data): array
    {
        return [
            'resumo' => $data['summary'] ?? null,
            'objetivo' => $data['objective'] ?? null,
            'queixa' => $data['complaint'] ?? null,
            'avaliacao' => $data['evaluation'] ?? null,
            'conduta' => $data['conduct'] ?? null,
            'observacao' => $data['notes'] ?? null,
        ];
    }

    private function canEdit(Atendimento $atendimento): bool
    {
        return ! ($atendimento->situacao === 'realizado' && ! $atendimento->rascunho);
    }

    private function formOptions(): array
    {
        return [
            'beneficiaries' => $this->selectOptions(Beneficiaria::where('situacao', 'ativo')->orderBy('nome')->pluck('nome', 'id')->all()),
            'professionals' => $this->selectOptions(User::whereIn('perfil', ['administrador', 'enfermeira'])->orderBy('nome')->pluck('nome', 'id')->all()),
            'locations' => $this->selectOptions(LocalAtendimento::orderBy('nome')->pluck('nome', 'id')->all()),
            'statuses' => $this->formStatuses(),
            'modalities' => StoreAttendanceRequest::modalities(),
            'durations' => StoreAttendanceRequest::durations(),
        ];
    }

    private function emptyAttendanceData(): array
    {
        return [
            'id' => null,
            'beneficiary' => '',
            'child' => '',
            'professional' => '',
            'date' => '',
            'time' => '',
            'duration' => '00:45',
            'status' => 'agendado',
            'modality' => 'presencial',
            'location' => '',
            'summary' => '',
            'objective' => '',
            'complaint' => '',
            'evaluation' => '',
            'conduct' => '',
            'notes' => '',
            'rascunho' => false,
        ];
    }

    private function attendanceData(Atendimento $atendimento): array
    {
        $detalhe = $atendimento->detalhe;
        $duration = substr((string) $atendimento->duracao_prevista, 0, 5);

        return [
            'id' => $atendimento->id,
            'beneficiary' => $atendimento->id_beneficiaria,
            'beneficiary_name' => $atendimento->beneficiaria?->nome ?? '',
            'beneficiary_initials' => $this->initials($atendimento->beneficiaria?->nome ?? ''),
            'child' => $atendimento->id_crianca,
            'child_name' => $atendimento->crianca?->nome ?? '-',
            'professional' => $atendimento->id_usuario,
            'professional_name' => $atendimento->usuario?->nome ?? '-',
            'date' => $atendimento->data_hora?->format('Y-m-d') ?? '',
            'formatted_date' => $atendimento->data_hora?->format('d/m/Y') ?? '-',
            'time' => $atendimento->data_hora?->format('H:i') ?? '',
            'duration' => $duration,
            'duration_label' => $this->durationLabel($duration),
            'status' => $atendimento->situacao,
            'status_label' => $this->statusLabel($atendimento->situacao),
            'modality' => $atendimento->modalidade,
            'modality_label' => $this->modalityLabel($atendimento->modalidade),
            'location' => $atendimento->id_local,
            'location_name' => $atendimento->local?->nome ?? 'Sem local informado',
            'cpf' => $this->formatCpf($atendimento->beneficiaria?->cpf ?? ''),
            'phone' => $atendimento->beneficiaria?->telefone ?? '',
            'summary' => $detalhe?->resumo ?? '',
            'objective' => $detalhe?->objetivo ?? '',
            'complaint' => $detalhe?->queixa ?? '',
            'evaluation' => $detalhe?->avaliacao ?? '',
            'conduct' => $detalhe?->conduta ?? '',
            'notes' => $detalhe?->observacao ?? '',
            'rascunho' => $atendimento->rascunho,
        ];
    }

    private function kpis(): array
    {
        $monthQuery = Atendimento::whereBetween('data_hora', [now()->startOfMonth(), now()->endOfMonth()]);

        return [
            ['label' => 'Atendimentos no mês', 'value' => (clone $monthQuery)->where('rascunho', false)->count(), 'context' => 'Registros finalizados no mês atual', 'trend' => null, 'trendType' => 'up', 'icon' => 'content-paste-o', 'tone' => 'rose'],
            ['label' => 'Agendados', 'value' => Atendimento::where('situacao', 'agendado')->count(), 'context' => 'Atendimentos futuros ou pendentes', 'trend' => null, 'trendType' => 'up', 'icon' => 'calendar-month-o', 'tone' => 'blue'],
            ['label' => 'Em andamento', 'value' => Atendimento::where('situacao', 'em_atendimento')->count(), 'context' => 'Atendimentos iniciados pela equipe', 'trend' => null, 'trendType' => 'up', 'icon' => 'check', 'tone' => 'green'],
            ['label' => 'Rascunhos', 'value' => Atendimento::where('rascunho', true)->count(), 'context' => 'Registros ainda não finalizados', 'trend' => null, 'trendType' => 'down', 'icon' => 'edit-o', 'tone' => 'amber'],
        ];
    }

    private function showKpis(Atendimento $atendimento): array
    {
        return [
            ['label' => 'Duração prevista', 'value' => $this->durationLabel(substr((string) $atendimento->duracao_prevista, 0, 5)), 'context' => 'Janela reservada na agenda', 'trend' => null, 'trendType' => 'up', 'icon' => 'schedule-o', 'tone' => 'rose'],
            ['label' => 'Modalidade', 'value' => $this->modalityLabel($atendimento->modalidade), 'context' => $atendimento->local?->nome ?? 'Sem local informado', 'trend' => null, 'trendType' => 'up', 'icon' => 'calendar-month-o', 'tone' => 'blue'],
            ['label' => 'Sessões da beneficiária', 'value' => Atendimento::where('id_beneficiaria', $atendimento->id_beneficiaria)->count(), 'context' => 'Histórico acumulado', 'trend' => null, 'trendType' => 'up', 'icon' => 'content-paste-o', 'tone' => 'green'],
            ['label' => 'Situação', 'value' => $this->statusLabel($atendimento->situacao).($atendimento->rascunho ? ' (Rascunho)' : ''), 'context' => 'Status atual do atendimento', 'trend' => null, 'trendType' => 'down', 'icon' => 'report-problem-o', 'tone' => 'amber'],
        ];
    }

    private function evolution(Atendimento $atendimento): array
    {
        $responsible = $atendimento->usuario?->nome ?? '-';

        return collect([
            ['item' => 'Queixa principal', 'description' => $atendimento->detalhe?->queixa, 'responsible' => $responsible],
            ['item' => 'Avaliação', 'description' => $atendimento->detalhe?->avaliacao, 'responsible' => $responsible],
            ['item' => 'Conduta', 'description' => $atendimento->detalhe?->conduta, 'responsible' => $responsible],
            ['item' => 'Observação', 'description' => $atendimento->detalhe?->observacao, 'responsible' => $responsible],
        ])->filter(fn (array $item) => filled($item['description']))->values()->all();
    }

    private function history(Atendimento $atendimento): array
    {
        return [
            ['date' => $atendimento->created_at->format('d/m/Y'), 'type' => 'Atendimento cadastrado', 'description' => $atendimento->rascunho ? 'Registro salvo como rascunho.' : 'Registro incluído na agenda da equipe.', 'responsible' => $atendimento->usuario?->nome ?? '-', 'icon' => 'calendar-month-o'],
            ['date' => $atendimento->updated_at->format('d/m/Y'), 'type' => 'Última atualização', 'description' => 'Dados administrativos e clínicos revisados.', 'responsible' => $atendimento->usuario?->nome ?? '-', 'icon' => 'content-paste-o'],
        ];
    }

    private function statuses(): array
    {
        return ['agendado' => 'Agendado', 'em_atendimento' => 'Em andamento', 'realizado' => 'Realizado', 'cancelado' => 'Cancelado'];
    }

    private function formStatuses(): array
    {
        return ['agendado' => 'Agendado', 'realizado' => 'Realizado'];
    }

    private function statusLabel(string $status): string
    {
        return $this->statuses()[$status] ?? $status;
    }

    private function modalityLabel(?string $modality): string
    {
        return StoreAttendanceRequest::modalities()[$modality] ?? '-';
    }

    private function durationLabel(?string $duration): string
    {
        return StoreAttendanceRequest::durations()[$duration] ?? '-';
    }

    private function initials(string $name): string
    {
        return collect(explode(' ', trim($name)))->filter()->take(2)->map(fn (string $part) => mb_substr($part, 0, 1))->join('') ?: 'A';
    }

    private function formatCpf(string $cpf): string
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf) ?: $cpf;
    }

    private function selectOptions(array $options): array
    {
        return collect($options)->map(fn (string $label, int|string $value) => ['value' => $value, 'label' => $label])->values()->all();
    }
}
