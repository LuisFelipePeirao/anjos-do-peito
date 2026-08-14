@props([
    'type' => 'text',
    'label',
    'name' => null,
    'value' => null,
    'wrapperClass' => '',
])

<div @class(['mb-8', $wrapperClass])>
    <md-filled-text-field
        type="{{ $type }}"
        label="{{ $label }}"
        aria-label="{{ $attributes->get('aria-label', $label) }}"
        @if ($name) name="{{ $name }}" @endif
        @if (! is_null($value)) value="{{ $value }}" @endif
        {{ $attributes->class(['block w-full'])->except(['aria-label', 'style']) }}
        style="
            height: 56px;
            --md-filled-text-field-container-color: transparent;
            --md-filled-text-field-container-shape: 0px;
            --md-filled-text-field-hover-state-layer-color: transparent;
            --md-filled-text-field-hover-state-layer-opacity: 0;
            --md-filled-text-field-active-indicator-color: #8590ad;
            --md-filled-text-field-hover-active-indicator-color: #8590ad;
            --md-filled-text-field-focus-active-indicator-color: #ef5b97;
            --md-filled-text-field-active-indicator-height: 1px;
            --md-filled-text-field-hover-active-indicator-height: 1px;
            --md-filled-text-field-focus-active-indicator-height: 1px;
            --md-filled-text-field-input-text-color: #ef5b97;
            --md-filled-text-field-hover-input-text-color: #ef5b97;
            --md-filled-text-field-focus-input-text-color: #ef5b97;
            --md-filled-text-field-caret-color: #ef5b97;
            --md-filled-text-field-focus-caret-color: #ef5b97;
            --md-filled-text-field-input-text-font: Instrument Sans, ui-sans-serif, system-ui, sans-serif;
            --md-filled-text-field-input-text-size: 19.2px;
            --md-filled-text-field-input-text-line-height: 24px;
            --md-filled-text-field-input-text-weight: 400;
            --md-filled-text-field-label-text-color: #8590ad;
            --md-filled-text-field-hover-label-text-color: #8590ad;
            --md-filled-text-field-focus-label-text-color: #ef5b97;
            --md-filled-text-field-label-text-font: Instrument Sans, ui-sans-serif, system-ui, sans-serif;
            --md-filled-text-field-label-text-size: 16px;
            --md-filled-text-field-label-text-line-height: 24px;
            --md-filled-text-field-label-text-populated-size: 14px;
            --md-filled-text-field-label-text-populated-line-height: 20px;
            --md-filled-text-field-label-text-weight: 400;
            --md-filled-text-field-leading-icon-color: #8590ad;
            --md-filled-text-field-hover-leading-icon-color: #8590ad;
            --md-filled-text-field-focus-leading-icon-color: #ef5b97;
            --md-filled-text-field-leading-icon-size: 24px;
            --md-filled-text-field-with-leading-icon-leading-space: 0px;
            --md-filled-text-field-icon-input-space: 14px;
            --md-filled-text-field-trailing-space: 0px;
        "
    >
        @if (isset($icon))
            <span slot="leading-icon" class="flex h-6 w-6 items-center justify-center text-2xl">
                {{ $icon }}
            </span>
        @endif
    </md-filled-text-field>
</div>
