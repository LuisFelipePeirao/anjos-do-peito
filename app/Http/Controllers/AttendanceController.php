<?php

namespace App\Http\Controllers;

use App\Models\Atendimento;
use App\Models\Beneficiaria;
use App\Models\LocalAtendimento;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('q')->trim()->toString();
        $status = $request->string('status', 'all')->toString();
        $modality = $request->string('modality', 'all')->toString();

        $query = Atendimento::query()
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
            ->orderByDesc('data_hora');

        return view('pages.attendances.index', [
            'attendances' => $query->get()->map(fn (Atendimento $atendimento) => [
                'date' => $atendimento->data_hora->format('d/m/Y'),
                'time' => $atendimento->data_hora->format('H:i'),
                'beneficiary' => $atendimento->beneficiaria->nome,
                'professional' => $atendimento->usuario->nome,
                'modality' => $this->modalityLabel($atendimento->modalidade),
                'status' => $this->statusLabel($atendimento->situacao),
                '_actions' => [
                    'view' => route('attendances.show', $atendimento),
                    'items' => [
                        ['icon' => 'visibility-o', 'route' => route('attendances.show', $atendimento), 'title' => 'Visualizar atendimento'],
                        ['icon' => 'edit-o', 'route' => route('attendances.edit', $atendimento), 'title' => 'Editar atendimento'],
                        ['icon' => 'delete-o', 'route' => route('attendances.destroy', $atendimento), 'title' => 'Excluir atendimento', 'variant' => 'danger', 'confirmation' => ['method' => 'DELETE']],
                    ],
                ],
            ]),
            'kpis' => $this->kpis(),
            'search' => $search,
            'status' => $status,
            'modality' => $modality,
        ]);
    }

    public function create(): View
    {
        return view('pages.attendances.form', [
            'mode' => 'create',
            'attendanceData' => $this->emptyAttendanceData(),
            ...$this->formOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedAttendance($request);

        $atendimento = DB::transaction(function () use ($data) {
            $atendimento = Atendimento::create($this->attendanceAttributes($data));
            $atendimento->detalhe()->create($this->detailAttributes($data));

            return $atendimento;
        });

        return redirect()->route('attendances.show', $atendimento)->with('status', 'Atendimento criado com sucesso.');
    }

    public function show(Request $request, Atendimento $attendance): View
    {
        $attendance->load(['beneficiaria.criancas', 'usuario', 'local', 'detalhe']);

        $tab = $request->string('tab', 'overview')->toString();
        $tabs = ['overview', 'evolution', 'history'];

        return view('pages.attendances.show', [
            'attendance' => $attendance,
            'attendanceData' => $this->attendanceData($attendance),
            'kpis' => $this->showKpis($attendance),
            'evolution' => $this->evolution($attendance),
            'history' => $this->history($attendance),
            'tab' => in_array($tab, $tabs, true) ? $tab : 'overview',
        ]);
    }

    public function edit(Atendimento $attendance): View
    {
        $attendance->load(['detalhe', 'local']);

        return view('pages.attendances.form', [
            'mode' => 'edit',
            'attendance' => $attendance,
            'attendanceData' => $this->attendanceData($attendance),
            ...$this->formOptions(),
        ]);
    }

    public function update(Request $request, Atendimento $attendance): RedirectResponse
    {
        $data = $this->validatedAttendance($request);

        DB::transaction(function () use ($attendance, $data) {
            $attendance->update($this->attendanceAttributes($data));
            $attendance->detalhe()->updateOrCreate(
                ['id_atendimento' => $attendance->id],
                $this->detailAttributes($data)
            );
        });

        return redirect()->route('attendances.show', $attendance)->with('status', 'Atendimento atualizado com sucesso.');
    }

    public function start(Atendimento $attendance): RedirectResponse
    {
        abort_unless($attendance->situacao === 'agendado', 409);

        $attendance->update(['situacao' => 'em_atendimento']);

        return redirect()->route('attendances.show', $attendance)->with('status', 'Atendimento iniciado com sucesso.');
    }

    public function destroy(Atendimento $attendance): RedirectResponse
    {
        $attendance->delete();

        return redirect()->route('attendances.index')->with('status', 'Atendimento excluído com sucesso.');
    }

    public function storeLocation(Request $request): RedirectResponse
    {
        $data = $request->validateWithBag('location', [
            'nome' => ['required', 'string', 'max:255', Rule::unique('locais_atendimento', 'nome')],
            'descricao' => ['nullable', 'string'],
        ]);

        LocalAtendimento::create($data);

        return back()->with('status', 'Local de atendimento criado com sucesso.');
    }

    private function validatedAttendance(Request $request): array
    {
        $data = $request->validate([
            'date' => ['required', 'date'],
            'time' => ['required', 'date_format:H:i'],
            'duration' => ['nullable', Rule::in(['00:30', '00:45', '01:00', '01:30'])],
            'status' => ['required', Rule::in(array_keys($this->formStatuses()))],
            'modality' => ['required', Rule::in(array_keys($this->modalities()))],
            'location' => ['required', 'integer', 'exists:locais_atendimento,id'],
            'beneficiary' => ['required', 'integer', 'exists:beneficiarias,id'],
            'professional' => ['required', 'integer', Rule::exists('usuarios', 'id')->where(fn ($query) => $query->whereIn('perfil', ['administrador', 'enfermeira']))],
            'summary' => ['nullable', 'string', 'max:255'],
            'objective' => ['nullable', 'string'],
            'complaint' => ['nullable', 'string'],
            'evaluation' => ['nullable', 'string'],
            'conduct' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        if ($data['status'] === 'agendado') {
            $data = array_merge($data, [
                'summary' => null,
                'objective' => null,
                'complaint' => null,
                'evaluation' => null,
                'conduct' => null,
                'notes' => null,
            ]);
        }

        return $data;
    }

    private function attendanceAttributes(array $data): array
    {
        return [
            'data_hora' => Carbon::parse($data['date'].' '.$data['time']),
            'duracao_prevista' => $data['duration'] ?? null,
            'modalidade' => $data['modality'],
            'id_local' => $data['location'],
            'situacao' => $data['status'],
            'id_beneficiaria' => $data['beneficiary'],
            'id_usuario' => $data['professional'],
        ];
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

    private function formOptions(): array
    {
        return [
            'beneficiaries' => $this->selectOptions(Beneficiaria::where('situacao', 'ativo')->orderBy('nome')->pluck('nome', 'id')->all()),
            'professionals' => $this->selectOptions(User::whereIn('perfil', ['administrador', 'enfermeira'])->orderBy('nome')->pluck('nome', 'id')->all()),
            'locations' => $this->selectOptions(LocalAtendimento::orderBy('nome')->pluck('nome', 'id')->all()),
            'statuses' => $this->formStatuses(),
            'modalities' => $this->modalities(),
            'durations' => $this->durations(),
        ];
    }

    private function emptyAttendanceData(): array
    {
        return [
            'id' => null,
            'beneficiary' => '',
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
        ];
    }

    private function attendanceData(Atendimento $atendimento): array
    {
        $detalhe = $atendimento->detalhe;

        return [
            'id' => $atendimento->id,
            'beneficiary' => $atendimento->id_beneficiaria,
            'beneficiary_name' => $atendimento->beneficiaria?->nome ?? '',
            'beneficiary_initials' => $this->initials($atendimento->beneficiaria?->nome ?? ''),
            'professional' => $atendimento->id_usuario,
            'professional_name' => $atendimento->usuario?->nome ?? '',
            'date' => $atendimento->data_hora->format('Y-m-d'),
            'formatted_date' => $atendimento->data_hora->format('d/m/Y'),
            'time' => $atendimento->data_hora->format('H:i'),
            'duration' => substr((string) $atendimento->duracao_prevista, 0, 5),
            'duration_label' => $this->durationLabel(substr((string) $atendimento->duracao_prevista, 0, 5)),
            'status' => $atendimento->situacao,
            'status_label' => $this->statusLabel($atendimento->situacao),
            'modality' => $atendimento->modalidade,
            'modality_label' => $this->modalityLabel($atendimento->modalidade),
            'location' => $atendimento->id_local,
            'location_name' => $atendimento->local?->nome ?? 'Sem local informado',
            'cpf' => $this->formatCpf($atendimento->beneficiaria?->cpf ?? ''),
            'phone' => $atendimento->beneficiaria?->telefone ?? '',
            'baby_name' => $atendimento->beneficiaria?->criancas->first()?->nome ?? '-',
            'summary' => $detalhe?->resumo ?? '',
            'objective' => $detalhe?->objetivo ?? '',
            'complaint' => $detalhe?->queixa ?? '',
            'evaluation' => $detalhe?->avaliacao ?? '',
            'conduct' => $detalhe?->conduta ?? '',
            'notes' => $detalhe?->observacao ?? '',
        ];
    }

    private function kpis(): array
    {
        $monthQuery = Atendimento::whereBetween('data_hora', [now()->startOfMonth(), now()->endOfMonth()]);

        return [
            ['label' => 'Atendimentos no mês', 'value' => (clone $monthQuery)->count(), 'context' => 'Registros realizados no mês atual', 'trend' => null, 'trendType' => 'up', 'icon' => 'content-paste-o', 'tone' => 'rose'],
            ['label' => 'Agendados', 'value' => Atendimento::where('situacao', 'agendado')->count(), 'context' => 'Atendimentos futuros ou pendentes', 'trend' => null, 'trendType' => 'up', 'icon' => 'calendar-month-o', 'tone' => 'blue'],
            ['label' => 'Em atendimento', 'value' => Atendimento::where('situacao', 'em_atendimento')->count(), 'context' => 'Atendimentos iniciados pela equipe', 'trend' => null, 'trendType' => 'up', 'icon' => 'check', 'tone' => 'green'],
            ['label' => 'Cancelados', 'value' => Atendimento::where('situacao', 'cancelado')->count(), 'context' => 'Atendimentos cancelados', 'trend' => null, 'trendType' => 'down', 'icon' => 'report-problem-o', 'tone' => 'amber'],
        ];
    }

    private function showKpis(Atendimento $atendimento): array
    {
        return [
            ['label' => 'Duração prevista', 'value' => $this->durationLabel(substr((string) $atendimento->duracao_prevista, 0, 5)), 'context' => 'Janela reservada na agenda', 'trend' => null, 'trendType' => 'up', 'icon' => 'schedule-o', 'tone' => 'rose'],
            ['label' => 'Modalidade', 'value' => $this->modalityLabel($atendimento->modalidade), 'context' => $atendimento->local?->nome ?? 'Sem local informado', 'trend' => null, 'trendType' => 'up', 'icon' => 'calendar-month-o', 'tone' => 'blue'],
            ['label' => 'Sessões da beneficiária', 'value' => Atendimento::where('id_beneficiaria', $atendimento->id_beneficiaria)->count(), 'context' => 'Histórico acumulado', 'trend' => null, 'trendType' => 'up', 'icon' => 'content-paste-o', 'tone' => 'green'],
            ['label' => 'Situação', 'value' => $this->statusLabel($atendimento->situacao), 'context' => 'Status atual do atendimento', 'trend' => null, 'trendType' => 'down', 'icon' => 'report-problem-o', 'tone' => 'amber'],
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
            ['date' => $atendimento->created_at->format('d/m/Y'), 'type' => 'Atendimento cadastrado', 'description' => 'Registro incluído na agenda da equipe.', 'responsible' => $atendimento->usuario?->nome ?? '-', 'icon' => 'calendar-month-o'],
            ['date' => $atendimento->updated_at->format('d/m/Y'), 'type' => 'Última atualização', 'description' => 'Dados administrativos e clínicos revisados.', 'responsible' => $atendimento->usuario?->nome ?? '-', 'icon' => 'content-paste-o'],
        ];
    }

    private function statuses(): array
    {
        return ['agendado' => 'Agendado', 'em_atendimento' => 'Em atendimento', 'realizado' => 'Realizado', 'cancelado' => 'Cancelado'];
    }

    private function formStatuses(): array
    {
        return collect($this->statuses())->except('em_atendimento')->all();
    }

    private function modalities(): array
    {
        return ['presencial' => 'Presencial', 'remota' => 'Remota'];
    }

    private function durations(): array
    {
        return ['00:30' => '30 minutos', '00:45' => '45 minutos', '01:00' => '60 minutos', '01:30' => '90 minutos'];
    }

    private function statusLabel(string $status): string
    {
        return $this->statuses()[$status] ?? $status;
    }

    private function modalityLabel(string $modality): string
    {
        return $this->modalities()[$modality] ?? $modality;
    }

    private function durationLabel(?string $duration): string
    {
        return $this->durations()[$duration] ?? '-';
    }

    private function initials(string $name): string
    {
        return collect(explode(' ', trim($name)))
            ->filter()
            ->take(2)
            ->map(fn (string $part) => mb_substr($part, 0, 1))
            ->join('') ?: 'A';
    }

    private function formatCpf(string $cpf): string
    {
        return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf) ?: $cpf;
    }

    private function selectOptions(array $options): array
    {
        return collect($options)
            ->map(fn (string $label, int|string $value) => ['value' => $value, 'label' => $label])
            ->values()
            ->all();
    }
}
