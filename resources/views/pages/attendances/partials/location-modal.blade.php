<x-app.modal-shell
    dialog-id="attendance-location-create-dialog"
    title="Gerenciar locais"
    description="Cadastre, edite ou inative locais de atendimento."
    max-width="max-w-4xl"
>

        <form action="{{ route('attendances.locations.store') }}" method="POST" class="mt-5 space-y-5 rounded-lg border border-[#f0e7e8] p-4" data-location-form data-location-store-action="{{ route('attendances.locations.store') }}">
            @csrf
            <input type="hidden" name="_method" value="PUT" data-location-method disabled>
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
                <button type="button" data-location-reset class="inline-flex h-10 items-center justify-center rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#344054] hover:bg-[#fbfaf9]">Cancelar</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#ef5b97] px-4 text-sm font-semibold text-white hover:bg-[#d94889]">
                    <x-lucide-save class="h-4 w-4" />
                    <span data-location-submit-label>Salvar local</span>
                </button>
            </div>
        </form>

        <div class="mt-6 max-h-96 overflow-y-auto rounded-lg border border-[#f0e7e8]">
            <table class="w-full min-w-[34rem] text-left text-sm">
                <thead class="sticky top-0 border-b border-[#eadfe0] bg-[#fbfaf9] text-xs uppercase tracking-wide text-[#667085]">
                    <tr>
                        <th class="px-4 py-3 font-semibold">Nome</th>
                        <th class="px-4 py-3 font-semibold">Status</th>
                        <th class="px-4 py-3 text-right font-semibold">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#f0e7e8]">
                    @forelse ($allLocations as $location)
                        @php
                            $address = $location->endereco;
                            $cep = $address?->cep;
                            $formattedCep = $cep ? str_pad((string) $cep->cep, 8, '0', STR_PAD_LEFT) : '';
                        @endphp
                        <tr class="transition hover:bg-[#fff7f9]">
                            <td class="px-4 py-3 font-semibold text-[#111827]">{{ $location->nome }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $location->ativo ? 'bg-[#e8f8ee] text-[#23845a]' : 'bg-[#f4f4f5] text-[#667085]' }}">
                                    {{ $location->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <button type="button" title="Editar local" aria-label="Editar local" data-location-edit data-location-update-action="{{ route('attendances.locations.update', $location) }}" data-location-nome="{{ $location->nome }}" data-location-descricao="{{ $location->descricao }}" data-location-cep="{{ $formattedCep }}" data-location-logradouro="{{ $cep?->logradouro }}" data-location-numero="{{ $address?->numero }}" data-location-complemento="{{ $address?->complemento }}" data-location-bairro="{{ $cep?->bairro }}" data-location-cidade="{{ $cep?->cidade }}" data-location-uf="{{ $cep?->uf }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#e4d8d9] text-[#667085] transition hover:bg-[#fbf1f3] hover:text-[#ef5b97]">
                                        <x-gmdi-edit-o class="h-4 w-4" />
                                    </button>
                                    <button form="location-toggle-{{ $location->id }}" type="submit" title="{{ $location->ativo ? 'Inativar local' : 'Reativar local' }}" aria-label="{{ $location->ativo ? 'Inativar local' : 'Reativar local' }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#e4d8d9] transition {{ $location->ativo ? 'text-[#c2414b] hover:bg-[#fff1f1]' : 'text-[#23845a] hover:bg-[#e8f8ee]' }}">
                                        @if ($location->ativo)
                                            <x-gmdi-delete-o class="h-4 w-4" />
                                        @else
                                            <x-gmdi-check-o class="h-4 w-4" />
                                        @endif
                                    </button>
                                </div>
                                <form id="location-toggle-{{ $location->id }}" action="{{ route('attendances.locations.toggle', $location) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('PATCH')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-sm text-[#667085]">Nenhum local cadastrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
</x-app.modal-shell>
