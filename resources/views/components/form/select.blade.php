<select name="{{ $name }}" {{ $attributes }}>
    @foreach ($options as $option)
        <option value="{{ $option->$value }}"
            @if (
                !empty($selected) &&
                is_array(json_decode($selected,true)) &&
                in_array($option->$value, json_decode($selected, true))
            )
                selected
            @elseif(!empty($selected) && $selected == $option->$value)
                selected
            @endif>
            {{ $option->$display }}
        </option>
    @endforeach
</select>
@if (!empty($errors->get($name)))
    <x-form.error :messages="$errors->get($name)" />
@endif
