{{-- name --}}
{{-- meeting id --}}
@if (!empty($meeting))
    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
@endif

{{-- date --}}
<x-form.label for="date" class="w-fit">
    {{ __('Date') }}
</x-form.label>
<x-form.input :name="'date'" :type="'date'" class="w-full" required
    value="{{ $meeting->date ?? old('date') }}">
    <x-icon.date-picker class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
</x-form.input>

{{-- start time --}}
<x-form.label for="start_time">
    {{ __('Start time') }}
</x-form.label>
<x-form.input :name="'start_time'" :type="'time'" class="w-full" required
value="{{ !empty($meeting->end_time) ?
\Carbon\Carbon::createFromFormat('H:i:s', $meeting->start_time)->format('H:i') :
old('start_time') }}">
    <x-icon.time-picker class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray"/>
</x-form.input>

{{-- end time --}}
<x-form.label for="end_time">
    {{ __('End time') }}
</x-form.label>
<x-form.input :name="'end_time'" :type="'time'" class="w-full" required
value="{{ !empty($meeting->end_time) ?
\Carbon\Carbon::createFromFormat('H:i:s', $meeting->end_time)->format('H:i') :
old('end_time') }}">
    <x-icon.time-picker class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray"/>
</x-form.input>

{{-- objective --}}
<x-form.label for="objective">
    {{ __('Objective') }}
</x-form.label>
<x-form.textarea :name="'objective'" class="w-full" placeholder="Objective">
    {{ $meeting->objective ?? old('objective') }}
</x-form.textarea>

{{-- marketing_requirements --}}
<x-form.label for="marketing_requirements">
    {{ __('Marketing requirements') }}
</x-form.label>
<x-form.textarea :name="'marketing_requirements'" class="w-full" placeholder="Marketing requirements">
    {{ $meeting->marketing_requirements ?? old('marketing_requirements') }}
</x-form.textarea>

{{-- contact --}}
<div>
    <x-form.label for="contact_id">
        {{ __('Contact') }}
    </x-form.label>
    <select name="contact_id" style="width:100%;" class="selector-for-js">
        @foreach ($contacts as $contact)
            <option value="{{ $contact->id }}"
                @if (
                    !empty($meeting->contact_id ?? old('contact_id')) &&
                    is_array(json_decode($meeting->contact_id ?? old('contact_id') ,true)) &&
                    in_array($contact->id, json_decode($meeting->contact_id ?? old('contact_id'), true))
                )
                    selected
                @elseif (!empty($meeting->contact_id ?? old('contact_id')) &&
                $meeting->contact_id ?? old('contact_id') == $contact->id)
                    selected
                @endif>
                {{ $contact->name . ' @ ' . $contact->company->name }}
            </option>
        @endforeach
    </select>
</div>
