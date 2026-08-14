@props([
    'name' => 'q',
    'label' => 'Pesquisar',
    'value' => '',
    'placeholder' => 'Pesquisar',
    'wrapperClass' => '',
])

<label @class(['min-w-0', $wrapperClass])>
    <span class="mb-1.5 block text-xs font-semibold uppercase text-[#667085]">{{ $label }}</span>

    <md-outlined-text-field
        type="search"
        name="{{ $name }}"
        value="{{ $value }}"
        placeholder="{{ $placeholder }}"
        aria-label="{{ $attributes->get('aria-label', $label) }}"
        {{ $attributes->class([
            'block w-full rounded-lg transition',
            'focus-within:ring-3 focus-within:ring-[#fdecef]',
        ])->except(['aria-label', 'style']) }}
        style="
            height: 44px;
            background-color: #ffffff;
            --md-outlined-text-field-container-shape: 8px;
            --md-outlined-text-field-outline-color: #e4d8d9;
            --md-outlined-text-field-outline-width: 1px;
            --md-outlined-text-field-hover-outline-color: #e4d8d9;
            --md-outlined-text-field-hover-outline-width: 1px;
            --md-outlined-text-field-focus-outline-color: #ef5b97;
            --md-outlined-text-field-focus-outline-width: 1px;
            --md-outlined-text-field-input-text-color: #111827;
            --md-outlined-text-field-hover-input-text-color: #111827;
            --md-outlined-text-field-focus-input-text-color: #111827;
            --md-outlined-text-field-caret-color: #ef5b97;
            --md-outlined-text-field-focus-caret-color: #ef5b97;
            --md-outlined-text-field-input-text-placeholder-color: #98a2b3;
            --md-outlined-text-field-input-text-font: Instrument Sans, ui-sans-serif, system-ui, sans-serif;
            --md-outlined-text-field-input-text-size: 14px;
            --md-outlined-text-field-input-text-line-height: 20px;
            --md-outlined-text-field-input-text-weight: 400;
            --md-outlined-text-field-leading-icon-color: #98a2b3;
            --md-outlined-text-field-hover-leading-icon-color: #98a2b3;
            --md-outlined-text-field-focus-leading-icon-color: #98a2b3;
            --md-outlined-text-field-leading-icon-size: 16px;
            --md-outlined-text-field-with-leading-icon-leading-space: 12px;
            --md-outlined-text-field-icon-input-space: 12px;
            --md-outlined-text-field-trailing-space: 12px;
            --md-outlined-text-field-top-space: 12px;
            --md-outlined-text-field-bottom-space: 12px;
        "
    >
        <x-gmdi-search-o slot="leading-icon" class="h-4 w-4" />
    </md-outlined-text-field>
</label>
