@props([
    'name',
    'label',
    'options' => [],
    'selected' => null,
    'icon' => null,
    'wrapperClass' => '',
])

<label @class(['block', $wrapperClass])>
    <span class="mb-1.5 block text-xs font-semibold uppercase text-[#667085]">{{ $label }}</span>

    <md-outlined-select
        name="{{ $name }}"
        aria-label="{{ $attributes->get('aria-label', $label) }}"
        {{ $attributes->class(['w-full'])->except(['aria-label', 'style']) }}
        style="
            height: 44px;
            --md-outlined-select-text-field-container-shape: 8px;
            --md-outlined-select-text-field-outline-color: #e4d8d9;
            --md-outlined-select-text-field-hover-outline-color: #e4d8d9;
            --md-outlined-select-text-field-focus-outline-color: #ef5b97;
            --md-outlined-select-text-field-focus-outline-width: 1px;
            --md-outlined-select-text-field-input-text-color: #111827;
            --md-outlined-select-text-field-input-text-font: Instrument Sans, ui-sans-serif, system-ui, sans-serif;
            --md-outlined-select-text-field-input-text-size: 14px;
            --md-outlined-select-text-field-input-text-line-height: 20px;
            --md-outlined-select-text-field-input-text-weight: 500;
            --md-outlined-select-text-field-leading-icon-size: 16px;
            --md-outlined-select-text-field-trailing-icon-size: 16px;
            --md-outlined-select-text-field-leading-icon-color: #98a2b3;
            --md-outlined-select-text-field-hover-leading-icon-color: #98a2b3;
            --md-outlined-select-text-field-focus-leading-icon-color: #98a2b3;
            --md-outlined-select-text-field-trailing-icon-color: #667085;
            --md-outlined-select-text-field-hover-trailing-icon-color: #667085;
            --md-outlined-select-text-field-focus-trailing-icon-color: #667085;
            --md-outlined-field-top-space: 12px;
            --md-outlined-field-bottom-space: 12px;
            --md-outlined-field-with-leading-content-leading-space: 12px;
            --md-outlined-field-content-space: 12px;
        "
    >
        @if ($icon)
            <x-dynamic-component :component="$icon" slot="leading-icon" class="h-4 w-4 text-[#98a2b3]" />
        @endif

        @foreach ($options as $optionValue => $option)
            @php
                $structuredOption = is_array($option);
                $value = $structuredOption
                    ? ($option['value'] ?? $optionValue)
                    : (is_int($optionValue) ? $option : $optionValue);
                $optionLabel = $structuredOption ? ($option['label'] ?? $value) : $option;
                $disabled = $structuredOption && ($option['disabled'] ?? false);
            @endphp

            <md-select-option
                value="{{ $value }}"
                @selected((string) $selected === (string) $value)
                @disabled($disabled)
            >
                <div
                    slot="headline"
                    class="text-sm font-medium leading-5 text-[#111827]"
                    style="font-family: Instrument Sans, ui-sans-serif, system-ui, sans-serif;"
                >
                    {{ $optionLabel }}
                </div>
            </md-select-option>
        @endforeach
    </md-outlined-select>
</label>
