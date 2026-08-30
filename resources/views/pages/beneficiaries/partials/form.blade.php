@php
    $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
    $labelClass = 'text-sm font-semibold text-[#344054]';
    $address = $beneficiaria?->endereco;
    $cep = $address?->cep;
@endphp

<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]"><x-lucide-user-round class="h-5 w-5" /></span><div><h3 class="text-lg font-bold text-[#111827]">Dados pessoais</h3><p class="mt-1 text-sm text-[#667085]">Identificação principal da mãe atendida.</p></div></div></div>
    <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-3">
        <label class="block xl:col-span-2"><span class="{{ $labelClass }}">Nome completo</span><input type="text" name="nome" value="{{ old('nome', $beneficiaria?->nome) }}" class="{{ $inputClass }}" placeholder="Ex.: Maria da Silva" required>@error('nome') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</label>
        <label class="block"><span class="{{ $labelClass }}">CPF</span><input type="text" name="cpf" value="{{ old('cpf', $beneficiaria?->cpf) }}" class="{{ $inputClass }}" placeholder="000.000.000-00" inputmode="numeric" data-mask="cpf" required>@error('cpf') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</label>
    </div>
</article>

<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#eef4ff] text-[#2f66d0]"><x-lucide-phone class="h-5 w-5" /></span><div><h3 class="text-lg font-bold text-[#111827]">Contato e origem</h3><p class="mt-1 text-sm text-[#667085]">Canais de retorno e como a beneficiária chegou à ONG.</p></div></div></div>
    <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-4">
        <label class="block"><span class="{{ $labelClass }}">Telefone principal</span><input type="tel" name="telefone" value="{{ old('telefone', $beneficiaria?->telefone) }}" class="{{ $inputClass }}" placeholder="(00) 00000-0000" inputmode="numeric" data-mask="phone" required>@error('telefone') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</label>
        <label class="block"><span class="{{ $labelClass }}">Telefone alternativo</span><input type="tel" name="telefone_alternativo" value="{{ old('telefone_alternativo', $beneficiaria?->telefone_alternativo) }}" class="{{ $inputClass }}" placeholder="(00) 00000-0000" inputmode="numeric" data-mask="phone">@error('telefone_alternativo') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</label>
        <label class="block"><span class="{{ $labelClass }}">E-mail</span><input type="email" name="email" value="{{ old('email', $beneficiaria?->email) }}" class="{{ $inputClass }}" placeholder="nome@email.com" required>@error('email') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</label>
        <div><x-material.select name="origem_cadastro" label="Origem do cadastro" :options="$origins" :selected="old('origem_cadastro', $beneficiaria?->origem_cadastro)" placeholder="Selecione" required />@error('origem_cadastro') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>
    </div>
</article>

<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#ecfdf3] text-[#23845a]"><x-lucide-map-pin class="h-5 w-5" /></span><div><h3 class="text-lg font-bold text-[#111827]">Endereço</h3><p class="mt-1 text-sm text-[#667085]">Opcional. Informe CEP, cidade e UF ao preencher o endereço.</p></div></div></div>
    <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-6">
        <label class="block xl:col-span-2"><span class="{{ $labelClass }}">CEP</span><input type="text" name="cep" value="{{ old('cep', $cep ? str_pad((string) $cep->cep, 8, '0', STR_PAD_LEFT) : '') }}" class="{{ $inputClass }}" placeholder="00000-000" inputmode="numeric" data-mask="cep" data-cep-input>@error('cep') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror<span data-cep-feedback class="mt-1 block text-xs text-[#667085]"></span></label>
        <label class="block xl:col-span-3"><span class="{{ $labelClass }}">Rua</span><input type="text" name="logradouro" value="{{ old('logradouro', $cep?->logradouro) }}" class="{{ $inputClass }}" placeholder="Ex.: Rua das Palmeiras">@error('logradouro') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</label>
        <label class="block"><span class="{{ $labelClass }}">Número</span><input type="text" name="numero" value="{{ old('numero', $address?->numero) }}" class="{{ $inputClass }}" placeholder="245"></label>
        <label class="block md:col-span-2 xl:col-span-2"><span class="{{ $labelClass }}">Complemento</span><input type="text" name="complemento" value="{{ old('complemento', $address?->complemento) }}" class="{{ $inputClass }}" placeholder="Casa, bloco, ponto de referência"></label>
        <label class="block xl:col-span-2"><span class="{{ $labelClass }}">Bairro</span><input type="text" name="bairro" value="{{ old('bairro', $cep?->bairro) }}" class="{{ $inputClass }}" placeholder="Centro"></label>
        <label class="block xl:col-span-2"><span class="{{ $labelClass }}">Cidade</span><input type="text" name="cidade" value="{{ old('cidade', $cep?->cidade) }}" class="{{ $inputClass }}" placeholder="Cidade">@error('cidade') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</label>
        <div><x-material.select name="uf" label="UF" :options="$states" :selected="old('uf', $cep?->uf)" placeholder="Selecione" />@error('uf') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>
    </div>
</article>
