@php
    if (empty($type)) {
        $type = 'text';
    }
@endphp

<input type="{{ $type }}" {{ $attributes->merge(['class' => 'field']) }}>
