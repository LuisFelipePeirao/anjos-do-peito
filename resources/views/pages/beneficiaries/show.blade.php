@extends('layouts.main-pages')

@section('title', $beneficiaria->nome)
@section('active-menu', 'beneficiaries.index')
@section('breadcrumb', 'Beneficiárias')
@section('page-title', $beneficiaria->nome)

@section('content')
    @php
        $isActive = $beneficiaria->situacao === 'ativo';
        $initials = collect(explode(' ', $beneficiaria->nome))->filter()->take(2)->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))->join('');
        $address = $beneficiaria->endereco;
        $cep = $address?->cep;
        $addressLine = $cep ? collect([$cep->logradouro, $address->numero, $cep->bairro, $cep->cidade . '/' . $cep->uf])->filter()->join(', ') : 'Não informado';
        $tabs = [
            'overview' => 'Visão geral',
            'attendances' => 'Atendimentos',
            'pumps' => 'Bombas',
            'donations' => 'Doações',
            'history' => 'Histórico',
            'babies' => 'Bebês',
        ];
    @endphp

    <section class="space-y-6">
        @if (session('status'))
            <div class="rounded-[8px] border border-[#b8e6c8] bg-[#effcf4] px-4 py-3 text-sm font-medium text-[#23845a]">{{ session('status') }}</div>
        @endif

        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div><h2 class="text-2xl font-bold text-[#111827] md:text-3xl">{{ $beneficiaria->nome }}</h2><p class="mt-1 text-sm text-[#667085]">Todas as informações da beneficiária reunidas em um único perfil.</p></div>
            <div class="flex flex-wrap gap-3 lg:justify-end">
                <a href="{{ route('beneficiaries.edit', $beneficiaria) }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]"><x-lucide-pencil class="h-4 w-4" /> Editar cadastro</a>
                @if ($isActive)
                    <button type="button" data-confirm-dialog-open="beneficiary-deactivate" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#c2414b] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#a93640]"><x-lucide-ban class="h-4 w-4" /> Inativar beneficiária</button>
                @endif
            </div>
        </div>

        <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <div class="grid gap-5 lg:grid-cols-[auto_minmax(0,1fr)]">
                <div class="flex items-start gap-4"><div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-full bg-[#fdecef] text-xl font-bold text-[#8f4050]">{{ $initials }}</div><div><div class="flex flex-wrap items-center gap-3"><h3 class="text-xl font-bold text-[#111827]">{{ $beneficiaria->nome }}</h3><span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-semibold {{ $isActive ? 'bg-[#dff7e8] text-[#23845a]' : 'bg-[#fff1f1] text-[#c2414b]' }}"><x-lucide-circle-check class="h-3.5 w-3.5" /> {{ $isActive ? 'Ativa' : 'Inativa' }}</span></div></div></div>
                <dl class="grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
                    <div><dt class="text-xs font-semibold uppercase text-[#667085]">CPF</dt><dd class="mt-1 text-sm font-semibold text-[#111827]">{{ preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $beneficiaria->cpf) }}</dd></div>
                    <div><dt class="text-xs font-semibold uppercase text-[#667085]">Telefone</dt><dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $beneficiaria->telefone }}</dd></div>
                    <div><dt class="text-xs font-semibold uppercase text-[#667085]">E-mail</dt><dd class="mt-1 break-all text-sm font-semibold text-[#111827]">{{ $beneficiaria->email }}</dd></div>
                    <div><dt class="text-xs font-semibold uppercase text-[#667085]">Telefone alternativo</dt><dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $beneficiaria->telefone_alternativo ?: '-' }}</dd></div>
                    <div><dt class="text-xs font-semibold uppercase text-[#667085]">Origem do cadastro</dt><dd class="mt-1 text-sm font-semibold text-[#111827]">{{ str($beneficiaria->origem_cadastro)->replace('_', ' ')->title() }}</dd></div>
                    <div><dt class="text-xs font-semibold uppercase text-[#667085]">Data de cadastro</dt><dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $beneficiaria->created_at->format('d/m/Y') }}</dd></div>
                </dl>
            </div>
        </article>

        <nav class="border-b border-[#eadfe0]">
            <div class="flex gap-6 overflow-x-auto">
                @foreach ($tabs as $key => $label)
                    <a href="{{ route('beneficiaries.show', ['beneficiaria' => $beneficiaria, 'tab' => $key]) }}" class="shrink-0 border-b-2 px-1 py-4 text-sm font-medium transition {{ $tab === $key ? 'border-[#bf5d6f] text-[#bf5d6f]' : 'border-transparent text-[#4b5563] hover:text-[#bf5d6f]' }}">{{ $label }}</a>
                @endforeach
            </div>
        </nav>

        @if ($tab === 'overview')
        <article class="overflow-hidden rounded-lg border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]"><div class="border-b border-[#f0e7e8] p-5"><div class="flex items-start gap-3"><span class="flex h-10 w-10 items-center justify-center rounded-[8px] bg-[#ecfdf3] text-[#23845a]"><x-lucide-map-pin class="h-5 w-5" /></span><div><h3 class="text-lg font-bold text-[#111827]">Endereço</h3><p class="mt-1 text-sm text-[#667085]">{{ $addressLine }}</p></div></div></div>@if ($cep)<dl class="grid gap-5 p-5 sm:grid-cols-2 xl:grid-cols-4"><div><dt class="text-xs font-semibold uppercase text-[#667085]">CEP</dt><dd class="mt-1 text-sm font-semibold text-[#111827]">{{ substr(str_pad((string) $cep->cep, 8, '0', STR_PAD_LEFT), 0, 5) . '-' . substr(str_pad((string) $cep->cep, 8, '0', STR_PAD_LEFT), 5) }}</dd></div><div><dt class="text-xs font-semibold uppercase text-[#667085]">Logradouro</dt><dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $cep->logradouro ?: '-' }}</dd></div><div><dt class="text-xs font-semibold uppercase text-[#667085]">Bairro</dt><dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $cep->bairro ?: '-' }}</dd></div><div><dt class="text-xs font-semibold uppercase text-[#667085]">Complemento</dt><dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $address->complemento ?: '-' }}</dd></div></dl>@endif</article>

        @endif

        @if ($tab === 'babies')
        <article id="bebes" class="overflow-hidden rounded-lg border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <div class="flex flex-col gap-3 border-b border-[#f0e7e8] p-5 sm:flex-row sm:items-center sm:justify-between"><div><h3 class="text-lg font-bold text-[#111827]">Bebês</h3><p class="mt-1 text-sm text-[#667085]">Crianças vinculadas a esta beneficiária.</p></div><button type="button" data-dialog-open="child-create-dialog" class="inline-flex h-10 items-center justify-center gap-2 rounded-[8px] bg-[#ef5b97] px-4 text-sm font-semibold text-white transition hover:bg-[#d94889]"><x-gmdi-add class="h-4 w-4" /> Cadastrar bebê</button></div>
            <div class="overflow-x-auto"><table class="w-full min-w-150 text-left text-sm"><thead class="border-b border-[#eadfe0] bg-[#fbfaf9] text-xs uppercase tracking-wide text-[#667085]"><tr><th class="px-5 py-4 font-semibold">Nome</th><th class="px-5 py-4 font-semibold">Data de nascimento</th><th class="px-5 py-4 font-semibold">Sexo</th><th class="px-5 py-4 text-right font-semibold">Ações</th></tr></thead><tbody class="divide-y divide-[#f0e7e8]">@forelse ($beneficiaria->criancas as $crianca)<tr class="transition hover:bg-[#fff7f9]"><th class="px-5 py-4 font-semibold text-[#111827]">{{ $crianca->nome }}</th><td class="px-5 py-4 text-[#344054]">{{ $crianca->data_nascimento->format('d/m/Y') }}</td><td class="px-5 py-4 text-[#344054]">{{ $sexOptions[$crianca->sexo] }}</td><td class="px-5 py-4"><div class="flex justify-end gap-2"><a href="{{ route('beneficiaries.show', ['beneficiaria' => $beneficiaria, 'tab' => 'babies', 'editar_crianca' => $crianca->id]) }}#bebes" title="Editar bebê" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#e4d8d9] text-[#667085] transition hover:bg-[#fbf1f3] hover:text-[#ef5b97]"><x-gmdi-edit-o class="h-4 w-4" /></a><button type="button" data-confirm-dialog-open="child-delete-{{ $crianca->id }}" title="Excluir bebê" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-[#e4d8d9] text-[#c2414b] transition hover:bg-[#fff1f1]"><x-gmdi-delete-o class="h-4 w-4" /></button></div><x-app.confirm-modal :id="'child-delete-' . $crianca->id" title="Excluir bebê?" message="O vínculo desta criança será removido. Deseja continuar?" confirm-label="Excluir bebê" :action="route('beneficiaries.children.destroy', [$beneficiaria, $crianca])" method="DELETE" /></td></tr>@empty<tr><td colspan="4" class="px-5 py-12 text-center text-sm text-[#667085]">Nenhum bebê vinculado a esta beneficiária.</td></tr>@endforelse</tbody></table></div>
        </article>
        @endif

        @if (in_array($tab, ['attendances', 'pumps', 'donations'], true))
            @php
                $sectionNames = ['attendances' => 'Atendimentos', 'pumps' => 'Bombas', 'donations' => 'Doações'];
            @endphp
            <article class="rounded-[8px] border border-[#eadfe0] bg-white p-10 text-center shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <x-lucide-inbox class="mx-auto h-8 w-8 text-[#98a2b3]" />
                <h3 class="mt-3 text-lg font-bold text-[#111827]">Nenhum registro de {{ mb_strtolower($sectionNames[$tab]) }}</h3>
                <p class="mt-1 text-sm text-[#667085]">Os registros vinculados a esta beneficiária aparecerão nesta aba.</p>
            </article>
        @elseif ($tab === 'history')
            <article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
                <div class="border-b border-[#f0e7e8] p-5"><h3 class="text-lg font-bold text-[#111827]">Histórico da beneficiária</h3><p class="mt-1 text-sm text-[#667085]">Movimentações e registros relacionados ao cadastro.</p></div>
                <div class="p-5"><div class="flex gap-3"><div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-[#f0dadd] bg-white text-[#bf5d6f]"><x-lucide-user-plus class="h-4 w-4" /></div><div><p class="text-xs font-semibold text-[#667085]">{{ $beneficiaria->created_at->format('d/m/Y') }}</p><p class="mt-1 text-sm font-bold text-[#111827]">Cadastro realizado</p><p class="mt-1 text-sm text-[#667085]">Beneficiária cadastrada no sistema da ONG.</p></div></div></div>
            </article>
        @endif
    </section>

    @include('pages.beneficiaries.partials.child-modal', ['id' => 'child-create-dialog', 'title' => 'Cadastrar bebê', 'action' => route('beneficiaries.children.store', $beneficiaria), 'child' => null, 'method' => 'POST'])
    @if ($childToEdit)
        @include('pages.beneficiaries.partials.child-modal', ['id' => 'child-edit-dialog', 'title' => 'Editar bebê', 'action' => route('beneficiaries.children.update', [$beneficiaria, $childToEdit]), 'child' => $childToEdit, 'method' => 'PUT'])
    @endif
    @if ($isActive)<x-app.confirm-modal id="beneficiary-deactivate" title="Inativar beneficiária?" message="O cadastro e seus vínculos serão preservados, mas ela deixará de constar como ativa. Deseja continuar?" confirm-label="Inativar beneficiária" :action="route('beneficiaries.deactivate', $beneficiaria)" method="PATCH" />@endif
@endsection

@push('scripts')
    @if ($childToEdit || $errors->hasAny(['nome', 'data_nascimento', 'sexo']))
        <script>document.addEventListener('DOMContentLoaded', () => document.getElementById(@json($childToEdit ? 'child-edit-dialog' : 'child-create-dialog'))?.showModal());</script>
    @endif
@endpush
