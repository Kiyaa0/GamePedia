@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-red-500 rounded-md transition'
            : 'inline-flex items-center px-4 py-2 text-sm font-bold text-gray-400 hover:text-white hover:bg-gray-800/50 rounded-md transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
