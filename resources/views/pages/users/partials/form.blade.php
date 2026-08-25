@php
    $inputClass = 'mt-2 h-11 w-full rounded-[8px] border border-[#e4d8d9] bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-[#98a2b3] focus:border-[#ef5b97] focus:ring-2 focus:ring-[#ef5b97]/15';
    $labelClass = 'text-sm font-semibold text-[#344054]';
    $hintClass = 'mt-1 text-xs text-[#667085]';
    $profileOptions = collect($profiles)
        ->map(fn ($profile) => ['value' => $profile, 'label' => ucfirst($profile)])
        ->all();
@endphp

<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5">
        <div class="flex items-start gap-3">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fdecef] text-[#ef5b97]">
                <x-lucide-user-round class="h-5 w-5" />
            </span>
            <div>
                <h3 class="text-lg font-bold text-[#111827]">Dados do usuário</h3>
                <p class="mt-1 text-sm text-[#667085]">Identificação da pessoa que terá acesso ao sistema.</p>
            </div>
        </div>
    </div>

    <div class="grid gap-5 p-5 md:grid-cols-2 xl:grid-cols-3">
        <label class="block xl:col-span-2">
            <span class="{{ $labelClass }}">Nome completo</span>
            <input
                type="text"
                name="nome"
                value="{{ old('nome', $user?->nome) }}"
                class="{{ $inputClass }}"
                placeholder="Ex.: Maria da Silva"
                required
            >
            @error('nome')
                <span class="mt-2 block text-sm font-medium text-red-600">{{ $message }}</span>
            @enderror
        </label>

        <label class="block">
            <span class="{{ $labelClass }}">E-mail</span>
            <input
                type="email"
                name="email"
                value="{{ old('email', $user?->email) }}"
                class="{{ $inputClass }}"
                placeholder="nome@email.com"
                required
            >
            @error('email')
                <span class="mt-2 block text-sm font-medium text-red-600">{{ $message }}</span>
            @enderror
        </label>
    </div>
</article>

<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5">
        <div class="flex items-start gap-3">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#eef4ff] text-[#2f66d0]">
                <x-lucide-shield-check class="h-5 w-5" />
            </span>
            <div>
                <h3 class="text-lg font-bold text-[#111827]">Perfil de acesso</h3>
                <p class="mt-1 text-sm text-[#667085]">Defina o nível de permissão da pessoa dentro da equipe.</p>
            </div>
        </div>
    </div>

    <div class="grid gap-5 p-5 md:grid-cols-2">
        <div>
            <x-material.select
                name="perfil"
                label="Perfil"
                :options="$profileOptions"
                :selected="old('perfil', $user?->perfil)"
                required
            />

            @error('perfil')
                <span class="mt-2 block text-sm font-medium text-red-600">{{ $message }}</span>
            @enderror
        </div>
    </div>
</article>

<article class="overflow-hidden rounded-[8px] border border-[#eadfe0] bg-white shadow-[0_14px_35px_rgba(28,25,23,0.05)]">
    <div class="border-b border-[#f0e7e8] p-5">
        <div class="flex items-start gap-3">
            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-[8px] bg-[#fff7e6] text-[#b76b00]">
                <x-lucide-lock-keyhole class="h-5 w-5" />
            </span>
            <div>
                <h3 class="text-lg font-bold text-[#111827]">Senha</h3>
                <p class="mt-1 text-sm text-[#667085]">
                    {{ $user ? 'Preencha apenas se quiser alterar a senha atual.' : 'Crie a senha inicial para o primeiro acesso.' }}
                </p>
            </div>
        </div>
    </div>

    <div class="grid gap-5 p-5 md:grid-cols-2">
        <label class="block">
            <span class="{{ $labelClass }}">Senha</span>
            <input
                type="password"
                name="senha"
                class="{{ $inputClass }}"
                placeholder="Digite a senha"
                @if (! $user) required @endif
            >
            @error('senha')
                <span class="mt-2 block text-sm font-medium text-red-600">{{ $message }}</span>
            @enderror
        </label>

        <label class="block">
            <span class="{{ $labelClass }}">Confirmar senha</span>
            <input
                type="password"
                name="senha_confirmation"
                class="{{ $inputClass }}"
                placeholder="Repita a senha"
                @if (! $user) required @endif
            >
        </label>
    </div>
</article>
