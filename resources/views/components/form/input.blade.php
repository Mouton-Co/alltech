<div class="relative w-full">
    <input name="{{ $name }}" type="{{$type ?? 'text'}}" {{ $attributes->merge([
        'class' => !empty($errors->get($name)) ? 'field-thin !ring-red-600' : 'field-thin'

    ]) }}>
    {{ $slot }}
</div>
@if (!empty($errors->get($name)))
    <x-form.error :messages="$errors->get($name)" />
@endif
