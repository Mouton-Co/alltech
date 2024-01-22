@php
    $active = !empty($active) && $active ? 'text-orange bg-gray-50' : 'text-gray-700';
@endphp

<a {{ $attributes->merge(['class' => "flex items-center gap-3 p-2 rounded-md text-base leading-6 font-semibold group
hover:text-orange hover:bg-gray-50 $active"]) }}>
    {{ $slot }}
</a>
