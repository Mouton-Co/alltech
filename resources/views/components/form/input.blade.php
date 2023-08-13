@php
    if (empty($type)) {
        $type = 'text';
    }
@endphp

<input type="{{ $type }}" name="{{ $name }}" {{ $attributes->merge([
    'class' => !empty($errors->get($name)) ? 'field ring-red-600' : 'field'
]) }}>
@if (!empty($errors->get($name)))
    <x-form.error :messages="$errors->get($name)" />
@endif
