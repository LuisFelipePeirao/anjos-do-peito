@php
    $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
    $labelClass = 'text-sm font-semibold text-[#344054]';
    $address = $beneficiaria?->endereco;
    $cep = $address?->cep;
@endphp

<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]"><x-lucide-user-round class="h-5 w-5" /></span><div><h3 class="text-lg font-bold text-[#111827]">Dados pessoais</h3><p class="mt-1 text-sm text-[#667085]">Identificação principal da mãe atendida.</p></div></div></div>
    <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-3">
        <x-material.floating-input
            name="nome"
            label="Nome completo"
            :value="old('nome', $beneficiaria?->nome)"
            placeholder="Ex.: Maria da Silva"
            wrapper-class="xl:col-span-2"
            required
        />
        <x-material.floating-input name="cpf" label="CPF" :value="old('cpf', $beneficiaria?->cpf)" placeholder="000.000.000-00" inputmode="numeric" data-mask="cpf" required />
    </div>
</article>

<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#eef4ff] text-[#2f66d0]"><x-lucide-phone class="h-5 w-5" /></span><div><h3 class="text-lg font-bold text-[#111827]">Contato e origem</h3><p class="mt-1 text-sm text-[#667085]">Canais de retorno e como a beneficiária chegou à ONG.</p></div></div></div>
    <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-4">
        <x-material.floating-input type="tel" name="telefone" label="Telefone principal" :value="old('telefone', $beneficiaria?->telefone)" placeholder="(00) 00000-0000" inputmode="numeric" data-mask="phone" required />
        <x-material.floating-input type="tel" name="telefone_alternativo" label="Telefone alternativo" :value="old('telefone_alternativo', $beneficiaria?->telefone_alternativo)" placeholder="(00) 00000-0000" inputmode="numeric" data-mask="phone" />
        <x-material.floating-input type="email" name="email" label="E-mail" :value="old('email', $beneficiaria?->email)" placeholder="nome@email.com" required />
        <div><x-material.select name="origem_cadastro" label="Origem do cadastro" :options="$origins" :selected="old('origem_cadastro', $beneficiaria?->origem_cadastro)" placeholder="Selecione" required />@error('origem_cadastro') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>
    </div>
</article>

<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#ecfdf3] text-[#23845a]"><x-lucide-map-pin class="h-5 w-5" /></span><div><h3 class="text-lg font-bold text-[#111827]">Endereço</h3><p class="mt-1 text-sm text-[#667085]">Opcional. Informe CEP, cidade e UF ao preencher o endereço.</p></div></div></div>
    <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-6">
        <div class="xl:col-span-2"><x-material.floating-input name="cep" label="CEP" :value="old('cep', $cep ? str_pad((string) $cep->cep, 8, '0', STR_PAD_LEFT) : '')" placeholder="00000-000" inputmode="numeric" data-mask="cep" data-cep-input /><span data-cep-feedback class="mt-1 block text-xs text-[#667085]"></span></div>
        <x-material.floating-input name="logradouro" label="Rua" :value="old('logradouro', $cep?->logradouro)" placeholder="Ex.: Rua das Palmeiras" wrapper-class="xl:col-span-3" />
        <x-material.floating-input name="numero" label="Número" :value="old('numero', $address?->numero)" placeholder="245" />
        <x-material.floating-input name="complemento" label="Complemento" :value="old('complemento', $address?->complemento)" placeholder="Casa, bloco, ponto de referência" wrapper-class="md:col-span-2 xl:col-span-2" />
        <x-material.floating-input name="bairro" label="Bairro" :value="old('bairro', $cep?->bairro)" placeholder="Centro" wrapper-class="xl:col-span-2" />
        <x-material.floating-input name="cidade" label="Cidade" :value="old('cidade', $cep?->cidade)" placeholder="Cidade" wrapper-class="xl:col-span-2" />
        <div><x-material.select name="uf" label="UF" :options="$states" :selected="old('uf', $cep?->uf)" placeholder="Selecione" />@error('uf') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>
    </div>
</article>
