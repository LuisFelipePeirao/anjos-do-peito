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
            <div><x-material.floating-input name="nome" label="Nome" :value="old('nome')" placeholder="Ex.: Campanha Solidária" required />@error('nome', 'donor') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>

            <div><x-material.floating-input name="telefone" label="Telefone" :value="old('telefone')" placeholder="Ex.: (47) 99999-0000" />@error('telefone', 'donor') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>

            <div class="md:col-span-2"><x-material.floating-input type="email" name="email" label="E-mail" :value="old('email')" placeholder="Ex.: doador@email.com" />@error('email', 'donor') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>

            <div class="md:col-span-2"><x-material.floating-textarea name="observacao" label="Observação" :value="old('observacao')" placeholder="Observações sobre contato, campanha ou preferências do doador." class="min-h-32" />@error('observacao', 'donor') <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror</div>
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
