<div class="relative">
    <select name="{{ $name }}" {{ $attributes->merge(['class' => 'selector-for-js']) }}>
        @foreach ($options as $option)
            <option value="{{ $option->$value }}"
                    @if(!empty($selected) && is_array(json_decode($selected)) && in_array($option->$value, json_decode($selected)))
                        selected
                    @elseif(!empty($selected) && $selected == $option->$value)
                        selected
                    @endif
            >
                {{ $option->$display }}
            </option>
        @endforeach
    </select>
    {{ $slot }}
</div>
@if (!empty($errors->get($name)))
    <x-form.error :messages="$errors->get($name)" />
@endif
