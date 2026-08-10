@extends('layouts.main-pages')

@section('title', 'Nova beneficiária')
@section('active-menu', 'beneficiaries.index')
@section('breadcrumb', 'Beneficiárias')
@section('page-title', 'Nova beneficiária')

@section('content')
    @php
        $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $textareaClass = 'mt-2 min-h-28 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 py-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $labelClass = 'text-sm font-semibold text-[#344054]';
        $hintClass = 'mt-1 text-xs text-[#667085]';
    @endphp

    <section class="space-y-6">
        <x-app.page-info
            subheading="Cadastro de beneficiárias"
            title="Nova beneficiária"
            description="Registre os dados pessoais, contatos, endereço e informações iniciais de acompanhamento."
            :firstButton="[
                'label' => 'Voltar para lista',
                'link' => route('beneficiaries.index'),
                'icon' => 'arrow-left',
            ]" />

        <form method="POST" action="#" class="space-y-6">
            @csrf

            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]">
                            <x-lucide-user-round class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Dados pessoais</h3>
                            <p class="mt-1 text-sm text-[#667085]">Identificação principal da mãe atendida.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-3">
                    <label class="block xl:col-span-2">
                        <span class="{{ $labelClass }}">Nome completo</span>
                        <input type="text" name="name" class="{{ $inputClass }}" placeholder="Ex.: Maria da Silva" required>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">CPF</span>
                        <input type="text" name="cpf" class="{{ $inputClass }}" placeholder="000.000.000-00" inputmode="numeric" required>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Data de nascimento</span>
                        <input type="date" name="birth_date" class="{{ $inputClass }}">
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Nome do bebê</span>
                        <input type="text" name="baby_name" class="{{ $inputClass }}" placeholder="Ex.: Lucas">
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Situação</span>
                        <select name="status" class="{{ $inputClass }}">
                            <option value="Ativa">Ativa</option>
                            <option value="Em triagem">Em triagem</option>
                            <option value="Inativa">Inativa</option>
                        </select>
                    </label>
                </div>
            </article>

            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#eef4ff] text-[#2f66d0]">
                            <x-lucide-phone class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Contato</h3>
                            <p class="mt-1 text-sm text-[#667085]">Canais para retornos, confirmações e acompanhamento.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-3">
                    <label class="block">
                        <span class="{{ $labelClass }}">Telefone principal</span>
                        <input type="tel" name="phone" class="{{ $inputClass }}" placeholder="(00) 00000-0000" required>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Telefone alternativo</span>
                        <input type="tel" name="secondary_phone" class="{{ $inputClass }}" placeholder="(00) 00000-0000">
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">E-mail</span>
                        <input type="email" name="email" class="{{ $inputClass }}" placeholder="nome@email.com">
                    </label>
                </div>
            </article>

            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#ecfdf3] text-[#23845a]">
                            <x-lucide-map-pin class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Endereço</h3>
                            <p class="mt-1 text-sm text-[#667085]">Localização para entregas, visitas e referência territorial.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-6">
                    <label class="block xl:col-span-2">
                        <span class="{{ $labelClass }}">CEP</span>
                        <input type="text" name="zip_code" class="{{ $inputClass }}" placeholder="00000-000" inputmode="numeric">
                    </label>

                    <label class="block xl:col-span-3">
                        <span class="{{ $labelClass }}">Rua</span>
                        <input type="text" name="street" class="{{ $inputClass }}" placeholder="Ex.: Rua das Palmeiras">
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Número</span>
                        <input type="text" name="number" class="{{ $inputClass }}" placeholder="245">
                    </label>

                    <label class="block md:col-span-2 xl:col-span-2">
                        <span class="{{ $labelClass }}">Complemento</span>
                        <input type="text" name="complement" class="{{ $inputClass }}" placeholder="Casa, bloco, ponto de referência">
                    </label>

                    <label class="block xl:col-span-2">
                        <span class="{{ $labelClass }}">Bairro</span>
                        <input type="text" name="district" class="{{ $inputClass }}" placeholder="Centro">
                    </label>

                    <label class="block xl:col-span-2">
                        <span class="{{ $labelClass }}">Cidade</span>
                        <input type="text" name="city" class="{{ $inputClass }}" placeholder="Cidade">
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">UF</span>
                        <select name="state" class="{{ $inputClass }}">
                            <option value="">Selecione</option>
                            @foreach (['AC', 'AL', 'AP', 'AM', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MT', 'MS', 'MG', 'PA', 'PB', 'PR', 'PE', 'PI', 'RJ', 'RN', 'RS', 'RO', 'RR', 'SC', 'SP', 'SE', 'TO'] as $state)
                                <option value="{{ $state }}">{{ $state }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
            </article>

            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fff7e6] text-[#b76b00]">
                            <x-lucide-clipboard-list class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Acompanhamento inicial</h3>
                            <p class="mt-1 text-sm text-[#667085]">Informações úteis para organizar a triagem e o primeiro atendimento.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2">
                    <label class="block">
                        <span class="{{ $labelClass }}">Origem do cadastro</span>
                        <select name="source" class="{{ $inputClass }}">
                            <option value="">Selecione</option>
                            <option value="Busca espontânea">Busca espontânea</option>
                            <option value="Encaminhamento UBS">Encaminhamento UBS</option>
                            <option value="Indicação">Indicação</option>
                            <option value="Ação social">Ação social</option>
                        </select>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Data prevista para primeiro atendimento</span>
                        <input type="date" name="first_attendance_at" class="{{ $inputClass }}">
                    </label>

                    <label class="block md:col-span-2">
                        <span class="{{ $labelClass }}">Observações</span>
                        <textarea name="notes" class="{{ $textareaClass }}" placeholder="Registre necessidades iniciais, disponibilidade de horário ou pontos importantes para a equipe."></textarea>
                        <span class="{{ $hintClass }}">Essas observações ficam disponíveis no perfil da beneficiária.</span>
                    </label>
                </div>
            </article>

            <div class="sticky bottom-0 -mx-4 border-t border-[#eadfe0] bg-[#fbfaf9]/95 px-4 py-4 backdrop-blur md:-mx-8 md:px-8">
                <div class="mx-auto flex max-w-6xl flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-end">
                    <a href="{{ route('beneficiaries.index') }}" class="inline-flex h-11 items-center justify-center rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] bg-[#ef5b97] px-5 text-sm font-semibold text-white shadow-sm transition hover:bg-[#d94889]">
                        <x-lucide-save class="h-4 w-4" />
                        Salvar beneficiária
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection
