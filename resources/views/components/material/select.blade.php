@props([
    'name',
    'label',
    'options' => [],
    'selected' => null,
    'placeholder' => null,
    'wrapperClass' => '',
])

<label @class(['block', $wrapperClass])>
    <span class="block text-sm font-semibold text-[#344054]">{{ $label }}</span>

    <md-outlined-select
        name="{{ $name }}"
        aria-label="{{ $attributes->get('aria-label', $label) }}"
        {{ $attributes->class(['mt-2 w-full'])->except(['aria-label', 'style']) }}
        style="
            height: 44px;
            border-radius: 8px;
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --md-outlined-select-text-field-container-shape: 8px;
            --md-outlined-select-text-field-container-color: #ffffff;
            --md-outlined-select-text-field-outline-color: #e4d8d9;
            --md-outlined-select-text-field-hover-outline-color: #e4d8d9;
            --md-outlined-select-text-field-focus-outline-color: #ef5b97;
            --md-outlined-select-text-field-focus-outline-width: 1px;
            --md-outlined-select-text-field-input-text-color: #111827;
            --md-outlined-select-text-field-input-text-font: Instrument Sans, ui-sans-serif, system-ui, sans-serif;
            --md-outlined-select-text-field-input-text-size: 14px;
            --md-outlined-select-text-field-input-text-line-height: 20px;
            --md-outlined-select-text-field-input-text-weight: 400;
            --md-outlined-select-text-field-trailing-icon-size: 16px;
            --md-outlined-select-text-field-trailing-icon-color: #111827;
            --md-outlined-select-text-field-hover-trailing-icon-color: #111827;
            --md-outlined-select-text-field-focus-trailing-icon-color: #111827;
            --md-outlined-field-top-space: 12px;
            --md-outlined-field-bottom-space: 12px;
            --md-outlined-field-leading-space: 12px;
            --md-outlined-field-trailing-space: 12px;
        "
    >
        @if (! is_null($placeholder))
            <md-select-option value="" @selected(is_null($selected) || (string) $selected === '')>
                <div
                    slot="headline"
                    class="text-sm font-normal leading-5 text-[#111827]"
                    style="font-family: Instrument Sans, ui-sans-serif, system-ui, sans-serif;"
                >
                    {{ $placeholder }}
                </div>
            </md-select-option>
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
                    class="text-sm font-normal leading-5 text-[#111827]"
                    style="font-family: Instrument Sans, ui-sans-serif, system-ui, sans-serif;"
                >
                    {{ $optionLabel }}
                </div>
            </md-select-option>
        @endforeach
    </md-outlined-select>
</label>
