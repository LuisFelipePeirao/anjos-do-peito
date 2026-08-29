@extends('layouts.main-pages')

@section('title', $mode === 'edit' ? 'Editar atendimento' : 'Novo atendimento')
@section('active-menu', 'attendances.index')
@section('breadcrumb', 'Atendimentos')
@section('page-title', $mode === 'edit' ? 'Editar atendimento' : 'Novo atendimento')

@section('content')
    @php
        $isEdit = $mode === 'edit';
        $title = $isEdit ? 'Editar atendimento' : 'Novo atendimento';
        $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $textareaClass = 'mt-2 min-h-28 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 py-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $selectedStatus = old('status', $attendanceData['status']);
        $clinicalVisible = $selectedStatus === 'realizado';
        $formAction = $isEdit ? route('attendances.update', $attendance) : route('attendances.store');
        $cancelRoute = $isEdit ? route('attendances.show', $attendance) : route('attendances.index');
        $childEndpoint = route('attendances.children.index', ['beneficiaria' => '__beneficiary__']);
    @endphp

    <section class="space-y-6">
        <x-app.page-info
            subheading="Gestão de atendimentos"
            :title="$title"
            :description="$isEdit ? 'Atualize os dados deste rascunho ou agendamento.' : 'Registre a agenda ou inclua um atendimento já realizado.'"
            :firstButton="['label' => 'Voltar para lista', 'link' => route('attendances.index'), 'icon' => 'arrow-left']" />

        <form method="POST" action="{{ $formAction }}" class="space-y-6" data-attendance-form data-children-endpoint="{{ $childEndpoint }}">
            @csrf
            @if ($isEdit) @method('PUT') @endif
            <input type="hidden" name="confirmed_finalization" value="0" data-attendance-finalization-confirmation>

            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]"><x-lucide-calendar-days class="h-5 w-5" /></span><div><h3 class="text-lg font-bold text-[#111827]">Agenda</h3><p class="mt-1 text-sm text-[#667085]">Data, horário, modalidade e situação do atendimento.</p></div></div></div>
                <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-4">
                    <label class="block"><span class="text-sm font-semibold text-[#344054]">Data</span><input type="date" name="date" value="{{ old('date', $attendanceData['date']) }}" class="{{ $inputClass }}">@error('date') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</label>
                    <label class="block"><span class="text-sm font-semibold text-[#344054]">Horário</span><input type="time" name="time" value="{{ old('time', $attendanceData['time']) }}" class="{{ $inputClass }}">@error('time') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</label>
                    <div><x-material.select name="duration" label="Duração prevista" :options="$durations" :selected="old('duration', $attendanceData['duration'])" />@error('duration') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>
                    <div>
                        @if ($isEdit)
                            <input type="hidden" name="status" value="{{ $selectedStatus }}">
                            <x-material.select name="status_display" label="Situação" :options="[$selectedStatus => $attendanceData['status_label']]" :selected="$selectedStatus" disabled data-attendance-status-select data-initial-status="{{ $selectedStatus }}" />
                        @else
                            <x-material.select name="status" label="Situação" :options="$statuses" :selected="$selectedStatus" data-attendance-status-select data-initial-status="{{ $selectedStatus }}" />
                        @endif
                        @error('status') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                    </div>
                    <div><x-material.select name="modality" label="Modalidade" :options="$modalities" :selected="old('modality', $attendanceData['modality'])" />@error('modality') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>
                    <div><x-material.select name="location" label="Local" :options="$locations" :selected="old('location', $attendanceData['location'])" placeholder="Selecionar local cadastrado" />@error('location') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>
                </div>
            </article>

            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#eef4ff] text-[#2f66d0]"><x-lucide-users class="h-5 w-5" /></span><div><h3 class="text-lg font-bold text-[#111827]">Participantes</h3><p class="mt-1 text-sm text-[#667085]">Beneficiária, criança vinculada e profissional responsável.</p></div></div></div>
                <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-3">
                    <div><x-material.select name="beneficiary" label="Beneficiária" :options="$beneficiaries" :selected="old('beneficiary', $attendanceData['beneficiary'])" placeholder="Selecione" required data-attendance-beneficiary />@error('beneficiary') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>
                    <div><x-material.select name="child" label="Criança" :options="[]" :selected="old('child', $attendanceData['child'])" placeholder="Nenhuma criança vinculada" data-attendance-child data-initial-child="{{ old('child', $attendanceData['child']) }}" />@error('child') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>
                    <div><x-material.select name="professional" label="Profissional" :options="$professionals" :selected="old('professional', $attendanceData['professional'])" placeholder="Selecione" />@error('professional') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>
                </div>
            </article>

            <div data-attendance-clinical-fields @class(['space-y-6', 'hidden' => ! $clinicalVisible])>
                @include('pages.attendances.partials.clinical-fields', ['attendanceData' => $attendanceData, 'textareaClass' => $textareaClass, 'inputClass' => $inputClass])
            </div>

            <div class="sticky bottom-0 -mx-4 border-t border-[#eadfe0] bg-[#fbfaf9]/95 px-4 py-4 backdrop-blur md:-mx-8 md:px-8"><div class="mx-auto flex max-w-6xl flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                <a href="{{ $cancelRoute }}" class="inline-flex h-11 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">Cancelar</a>
                <button type="submit" name="save_as" value="draft" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-5 text-sm font-semibold text-[#344054] shadow-sm transition hover:bg-[#fbf1f3]"><x-lucide-file-pen-line class="h-4 w-4" /> Salvar rascunho</button>
                <button type="submit" name="save_as" value="final" data-attendance-final-submit class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] bg-[#ef5b97] px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#d94889]"><x-lucide-save class="h-4 w-4" /> {{ $isEdit ? 'Salvar alterações' : 'Salvar atendimento' }}</button>
            </div></div>
        </form>

        <x-app.confirm-modal id="attendance-finalize-confirmation" title="Finalizar atendimento realizado?" message="Após salvar, as informações deste atendimento realizado não poderão mais ser editadas." confirm-label="Finalizar atendimento" cancel-label="Continuar editando" variant="warning" />
    </section>
@endsection
