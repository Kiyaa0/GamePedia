@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full px-3 py-2 text-sm font-bold text-white bg-red-500 rounded-md transition'
            : 'block w-full px-3 py-2 text-sm font-bold text-gray-400 hover:text-white hover:bg-gray-800/50 rounded-md transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
