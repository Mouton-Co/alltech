{{-- name --}}
{{-- meeting id --}}
@if (!empty($meeting))
    <input type="hidden" name="meeting_id" value="{{ $meeting->id }}">
@endif

<div class="mt-3">
    {{-- all day --}}
    <div class="w-full max-w-xs flex items-center gap-3 mb-3">
        <x-form.label for="date" class="min-w-[80px]">
            {{ __('All day') }}
        </x-form.label>
        <input type="checkbox" name="all_day" class="cursor-pointer"
            @if (!empty($meeting->all_day)) checked @endif>
    </div>

    {{-- start date --}}
    <div class="w-full max-w-xs flex items-center gap-3 mb-3">
        <x-form.label for="date" class="min-w-[80px] start-date-label">
            @if (empty($meeting->all_day))
            {{ __('Date') }}
            @else
                {{ __('Start date') }}
            @endif
        </x-form.label>
        <x-form.input :name="'date'" :type="'date'" class="w-full" required
            value="{{ $meeting->date ?? old('date') }}">
            <x-icon.date-picker class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
        </x-form.input>
    </div>

    {{-- end date --}}
    <div class="w-full max-w-xs flex items-center gap-3 mb-3 show-for-all-day @if (empty($meeting->all_day)) hidden @endif">
        <x-form.label for="date" class="min-w-[80px]">
            {{ __('End date') }}
        </x-form.label>
        <x-form.input :name="'end_date'" :type="'date'" class="w-full"
            value="{{ $meeting->end_date ?? old('end_date') }}">
            <x-icon.date-picker class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
        </x-form.input>
    </div>

    {{-- start time --}}
    <div class="w-full max-w-xs flex items-center gap-3 mb-3 hide-for-all-day @if (!empty($meeting->all_day)) hidden @endif">
        <x-form.label for="start_time" class="min-w-[80px]">
            {{ __('Start time') }}
        </x-form.label>
        <x-form.input :name="'start_time'" :type="'time'" class="w-full"
        value="{{ !empty($meeting->end_time) ?
        \Carbon\Carbon::createFromFormat('H:i:s', $meeting->start_time)->format('H:i') :
        old('start_time') }}">
            <x-icon.time-picker class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray"/>
        </x-form.input>
    </div>
    
    {{-- end time --}}
    <div class="w-full max-w-xs flex items-center gap-3 mb-3 hide-for-all-day @if (!empty($meeting->all_day)) hidden @endif">
        <x-form.label for="end_time" class="min-w-[80px]">
            {{ __('End time') }}
        </x-form.label>
        <x-form.input :name="'end_time'" :type="'time'" class="w-full max-w-xs"
        value="{{ !empty($meeting->end_time) ?
        \Carbon\Carbon::createFromFormat('H:i:s', $meeting->end_time)->format('H:i') :
        old('end_time') }}">
            <x-icon.time-picker class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray"/>
        </x-form.input>
    </div>
</div>

<div class="w-full flex gap-3 justify-center items-center">
    <div class="w-full">
        {{-- meeting title --}}
        <x-form.label for="title">
            {{ __('Meeting Title') }}
        </x-form.label>
        <x-form.input :name="'title'" class="w-full mt-3" required
            value="{{ $meeting->title ?? old('title') }}">
            <x-icon.meeting class="absolute w-5 top-[60%] translate-y-[-50%] left-3 text-darkgray" />
        </x-form.input>
    </div>
    
    <div class="w-full">
        {{-- meeting type --}}
        <x-form.label for="type">
            {{ __('Meeting Type') }}
        </x-form.label>
        <div>
            <select name="type" id="type" class="field-thin w-full mt-3" required>
                <option value="">{{ __("--Please select--") }}</option>
                <option value="Call" @if (($meeting->type ?? old('type')) == 'Call') selected @endif>{{ __("Call") }}</option>
                <option value="Visit" @if (($meeting->type ?? old('type')) == 'Visit') selected @endif>{{ __("Visit") }}</option>
            </select>
        </div>
    </div>
</div>

{{-- location --}}
<x-form.label for="location">
    {{ __('Location') }}
</x-form.label>
<x-form.input :name="'location'" class="w-full"
    value="{{ $meeting->location ?? old('title') }}">
    <x-icon.location class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
</x-form.input>

{{-- report --}}
<x-form.label for="report">
    {{ __('Report') }}
</x-form.label>
<x-form.textarea :name="'report'" class="w-full" placeholder="Report">
    {{ $meeting->report ?? old('report') }}
</x-form.textarea>

{{-- contact --}}
<x-form.label for="contact_id">
    {{ __('Contact') }}
</x-form.label>
<div>
    @php
        $meeting_contact_id = $meeting->contact_id ?? old('contact_id');
    @endphp
    <select name="contact_id" style="width:100%;" class="selector-for-js">
        @foreach ($contacts as $contact)
            <option value="{{ $contact->id }}"
                @if (
                    !empty($meeting_contact_id) &&
                    is_array(json_decode($meeting_contact_id ,true)) &&
                    in_array($contact->id, json_decode($meeting_contact_id, true))
                )
                    selected
                @elseif (
                    !empty($meeting_contact_id) &&
                    $meeting_contact_id == $contact->id
                )
                    selected
                @endif>
                @php
                    $name = !empty($contact->name) ? $contact->name : $contact->email;
                    $company = !empty($contact->company->name) ? ' (' . $contact->company->name . ')' : '';
                @endphp
                {{ $name . $company }}
            </option>
        @endforeach
    </select>
</div>
