<div class="relative">
    <select name="{{ $name }}" {{ $attributes->merge([
        'class' => !empty($errors->get($name)) ? 'field-thin !ring-red-600' : 'field-thin'
    ]) }}>
        @foreach ($options as $option)
            <option value="{{ $option->$value }}">{{ $option->$display }}</option>
        @endforeach
    </select>
    {{ $slot }}
</div>
@if (!empty($errors->get($name)))
    <x-form.error :messages="$errors->get($name)" />
@endif
