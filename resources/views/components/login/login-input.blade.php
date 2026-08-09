@props([
    'type' => 'text',
    'icon', 
    'label',
    'placeholder' => '',
    ])

<div
    class="group relative mb-8 grid min-h-14 grid-cols-[7%_93%] items-center border-b border-[#8590AD] py-1 focus-within:border-[#ef5b97]">
    <div class="text-2xl text-[#8590AD] transition duration-300 group-focus-within:text-[#ef5b97]">
        @if (isset($icon))
            {{ $icon }}
        @endif
    </div>

    <div class="relative h-12">
        <input type="{{ $type }}" placeholder=" "
            class="peer absolute left-0 top-0 h-full w-full border-none bg-transparent px-3 pb-1 pt-5 text-[1.2rem] text-[#ef5b97] outline-none">
        <label for=""
            class="absolute left-3 top-1/2 -translate-y-1/2 text-base text-[#8590AD] transition-all duration-300 ease-out peer-focus:top-0 peer-focus:translate-y-0 peer-focus:text-sm peer-focus:text-[#ef5b97] peer-not-placeholder-shown:top-0 peer-not-placeholder-shown:translate-y-0 peer-not-placeholder-shown:text-sm peer-not-placeholder-shown:text-[#ef5b97]">{{ $label }}</label>
    </div>
</div>