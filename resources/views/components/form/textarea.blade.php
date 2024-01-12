<textarea name="{{ $name }}" cols="30" rows="5" {{ $attributes->merge([
    'class' => !empty($errors->get($name)) ? 'field-area !ring-red-600' : 'field-area'
]) }}>{{ $slot }}</textarea>

@if (!empty($errors->get($name)))
    <x-form.error :messages="$errors->get($name)" />
@endif
