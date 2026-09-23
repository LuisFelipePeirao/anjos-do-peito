@props([
    'dialogId',
    'title',
    'description',
    'storeAction',
    'updateRoute',
    'toggleRoute',
    'items',
    'entityLabel',
    'namePlaceholder',
    'emptyMessage',
    'inputClass',
    'errorBag',
])

<x-app.modal-shell :dialog-id="$dialogId" :title="$title" :description="$description" :entity-label="$entityLabel">

        <form action="{{ $storeAction }}" method="POST" class="mt-5 space-y-4 rounded-lg border border-[#f0e7e8] p-4" data-entity-form data-entity-store-action="{{ $storeAction }}" data-entity-fields="nome,descricao">
            @csrf
            <input type="hidden" name="_method" value="PUT" data-entity-method disabled>
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <x-material.floating-input name="nome" label="Nome" :value="old('nome')" :placeholder="$namePlaceholder" required />
                    @error('nome', $errorBag) <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                </div>
                <div>
                    <x-material.floating-input name="descricao" label="Descrição" :value="old('descricao')" placeholder="Descrição opcional" />
                    @error('descricao', $errorBag) <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
                <button type="button" data-entity-reset class="inline-flex h-10 items-center justify-center rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#344054] hover:bg-[#fbfaf9]">Cancelar</button>
                <button type="submit" class="inline-flex h-10 items-center justify-center gap-2 rounded-lg bg-[#ef5b97] px-4 text-sm font-semibold text-white hover:bg-[#d94889]">
                    <x-lucide-save class="h-4 w-4" />
                    <span data-entity-submit-label>Salvar {{ $entityLabel }}</span>
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
                    @forelse ($items as $item)
                        <tr class="transition hover:bg-[#fff7f9]">
                            <td class="px-4 py-3 font-semibold text-[#111827]">{{ $item->nome }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $item->ativo ? 'bg-[#e8f8ee] text-[#23845a]' : 'bg-[#f4f4f5] text-[#667085]' }}">
                                    {{ $item->ativo ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <button type="button" title="Editar {{ $entityLabel }}" aria-label="Editar {{ $entityLabel }}" data-entity-edit data-entity-update-action="{{ route($updateRoute, $item) }}" data-entity-nome="{{ $item->nome }}" data-entity-descricao="{{ $item->descricao }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#e4d8d9] text-[#667085] transition hover:bg-[#fbf1f3] hover:text-[#ef5b97]">
                                        <x-gmdi-edit-o class="h-4 w-4" />
                                    </button>
                                    <button form="{{ $dialogId }}-toggle-{{ $item->id }}" type="submit" title="{{ $item->ativo ? 'Inativar' : 'Reativar' }} {{ $entityLabel }}" aria-label="{{ $item->ativo ? 'Inativar' : 'Reativar' }} {{ $entityLabel }}" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#e4d8d9] transition {{ $item->ativo ? 'text-[#c2414b] hover:bg-[#fff1f1]' : 'text-[#23845a] hover:bg-[#e8f8ee]' }}">
                                        @if ($item->ativo)
                                            <x-gmdi-delete-o class="h-4 w-4" />
                                        @else
                                            <x-gmdi-check-o class="h-4 w-4" />
                                        @endif
                                    </button>
                                </div>
                                <form id="{{ $dialogId }}-toggle-{{ $item->id }}" action="{{ route($toggleRoute, $item) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('PATCH')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-sm text-[#667085]">{{ $emptyMessage }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
</x-app.modal-shell>
