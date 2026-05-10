@php
    $field = null;
    $icon = null;
    $field = $attributes->get('wire:model');
    $icon = $attributes->get('icon');
    if (empty($field)) {
        $field = $attributes->get('wire:model.live');
    }
@endphp

<div>
    <div class="relative w-full">
        <input
            class="field-thin w-full"
            {{ $attributes->except('icon') }}
        >
        @if ($icon)
            <x-dynamic-component
                class="absolute left-3 top-[50%] w-5 translate-y-[-50%] text-darkgray"
                :component="'icon.' . $icon"
            />
        @endif
    </div>
    @if ($field)
        @error($field)
            <span class="text-red-600">{{ $message }}</span>
        @enderror
    @endif
</div>
