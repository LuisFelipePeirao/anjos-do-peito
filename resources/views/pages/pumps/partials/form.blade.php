@php
    $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
    $textareaClass = 'mt-2 min-h-28 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 py-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
    $labelClass = 'text-sm font-semibold text-[#344054]';
    $editableStatuses = $hasActiveLoan ? ['alugada' => 'Emprestada'] : collect($statuses)->except('alugada')->all();
@endphp

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
            <input type="text" name="codigo" value="{{ old('codigo', $pumpData['codigo']) }}" class="{{ $inputClass }}" placeholder="Ex.: BL-009" required>
            @error('codigo') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
        </label>

        <div>
            <x-material.select name="id_modelo" label="Modelo" :options="$models" :selected="old('id_modelo', $pumpData['id_modelo'])" placeholder="Selecione" required />
            @error('id_modelo') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
        </div>

        <label class="block">
            <span class="{{ $labelClass }}">Número de série</span>
            <input type="text" name="num_serie" value="{{ old('num_serie', $pumpData['num_serie']) }}" class="{{ $inputClass }}" placeholder="Ex.: SN-2026-009">
            @error('num_serie') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
        </label>

        <div>
            <x-material.select name="situacao" label="Situação" :options="$editableStatuses" :selected="old('situacao', $pumpData['situacao'])" />
            @error('situacao') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
        </div>

        <label class="block">
            <span class="{{ $labelClass }}">Data de aquisição</span>
            <input type="date" name="data_aquisicao" value="{{ old('data_aquisicao', $pumpData['data_aquisicao']) }}" class="{{ $inputClass }}">
            @error('data_aquisicao') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
        </label>

        <div>
            <x-material.select name="origem" label="Origem" :options="$origins" :selected="old('origem', $pumpData['origem'])" placeholder="Selecione" />
            @error('origem') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
        </div>

        <div class="md:col-span-2">
            <x-material.select name="id_doador" label="Doador" :options="$donors" :selected="old('id_doador', $pumpData['id_doador'])" placeholder="Sem doador vinculado" />
            @error('id_doador') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
        </div>

        <label class="block md:col-span-2 xl:col-span-4">
            <span class="{{ $labelClass }}">Itens do kit</span>
            <textarea name="acessorios" class="{{ $textareaClass }}" placeholder="Ex.: motor, frasco, mangueira, conector, fonte, bolsa de transporte.">{{ old('acessorios', $pumpData['acessorios']) }}</textarea>
            @error('acessorios') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
        </label>
    </div>
</article>
