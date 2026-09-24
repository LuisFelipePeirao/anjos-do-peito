@props([
    'id' => null,
    'label',
    'name',
    'value' => null,
    'placeholder' => '',
    'required' => false,
    'requiredIndicator' => false,
    'wrapperClass' => '',
])

@php
    $textareaId = $id ?? $name;
    $hasError = isset($errors) && $errors->has($name);
    $showRequiredMarker = $required || $requiredIndicator;
@endphp

<div @class(['relative', $wrapperClass])>
    <textarea
        id="{{ $textareaId }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder ?: ' ' }}"
        @if ($required) required @endif
        {{ $attributes->class([
            'peer min-h-28 w-full resize-y rounded-[8px] border bg-white px-3 pb-3 pt-5 text-sm text-[#111827] shadow-sm outline-none transition placeholder:text-transparent focus:placeholder:text-[#98a2b3] focus:ring-2 focus:ring-[#ef5b97]/15',
            'border-[#e4d8d9] focus:border-[#ef5b97]' => ! $hasError,
            'border-[#c2414b] focus:border-[#c2414b] focus:ring-[#c2414b]/15' => $hasError,
        ]) }}
    >{{ $value }}</textarea>

    <label
        for="{{ $textareaId }}"
        class="pointer-events-none absolute left-3 top-0 flex h-11 items-center px-1 text-left text-sm font-semibold text-[#344054] transition-all peer-focus:-top-2.5 peer-focus:h-auto peer-focus:bg-white peer-focus:text-xs peer-focus:text-[#ef5b97] peer-not-placeholder-shown:-top-2.5 peer-not-placeholder-shown:h-auto peer-not-placeholder-shown:bg-white peer-not-placeholder-shown:text-xs"
    >{{ $label }}@if ($showRequiredMarker)<span aria-hidden="true" data-required-indicator="{{ $name }}" class="ml-0.5 text-[#c2414b]">*</span>@endif</label>

    @if ($hasError)
        <span class="mt-1 block text-xs text-[#c2414b]">{{ $errors->first($name) }}</span>
    @endif
</div>
