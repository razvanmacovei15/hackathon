@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center gap-2 rounded-lg bg-zinc-100 px-3 py-2 text-sm font-medium text-zinc-900 dark:bg-zinc-800 dark:text-zinc-50'
            : 'flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-zinc-600 hover:bg-zinc-100 hover:text-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800 dark:hover:text-zinc-50';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $icon ?? '' }}
    {{ $slot }}
</a> 