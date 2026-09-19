@props([
    'type' => 'text',
    'id' => null,
    'label',
    'name',
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'wrapperClass' => '',
])

@php
    $inputId = $id ?? $name;
    $hasError = $errors->has($name);
@endphp

<div @class(['relative', $wrapperClass])>
    <input
        id="{{ $inputId }}"
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        @if ($required) required @endif
        {{ $attributes->class([
            'peer h-11 w-full rounded-[8px] border bg-white px-3 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-transparent focus:placeholder:text-[#98a2b3] focus:ring-2 focus:ring-[#ef5b97]/15',
            'border-[#e4d8d9] focus:border-[#ef5b97]' => ! $hasError,
            'border-[#c2414b] focus:border-[#c2414b] focus:ring-[#c2414b]/15' => $hasError,
        ]) }}
    >

    <label
        for="{{ $inputId }}"
        class="pointer-events-none absolute left-3 top-0 flex h-11 items-center px-1 text-left text-sm font-semibold text-[#344054] transition-all peer-focus:-top-2.5 peer-focus:h-auto peer-focus:bg-white peer-focus:text-xs peer-focus:text-[#ef5b97] peer-not-placeholder-shown:-top-2.5 peer-not-placeholder-shown:h-auto peer-not-placeholder-shown:bg-white peer-not-placeholder-shown:text-xs"
    >{{ $label }}@if ($required)<span aria-hidden="true" class="ml-0.5 text-[#c2414b]">*</span>@endif</label>

    @error($name)
        <span class="mt-1 block text-xs text-[#c2414b]">{{ $message }}</span>
    @enderror
</div>
