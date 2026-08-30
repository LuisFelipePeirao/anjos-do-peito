@extends('layouts.main-pages')

@section('title', 'Continuar atendimento')
@section('active-menu', 'attendances.index')
@section('breadcrumb', 'Atendimentos')
@section('page-title', 'Continuar atendimento')

@section('content')
    @php
        $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $textareaClass = 'mt-2 min-h-28 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 py-3 text-sm text-[#111827] shadow-sm outline-none transition focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
    @endphp

    <section class="space-y-6">
        <x-app.page-info subheading="Gestão de atendimentos" title="Continuar atendimento" description="Complete o registro clínico deste atendimento em andamento." :firstButton="['label' => 'Voltar aos detalhes', 'link' => route('attendances.show', $attendance), 'icon' => 'arrow-left']" />

        <article class="rounded-[8px] border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <h3 class="text-lg font-bold text-[#111827]">Informações do atendimento</h3>
            <dl class="mt-5 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                @foreach ([
                    'Beneficiária' => $attendanceData['beneficiary_name'], 'Criança' => $attendanceData['child_name'], 'Profissional' => $attendanceData['professional_name'],
                    'Data e horário' => $attendanceData['formatted_date'].' às '.$attendanceData['time'], 'Duração' => $attendanceData['duration_label'], 'Modalidade' => $attendanceData['modality_label'], 'Local' => $attendanceData['location_name'],
                ] as $label => $value)
                    <div><dt class="text-xs font-semibold uppercase text-[#667085]">{{ $label }}</dt><dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $value }}</dd></div>
                @endforeach
            </dl>
        </article>

        <form method="POST" action="{{ route('attendances.continue.save', $attendance) }}" class="space-y-6" data-attendance-continuation-form>
            @csrf
            @method('PUT')
            <input type="hidden" name="confirmed_finalization" value="0" data-attendance-finalization-confirmation>
            @include('pages.attendances.partials.clinical-fields', ['attendanceData' => $attendanceData, 'textareaClass' => $textareaClass, 'inputClass' => $inputClass])
            <div class="sticky bottom-0 -mx-4 border-t border-[#eadfe0] bg-[#fbfaf9]/95 px-4 py-4 backdrop-blur md:-mx-8 md:px-8"><div class="mx-auto flex max-w-6xl flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                <a href="{{ route('attendances.show', $attendance) }}" class="inline-flex h-11 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">Cancelar</a>
                <button type="submit" name="save_as" value="draft" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-5 text-sm font-semibold text-[#344054] shadow-sm transition hover:bg-[#fbf1f3]"><x-lucide-file-pen-line class="h-4 w-4" /> Salvar rascunho</button>
                <button type="submit" name="save_as" value="final" data-attendance-final-submit class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] bg-[#ef5b97] px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#d94889]"><x-lucide-save class="h-4 w-4" /> Salvar atendimento</button>
            </div></div>
        </form>

        <x-app.confirm-modal id="attendance-finalize-confirmation" title="Finalizar atendimento?" message="Após salvar, as informações deste atendimento realizado não poderão mais ser editadas." confirm-label="Finalizar atendimento" cancel-label="Continuar editando" variant="warning" />
    </section>
@endsection
