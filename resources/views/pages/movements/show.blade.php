@extends('layouts.main-pages')

@section('title', $summary['title'])
@section('active-menu', 'movements.index')
@section('breadcrumb', 'Movimentações')
@section('page-title', $summary['title'])

@section('content')
    <section class="space-y-6">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-normal text-[#111827] md:text-3xl">Detalhes da movimentação</h2>
                <p class="mt-1 text-sm text-[#667085]">Informações do lançamento, material e responsável.</p>
            </div>

            <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap lg:justify-end">
                <a href="{{ route('movements.index') }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-[8px] border border-[#e4d8d9] bg-white px-4 text-sm font-semibold text-[#111827] shadow-sm transition hover:bg-[#fbf1f3]">
                    <x-lucide-arrow-left class="h-4 w-4" />
                    Voltar
                </a>
                <a href="{{ route('movements.create') }}" class="inline-flex h-11 items-center justify-center gap-2 rounded-lg bg-[#bf5d6f] px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-[#a94f60]">
                    <x-gmdi-add class="h-4 w-4" />
                    Registrar movimentação
                </a>
            </div>
        </div>

        <article class="rounded-lg border border-[#eadfe0] bg-white p-5 shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
                <div>
                    <dt class="text-xs font-semibold uppercase text-[#667085]">Tipo</dt>
                    <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $summary['type'] }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase text-[#667085]">Data e hora</dt>
                    <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $summary['date'] }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase text-[#667085]">Origem ou destino</dt>
                    <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $summary['origin'] }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-semibold uppercase text-[#667085]">Responsável</dt>
                    <dd class="mt-1 text-sm font-semibold text-[#111827]">{{ $summary['responsible'] }}</dd>
                </div>
                <div class="md:col-span-2 xl:col-span-4">
                    <dt class="text-xs font-semibold uppercase text-[#667085]">Observação</dt>
                    <dd class="mt-1 text-sm text-[#344054]">{{ $summary['observation'] }}</dd>
                </div>
            </div>
        </article>

        <x-tables.datatable
            :header="['Material', 'Categoria', 'Quantidade', 'Tipo']"
            :data="$items"
            :show-actions="false"
        />
    </section>
@endsection
