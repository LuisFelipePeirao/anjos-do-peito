<dialog id="attendance-procedure-dialog" data-dialog-modal class="m-auto w-[calc(100%-2rem)] max-w-3xl rounded-lg border border-[#eadfe0] bg-white p-0 text-[#111827] shadow-[0_24px_70px_rgba(17,24,39,0.22)] backdrop:bg-[#111827]/45">
    <div class="p-5 sm:p-6">
        <div class="flex items-start justify-between gap-4">
            <div>
                <h2 class="text-lg font-bold text-[#111827]">Gerenciar procedimentos</h2>
                <p class="mt-1 text-sm text-[#667085]">Cadastre, edite ou inative procedimentos.</p>
            </div>
            <button type="button" data-dialog-close class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-[#667085] hover:bg-[#f7edef]" aria-label="Fechar">
                <x-gmdi-close-o class="h-5 w-5" />
            </button>
        </div>

        <form action="{{ route('attendances.procedures.store') }}" method="POST" class="mt-5 grid gap-3 md:grid-cols-[1fr_1fr_auto]">
            @csrf
            <input name="nome" class="{{ $inputClass }}" placeholder="Nome do procedimento" required>
            <input name="descricao" class="{{ $inputClass }}" placeholder="Descrição opcional">
            <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg bg-[#ef5b97] px-4 text-sm font-semibold text-white hover:bg-[#d94889]">Cadastrar</button>
        </form>

        <div class="mt-6 max-h-96 space-y-3 overflow-y-auto pr-1">
            @forelse ($allProcedures as $procedure)
                <form action="{{ route('attendances.procedures.update', $procedure) }}" method="POST" class="grid gap-3 rounded-lg border border-[#f0e7e8] p-3 md:grid-cols-[1fr_1fr_auto_auto]">
                    @csrf
                    @method('PUT')
                    <input name="nome" value="{{ $procedure->nome }}" class="{{ $inputClass }}" required>
                    <input name="descricao" value="{{ $procedure->descricao }}" class="{{ $inputClass }}" placeholder="Descrição opcional">
                    <button type="submit" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#e4d8d9] px-4 text-sm font-semibold hover:bg-[#fbfaf9]">Salvar</button>
                    <button form="procedure-toggle-{{ $procedure->id }}" type="submit" class="inline-flex h-11 items-center justify-center rounded-lg border border-[#e4d8d9] px-4 text-sm font-semibold {{ $procedure->ativo ? 'text-[#c2414b] hover:bg-[#fff1f1]' : 'text-[#23845a] hover:bg-[#e8f8ee]' }}">
                        {{ $procedure->ativo ? 'Inativar' : 'Reativar' }}
                    </button>
                </form>
                <form id="procedure-toggle-{{ $procedure->id }}" action="{{ route('attendances.procedures.toggle', $procedure) }}" method="POST" class="hidden">
                    @csrf
                    @method('PATCH')
                </form>
            @empty
                <p class="rounded-lg border border-dashed border-[#eadfe0] p-4 text-sm text-[#667085]">Nenhum procedimento cadastrado.</p>
            @endforelse
        </div>
    </div>
</dialog>
