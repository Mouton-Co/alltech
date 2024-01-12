<div class="relative">
    <select name="{{ $name }}" {{ $attributes->merge(['class' => 'selector-for-js']) }}>
        @foreach ($options as $option)
            <option value="{{ $option->$value }}"
            {{ !empty($selected) && $selected == $option->$value ? 'selected' : '' }}>
                {{ $option->$display }}
            </option>
        @endforeach
    </select>
    {{ $slot }}
</div>
@if (!empty($errors->get($name)))
    <x-form.error :messages="$errors->get($name)" />
@endif
