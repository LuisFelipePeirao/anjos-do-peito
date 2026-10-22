@props([
    'value' => 'CLique aqui'
])

<input 
    type="submit"
    class="mb-12 w-full cursor-pointer rounded-lg border-none bg-[#c73570] p-4 text-base text-white transition duration-300 hover:shadow-[0_15px_36px_rgba(0,0,0,0.15)] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#9d174d]"
    value="{{ $value }}">
