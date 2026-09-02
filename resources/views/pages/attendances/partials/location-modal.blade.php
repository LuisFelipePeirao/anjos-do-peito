<dialog id="attendance-location-create-dialog" data-dialog-modal class="m-auto w-[calc(100%-2rem)] max-w-4xl rounded-lg border border-[#eadfe0] bg-white p-0 text-[#111827] shadow-[0_24px_70px_rgba(17,24,39,0.22)] backdrop:bg-[#111827]/45">
    <div class="p-5 sm:p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-[#111827]">Gerenciar locais</h2>
                <p class="mt-1 text-sm text-[#667085]">Cadastre, edite ou inative locais de atendimento.</p>
            </div>
            <button type="button" data-dialog-close class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-[#667085] hover:bg-[#f7edef]" aria-label="Fechar">
                <x-gmdi-close-o class="h-5 w-5" />
            </button>
        </div>

        <form action="{{ route('attendances.locations.store') }}" method="POST" class="mt-5 space-y-5 rounded-lg border border-[#f0e7e8] p-4">
            @csrf
            <label class="block">
                <span class="text-sm font-semibold text-[#344054]">Nome</span>
                <input name="nome" type="text" value="{{ old('nome') }}" class="mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="Ex.: Domiciliar, UBS Centro, Google Meet" required>
                @error('nome', 'location') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
            </label>

            <label class="block">
                <span class="text-sm font-semibold text-[#344054]">Descrição</span>
                <textarea name="descricao" class="mt-2 min-h-28 w-full rounded-[8px] border border-[#e4d8d9] px-3 py-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="Observações sobre uso, acesso ou referência do local.">{{ old('descricao') }}</textarea>
                @error('descricao', 'location') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
            </label>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-6">
                <label class="block xl:col-span-2"><span class="text-sm font-semibold text-[#344054]">CEP</span><input type="text" name="cep" value="{{ old('cep') }}" class="mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="00000-000" inputmode="numeric" data-mask="cep" data-cep-input>@error('cep', 'location') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror<span data-cep-feedback class="mt-1 block text-xs text-[#667085]"></span></label>
                <label class="block xl:col-span-3"><span class="text-sm font-semibold text-[#344054]">Rua</span><input type="text" name="logradouro" value="{{ old('logradouro') }}" class="mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="Ex.: Rua das Palmeiras">@error('logradouro', 'location') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</label>
                <label class="block"><span class="text-sm font-semibold text-[#344054]">Número</span><input type="text" name="numero" value="{{ old('numero') }}" class="mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="245"></label>
                <label class="block md:col-span-2"><span class="text-sm font-semibold text-[#344054]">Complemento</span><input type="text" name="complemento" value="{{ old('complemento') }}" class="mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="Casa, sala, referência"></label>
                <label class="block xl:col-span-2"><span class="text-sm font-semibold text-[#344054]">Bairro</span><input type="text" name="bairro" value="{{ old('bairro') }}" class="mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="Centro"></label>
                <label class="block xl:col-span-2"><span class="text-sm font-semibold text-[#344054]">Cidade</span><input type="text" name="cidade" value="{{ old('cidade') }}" class="mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="Cidade">@error('cidade', 'location') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</label>
                <label class="block"><span class="text-sm font-semibold text-[#344054]">UF</span><input type="text" name="uf" value="{{ old('uf') }}" class="mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm uppercase outline-none focus:border-[#ef5b97]" placeholder="SC" maxlength="2">@error('uf', 'location') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</label>
            </div>

            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <button type="button" data-dialog-close class="inline-flex h-10 items-center justify-center rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#344054] hover:bg-[#fbfaf9]">Cancelar</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#ef5b97] px-4 text-sm font-semibold text-white hover:bg-[#d94889]">
                    <x-lucide-save class="h-4 w-4" />
                    Salvar local
                </button>
            </div>
        </form>

        <div class="mt-6 max-h-96 space-y-3 overflow-y-auto pr-1">
            @foreach ($allLocations as $location)
                @php
                    $address = $location->endereco;
                    $cep = $address?->cep;
                @endphp
                <form action="{{ route('attendances.locations.update', $location) }}" method="POST" class="space-y-3 rounded-lg border border-[#f0e7e8] p-3">
                    @csrf
                    @method('PUT')
                    <div class="grid gap-3 md:grid-cols-[1fr_1fr_auto_auto]">
                        <input name="nome" value="{{ $location->nome }}" class="h-11 rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" required>
                        <input name="descricao" value="{{ $location->descricao }}" class="h-11 rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="Descrição opcional">
                        <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#e4d8d9] px-4 text-sm font-semibold hover:bg-[#fbfaf9]">Salvar</button>
                        <button form="location-toggle-{{ $location->id }}" type="submit" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#e4d8d9] px-4 text-sm font-semibold {{ $location->ativo ? 'text-[#c2414b] hover:bg-[#fff1f1]' : 'text-[#23845a] hover:bg-[#e8f8ee]' }}">{{ $location->ativo ? 'Inativar' : 'Reativar' }}</button>
                    </div>
                    <div class="grid gap-3 md:grid-cols-2 xl:grid-cols-6">
                        <input type="text" name="cep" value="{{ $cep ? str_pad((string) $cep->cep, 8, '0', STR_PAD_LEFT) : '' }}" class="h-11 rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="CEP" inputmode="numeric" data-mask="cep" data-cep-input>
                        <input type="text" name="logradouro" value="{{ $cep?->logradouro }}" class="h-11 rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97] xl:col-span-2" placeholder="Rua">
                        <input type="text" name="numero" value="{{ $address?->numero }}" class="h-11 rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="Número">
                        <input type="text" name="bairro" value="{{ $cep?->bairro }}" class="h-11 rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="Bairro">
                        <input type="text" name="cidade" value="{{ $cep?->cidade }}" class="h-11 rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="Cidade">
                        <input type="text" name="uf" value="{{ $cep?->uf }}" class="h-11 rounded-[8px] border border-[#e4d8d9] px-3 text-sm uppercase shadow-sm outline-none focus:border-[#ef5b97]" placeholder="UF" maxlength="2">
                        <input type="text" name="complemento" value="{{ $address?->complemento }}" class="h-11 rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97] md:col-span-2" placeholder="Complemento">
                        <span data-cep-feedback class="text-xs text-[#667085] md:col-span-2"></span>
                    </div>
                </form>
                <form id="location-toggle-{{ $location->id }}" action="{{ route('attendances.locations.toggle', $location) }}" method="POST" class="hidden">
                    @csrf
                    @method('PATCH')
                </form>
            @endforeach
        </div>
    </div>
</dialog>
