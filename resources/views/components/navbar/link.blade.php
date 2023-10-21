@php
    $textColor = $active ? 'text-orange' : '';
@endphp

<a href="{{ $link ?? '#' }}"
    {{ $attributes->merge(['class' => "flex items-center gap-3 $textColor hover:text-orange"]) }}>
    {{ $slot }}
</a>
