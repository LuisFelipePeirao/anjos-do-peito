@extends('layouts.main-pages')

@section('title', 'Nova bomba de leite')
@section('active-menu', 'pumps.index')
@section('breadcrumb', 'Bombas de leite')
@section('page-title', 'Nova bomba de leite')

@section('content')
    @php
        $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $textareaClass = 'mt-2 min-h-28 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 py-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $labelClass = 'text-sm font-semibold text-[#344054]';
        $hintClass = 'mt-1 text-xs text-[#667085]';
    @endphp

    <section class="space-y-6">
        <x-app.page-info
            subheading="Cadastro de bombas"
            title="Nova bomba de leite"
            description="Registre identificação, origem, localização e dados de manutenção do equipamento."
            :firstButton="[
                'label' => 'Voltar para lista',
                'link' => route('pumps.index'),
                'icon' => 'arrow-left',
            ]" />

        <form method="POST" action="#" class="space-y-6">
            @csrf

            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]">
                            <x-lucide-milk class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Identificação</h3>
                            <p class="mt-1 text-sm text-[#667085]">Dados principais para controle interno da bomba.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-4">
                    <label class="block">
                        <span class="{{ $labelClass }}">Código patrimonial</span>
                        <input type="text" name="code" class="{{ $inputClass }}" placeholder="Ex.: BP-009" required>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Modelo</span>
                        <select name="model" class="{{ $inputClass }}" required>
                            <option value="">Selecione</option>
                            @foreach ($models as $model)
                                <option value="{{ $model }}">{{ $model }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Número de série</span>
                        <input type="text" name="serial_number" class="{{ $inputClass }}" placeholder="Ex.: MDL-2026-009">
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Situação</span>
                        <select name="status" class="{{ $inputClass }}">
                            @foreach ($statuses as $status)
                                <option value="{{ $status }}" @selected($status === 'Disponível')>{{ $status }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Data de entrada</span>
                        <input type="date" name="received_at" class="{{ $inputClass }}">
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Valor da Mensalidade</span>
                        <input type="text" name="monthly_fee" class="{{ $inputClass }}" placeholder="Ex.: R$ 100,00" inputmode="decimal" required>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Origem</span>
                        <select name="origin" class="{{ $inputClass }}">
                            <option value="">Selecione</option>
                            <option value="Doação">Doação</option>
                            <option value="Compra">Compra</option>
                            <option value="Repasse">Repasse</option>
                        </select>
                    </label>

                    <label class="block md:col-span-2 xl:col-span-3">
                        <span class="{{ $labelClass }}">Itens do kit</span>
                        <textarea name="kit_items" class="{{ $textareaClass }}" placeholder="Ex.: motor, frasco, mangueira, conector, fonte, bolsa de transporte."></textarea>
                        <span class="{{ $hintClass }}">Use este campo para registrar acessórios entregues junto com a bomba.</span>
                    </label>
                </div>
            </article>

            <div class="sticky bottom-0 -mx-4 border-t border-[#eadfe0] bg-[#fbfaf9]/95 px-4 py-4 backdrop-blur md:-mx-8 md:px-8">
                <div class="mx-auto flex max-w-6xl flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('pumps.index') }}" class="inline-flex h-11 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] bg-[#ef5b97] px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#d94889]">
                        <x-lucide-save class="h-4 w-4" />
                        Salvar bomba
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection
