<dialog
    id="donation-donor-create-dialog"
    data-dialog-modal
    @if ($errors->donor->any()) data-dialog-auto-open @endif
    class="m-auto w-[calc(100%-2rem)] max-w-2xl rounded-lg border border-[#eadfe0] bg-white p-0 text-[#111827] shadow-[0_24px_70px_rgba(17,24,39,0.22)] backdrop:bg-[#111827]/45"
>
    <form action="{{ route('donations.donors.store') }}" method="POST" class="p-5 sm:p-6">
        @csrf
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-[#111827]">Cadastrar doador</h2>
                <p class="mt-1 text-sm text-[#667085]">Informe os dados do doador para registrar novas entradas.</p>
            </div>
            <button type="button" data-dialog-close class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-[#667085] hover:bg-[#f7edef]" aria-label="Fechar">
                <x-gmdi-close-o class="h-5 w-5" />
            </button>
        </div>

        <div class="mt-5 grid gap-5 md:grid-cols-2">
            <label class="block">
                <span class="text-sm font-semibold text-[#344054]">Nome</span>
                <input name="nome" type="text" value="{{ old('nome') }}" class="mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="Ex.: Campanha Solidária" required>
                @error('nome', 'donor') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
            </label>

            <label class="block">
                <span class="text-sm font-semibold text-[#344054]">Telefone</span>
                <input name="telefone" type="text" value="{{ old('telefone') }}" class="mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="Ex.: (47) 99999-0000">
                @error('telefone', 'donor') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
            </label>

            <label class="block md:col-span-2">
                <span class="text-sm font-semibold text-[#344054]">E-mail</span>
                <input name="email" type="email" value="{{ old('email') }}" class="mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] px-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="Ex.: doador@email.com">
                @error('email', 'donor') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
            </label>

            <label class="block md:col-span-2">
                <span class="text-sm font-semibold text-[#344054]">Observação</span>
                <textarea name="observacao" class="mt-2 min-h-32 w-full rounded-[8px] border border-[#e4d8d9] px-3 py-3 text-sm shadow-sm outline-none focus:border-[#ef5b97]" placeholder="Observações sobre contato, campanha ou preferências do doador.">{{ old('observacao') }}</textarea>
                @error('observacao', 'donor') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
            </label>
        </div>

        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <button type="button" data-dialog-close class="inline-flex h-10 items-center justify-center rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#344054] hover:bg-[#fbfaf9]">Cancelar</button>
            <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#ef5b97] px-4 text-sm font-semibold text-white hover:bg-[#d94889]">
                <x-lucide-save class="h-4 w-4" />
                Salvar doador
            </button>
        </div>
    </form>
</dialog>
