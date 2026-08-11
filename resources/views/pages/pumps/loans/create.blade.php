@extends('layouts.main-pages')

@section('title', 'Registrar empréstimo')
@section('active-menu', 'pumps.index')
@section('breadcrumb', 'Bombas de leite')
@section('page-title', 'Registrar empréstimo')

@section('content')
    @php
        $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $textareaClass = 'mt-2 min-h-28 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 py-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
        $labelClass = 'text-sm font-semibold text-[#344054]';
        $hintClass = 'mt-1 text-xs text-[#667085]';
    @endphp

    <section class="space-y-6">
        <x-app.page-info
            subheading="Movimentação de bombas"
            title="Registrar saída de bomba"
            description="Escolha se a bomba será emprestada sem custo ou alugada com cobrança mensal."
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
                            <x-lucide-handshake class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Tipo de contrato</h3>
                            <p class="mt-1 text-sm text-[#667085]">Defina se haverá cobrança mensal ou se a saída será gratuita.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-4 p-5 md:grid-cols-2">
                    <label class="flex h-full cursor-pointer flex-col rounded-[8px] border border-[#eadfe0] bg-white p-4 transition has-[:checked]:border-[#ef5b97] has-[:checked]:bg-[#fff7f9]">
                        <span class="flex items-start gap-3">
                            <input type="radio" name="contract_type" value="emprestimo" class="mt-1 h-4 w-4 border-[#d0d5dd] text-[#ef5b97] focus:ring-[#ef5b97]" data-pump-contract-type checked>
                            <span>
                                <span class="block text-base font-bold text-[#111827]">Empréstimo</span>
                                <span class="mt-1 block text-sm leading-6 text-[#667085]">Saída sem cobrança mensal, usada quando a ONG apenas empresta a bomba para a beneficiária.</span>
                            </span>
                        </span>
                        <span class="mt-4 inline-flex w-fit rounded-full bg-[#e8f8ee] px-2.5 py-1 text-xs font-semibold text-[#23845a]">Sem custo</span>
                    </label>

                    <label class="flex h-full cursor-pointer flex-col rounded-[8px] border border-[#eadfe0] bg-white p-4 transition has-[:checked]:border-[#ef5b97] has-[:checked]:bg-[#fff7f9]">
                        <span class="flex items-start gap-3">
                            <input type="radio" name="contract_type" value="aluguel" class="mt-1 h-4 w-4 border-[#d0d5dd] text-[#ef5b97] focus:ring-[#ef5b97]" data-pump-contract-type>
                            <span>
                                <span class="block text-base font-bold text-[#111827]">Aluguel</span>
                                <span class="mt-1 block text-sm leading-6 text-[#667085]">Saída com mensalidade definida, vencimento recorrente e controle de pagamento.</span>
                            </span>
                        </span>
                        <span class="mt-4 inline-flex w-fit rounded-full bg-[#eef4ff] px-2.5 py-1 text-xs font-semibold text-[#2f66d0]">Com mensalidade</span>
                    </label>
                </div>
            </article>

            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#eef4ff] text-[#2f66d0]">
                            <x-lucide-milk class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Bomba e beneficiária</h3>
                            <p class="mt-1 text-sm text-[#667085]">Selecione o equipamento disponível e a pessoa responsável pelo empréstimo.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-3">
                    <label class="block">
                        <span class="{{ $labelClass }}">Bomba disponível</span>
                        <select name="pump" class="{{ $inputClass }}" required>
                            <option value="">Selecione</option>
                            @foreach ($availablePumps as $pump)
                                <option value="{{ $pump['code'] }}">{{ $pump['code'] }} - {{ $pump['model'] }}</option>
                            @endforeach
                        </select>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Beneficiária</span>
                        <select name="beneficiary" class="{{ $inputClass }}" required>
                            <option value="">Selecione</option>
                            @foreach ($beneficiaries as $beneficiary)
                                <option value="{{ $beneficiary }}">{{ $beneficiary }}</option>
                            @endforeach
                        </select>
                    </label>

                </div>
            </article>

            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#ecfdf3] text-[#23845a]">
                            <x-lucide-calendar-days class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Prazo e retirada</h3>
                            <p class="mt-1 text-sm text-[#667085]">Datas de retirada e previsão de devolução.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-4">
                    <label class="block">
                        <span class="{{ $labelClass }}">Data de retirada</span>
                        <input type="date" name="withdrawn_at" class="{{ $inputClass }}" required>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Devolução prevista</span>
                        <input type="date" name="expected_return" class="{{ $inputClass }}" required>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Renovação</span>
                        <select name="renewal" class="{{ $inputClass }}">
                            <option value="Sem renovação automática">Sem renovação automática</option>
                            <option value="A cada 30 dias">A cada 30 dias</option>
                            <option value="A cada 60 dias">A cada 60 dias</option>
                        </select>
                    </label>

                </div>
            </article>

            <article class="hidden overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]" data-pump-billing-section>
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fff7e6] text-[#b76b00]">
                            <x-lucide-receipt class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Dados do aluguel</h3>
                            <p class="mt-1 text-sm text-[#667085]">Preencha estes campos quando o tipo selecionado for aluguel.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-4">
                    <label class="block">
                        <span class="{{ $labelClass }}">Mensalidade</span>
                        <input type="text" name="monthly_fee" class="{{ $inputClass }}" placeholder="Ex.: R$ 100,00" inputmode="decimal" data-pump-billing-field disabled>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Dia de vencimento</span>
                        <input type="number" name="due_day" class="{{ $inputClass }}" placeholder="Ex.: 10" min="1" max="31" data-pump-billing-field disabled>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Forma de cobrança</span>
                        <select name="billing_method" class="{{ $inputClass }}" data-pump-billing-field disabled>
                            <option value="">Selecione</option>
                            <option value="Pix">Pix</option>
                            <option value="Dinheiro">Dinheiro</option>
                            <option value="Boleto">Boleto</option>
                        </select>
                    </label>

                    <label class="block">
                        <span class="{{ $labelClass }}">Primeira cobrança</span>
                        <input type="date" name="first_billing_at" class="{{ $inputClass }}" data-pump-billing-field disabled>
                    </label>

                    <label class="block md:col-span-2 xl:col-span-4">
                        <span class="{{ $labelClass }}">Observações financeiras</span>
                        <textarea name="billing_notes" class="{{ $textareaClass }}" placeholder="Registre combinações de pagamento, isenção parcial, atraso negociado ou orientação administrativa." data-pump-billing-field disabled></textarea>
                        <span class="{{ $hintClass }}">Para remover o custo, selecione a opção "Empréstimo" no início do formulário.</span>
                    </label>
                </div>
            </article>
            

            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5">
                    <div class="flex items-start gap-3">
                        <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]">
                            <x-lucide-file-check-2 class="h-5 w-5" />
                        </span>
                        <div>
                            <h3 class="text-lg font-bold text-[#111827]">Termos e entrega</h3>
                            <p class="mt-1 text-sm text-[#667085]">Confirmações importantes para segurança da beneficiária e controle da ONG.</p>
                        </div>
                    </div>
                </div>

                <div class="grid gap-5 p-5 md:grid-cols-2">
                    <label class="block">
                        <span class="{{ $labelClass }}">Gerar termo para assinatura?</span>
                        <select name="term_signed" class="{{ $inputClass }}">
                            <option value="Sim">Sim</option>
                            <option value="Não">Não</option>
                        </select>
                    </label>

                    <label class="block md:col-span-2">
                        <span class="{{ $labelClass }}">Observações do contrato</span>
                        <textarea name="notes" class="{{ $textareaClass }}" placeholder="Registre cuidados combinados, restrições, contatos alternativos ou orientações para acompanhamento."></textarea>
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
                        Registrar saída
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection
