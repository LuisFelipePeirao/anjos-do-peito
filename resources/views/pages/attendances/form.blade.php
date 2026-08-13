@extends('layouts.main-pages')

@section('title', $mode === 'edit' ? 'Editar atendimento' : 'Novo atendimento')
@section('active-menu', 'attendances.index')
@section('breadcrumb', 'Atendimentos')
@section('page-title', $mode === 'edit' ? 'Editar atendimento' : 'Novo atendimento')

@section('content')
    @php
        $isEdit = $mode === 'edit';
        $title = $isEdit ? 'Editar atendimento' : 'Novo atendimento';
        $description = $isEdit
            ? 'Atualize agenda, evolução, conduta e encaminhamentos deste atendimento.'
            : 'Registre a agenda, a equipe responsável e as primeiras informações do atendimento.';
        $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $textareaClass = 'mt-2 min-h-28 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 py-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $labelClass = 'text-sm font-semibold text-[#344054]';
    @endphp

    <section class="space-y-6">
        <x-app.page-info
            subheading="Gestão de atendimentos"
            :title="$title"
            :description="$description"
            :firstButton="[
                'label' => 'Voltar para lista',
                'link' => route('attendances.index'),
                'icon' => 'arrow-left',
            ]" />

        <form method="POST" action="#" class="space-y-6">
            @csrf
            @if ($isEdit)
                @method('PUT')
            @endif

            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]">
                            <x-lucide-calendar-days class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Agenda</h3>
                            <p class="mt-1 text-sm text-[#667085]">Data, horário, modalidade e situação do atendimento.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-4">
                    <label class="block">
                        <span class="{{ $labelClass }}">Data</span>
                        <input type="date" name="date" value="{{ $attendanceData['date'] }}" class="{{ $inputClass }}" required>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Horário</span>
                        <input type="time" name="time" value="{{ $attendanceData['time'] }}" class="{{ $inputClass }}" required>
                    </label>

                    <x-material.select
                        name="duration"
                        label="Duração prevista"
                        :options="collect(['30', '45', '60', '90'])->map(fn ($duration) => [
                            'value' => $duration,
                            'label' => $duration.' minutos',
                        ])->all()"
                        :selected="$attendanceData['duration']"
                    />

                    <x-material.select
                        name="status"
                        label="Situação"
                        :options="['Agendado', 'Realizado', 'Retorno pendente', 'Cancelado']"
                        :selected="$attendanceData['status']"
                    />

                    <x-material.select
                        name="modality"
                        label="Modalidade"
                        :options="['Presencial', 'Remota']"
                        :selected="$attendanceData['modality']"
                        wrapper-class="md:col-span-2"
                    />

                    <x-material.select
                        name="location"
                        label="Local"
                        :options="$locations"
                        :selected="$attendanceData['location']"
                        placeholder="Selecione"
                        wrapper-class="md:col-span-2"
                    />
                </div>
            </article>

            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#eef4ff] text-[#2f66d0]">
                            <x-lucide-users class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Participantes</h3>
                            <p class="mt-1 text-sm text-[#667085]">Beneficiária atendida e profissional responsável.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-3">
                    <x-material.select
                        name="beneficiary"
                        label="Beneficiária"
                        :options="$beneficiaries"
                        :selected="$attendanceData['beneficiary']"
                        placeholder="Selecione"
                        required
                    />

                    <x-material.select
                        name="professional"
                        label="Profissional"
                        :options="$professionals"
                        :selected="$attendanceData['professional']"
                        placeholder="Selecione"
                        required
                    />

                    <x-material.select
                        name="priority"
                        label="Prioridade"
                        :options="['Baixa', 'Média', 'Alta']"
                        :selected="$attendanceData['priority']"
                    />
                </div>
            </article>

            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#ecfdf3] text-[#23845a]">
                            <x-lucide-clipboard-list class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Registro clínico</h3>
                            <p class="mt-1 text-sm text-[#667085]">Resumo, objetivo, avaliação e conduta definida pela equipe.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2">
                    <label class="block md:col-span-2">
                        <span class="{{ $labelClass }}">Resumo</span>
                        <input type="text" name="summary" value="{{ $attendanceData['summary'] }}" class="{{ $inputClass }}" placeholder="Ex.: Orientações sobre amamentação e pega correta">
                    </label>

                    <label class="block md:col-span-2">
                        <span class="{{ $labelClass }}">Objetivo</span>
                        <textarea name="objective" class="{{ $textareaClass }}" placeholder="Descreva o objetivo principal do atendimento.">{{ $attendanceData['objective'] }}</textarea>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Queixa principal</span>
                        <textarea name="complaint" class="{{ $textareaClass }}" placeholder="Registre a principal demanda apresentada.">{{ $attendanceData['complaint'] }}</textarea>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Avaliação</span>
                        <textarea name="evaluation" class="{{ $textareaClass }}" placeholder="Registre observações e avaliação da equipe.">{{ $attendanceData['evaluation'] }}</textarea>
                    </label>

                    <label class="block md:col-span-2">
                        <span class="{{ $labelClass }}">Conduta</span>
                        <textarea name="conduct" class="{{ $textareaClass }}" placeholder="Descreva orientações, decisões e cuidados combinados.">{{ $attendanceData['conduct'] }}</textarea>
                    </label>
                </div>
            </article>

            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fff7e6] text-[#b76b00]">
                            <x-lucide-forward class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Retorno e encaminhamentos</h3>
                            <p class="mt-1 text-sm text-[#667085]">Defina próximos passos e informações internas para acompanhamento.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2">
                    <label class="block">
                        <span class="{{ $labelClass }}">Data de retorno</span>
                        <input type="date" name="return_date" value="{{ $attendanceData['return_date'] }}" class="{{ $inputClass }}">
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Encaminhamento</span>
                        <input type="text" name="referral" value="{{ $attendanceData['referral'] }}" class="{{ $inputClass }}" placeholder="Ex.: Retorno agendado, UBS, material educativo">
                    </label>

                    <label class="block md:col-span-2">
                        <span class="{{ $labelClass }}">Observações internas</span>
                        <textarea name="notes" class="{{ $textareaClass }}" placeholder="Notas para a equipe, lembretes e informações complementares.">{{ $attendanceData['notes'] }}</textarea>
                    </label>
                </div>
            </article>

            <div class="sticky bottom-0 -mx-4 border-t border-[#eadfe0] bg-[#fbfaf9]/95 px-4 py-4 backdrop-blur md:-mx-8 md:px-8">
                <div class="mx-auto flex max-w-6xl flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ $isEdit ? route('attendances.show', $attendanceData['id']) : route('attendances.index') }}" class="inline-flex h-11 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] bg-[#ef5b97] px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#d94889]">
                        <x-lucide-save class="h-4 w-4" />
                        {{ $isEdit ? 'Salvar alterações' : 'Salvar atendimento' }}
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection
