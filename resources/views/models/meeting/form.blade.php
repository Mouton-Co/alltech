{{-- meeting id --}}
@if(!empty($meeting))
    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
@endif

{{-- date - picker --}}
<x-form.label for="date">
    {{ __('Date') }}
</x-form.label>
<x-form.date-picker :name="'date'" class="w-full" required
                    value="{{ $meeting->date ?? old('date') }}">
    <x-icon.date-picker class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray"/>
</x-form.date-picker>

{{-- start time --}}
<x-form.label for="start_time">
    {{ __('Start time') }}
</x-form.label>
<x-form.input :name="'start_time'" :type="'time'" class="w-full" required
              value="{{ ! empty($meeting->end_time) ? \Carbon\Carbon::createFromFormat('H:i:s',$meeting->start_time)->format('H:i') : old('start_time') }}">
    {{--    <x-icon.time-picker class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray"/>--}}
</x-form.input>

{{-- end time --}}
<x-form.label for="end_time">
    {{ __('End time') }}
</x-form.label>
<x-form.input :name="'end_time'" :type="'time'" class="w-full" required
              value="{{ ! empty($meeting->end_time) ? \Carbon\Carbon::createFromFormat('H:i:s',$meeting->end_time)->format('H:i') : old('end_time') }}">
    {{--    <x-icon.time-picker class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray"/>--}}
</x-form.input>

{{-- objective --}}
<x-form.label for="objective">
    {{ __('Objective') }}
</x-form.label>
<x-form.input :name="'objective'" :type="'textarea'" class="w-full" required
              placeholder="Objective" value="{{ $meeting->objective ?? old('objective') }}">
</x-form.input>

{{-- marketing_requirements --}}
<x-form.label for="marketing_requirements">
    {{ __('Marketing requirements') }}
</x-form.label>
<x-form.input :name="'marketing_requirements'" :type="'textarea'" class="w-full" required
              placeholder="Marketing requirements"
              value="{{ $meeting->marketing_requirements ?? old('marketing_requirements') }}">
</x-form.input>

{{-- contact --}}
<x-form.label for="contact_id">
    {{ __('Contact') }}
</x-form.label>
<x-form.label class="mt-2" :value="'Company type'"/>
<div class="mt-2">
    <select name="contact_id" class="field">
        @if (!empty($contacts))
            @foreach ($contacts as $contact)
                <option value="{{ $contact->id }}"
                        @if(
                                !empty($meeting->contact_id) &&
                                $contact->id == $meeting->contact_id
                                )
                            selected="selected"
                        @endif
                >
                    {{ $contact->email ?? '' }} - {{ $contact->name ?? '' }} - {{ $contact->company->name ?? '' }}
                </option>
            @endforeach
        @endif
    </select>
</div>
