{{-- report id --}}
@if(!empty($report->id))
    <input type="hidden" name="report_id" value="{{ $report->id }}">
@endif

{{-- filter used --}}
<input type="hidden" name="filter_used" value="{{ json_encode(request()->query()) }}">
{{-- filter name --}}
<div class="flex gap-3">
    <label for="filter_name" class="min-w-fit">{{ __('Filter Name') }}</label>
    <input type="text" name="filter_name" placeholder="Filter Name" value="{{$report->filter_name ?? old('filter_name')}}" class="filter-field">
</div>

{{-- recipient --}}
<div class="flex gap-3">
    <label for="recipient" class="min-w-fit">{{ __('Recipient') }}</label>
    <input type="text" name="recipient" placeholder="example@alltech.com" value="{{$report->recipient ?? old('recipient')}}" class="filter-field">
</div>

{{-- send at --}}
<div class="flex gap-3">
    <label for="send_at" class="min-w-fit">{{ __('Send At') }}</label>
    <x-form.date-picker :name="'send_at'" :value="$report->send_at ?? old('send_at')"
                        class="filter-field"/>
</div>

{{-- repeat --}}
<div class="flex gap-3">
    <label for="repeat" class="min-w-fit">{{ __('Repeat') }}</label>
    <input type="checkbox" name="repeat" placeholder="Repeat" class="filter-field"
    @if(!empty($report->repeat))
        checked
    @endif
    >
</div>

{{-- repeat frequency --}}
<div class="flex gap-3">
    <label for="repeat_frequency" class="min-w-fit">{{ __('Repeat Frequency') }}</label>
    <select name="repeat_frequency" class="filter-field selector-for-js">
        <option value="" disabled>{{ __('Please Select') }}</option>
        @foreach(\App\Models\Report::REPEAT_FREQUENCY as $key => $value)
            <option
                value="{{ $key }}"
                @if($key == old('repeat_frequency') || (!empty($report->repeat_frequency) && $key == $report->repeat_frequency))
                    selected
                @endif
            >
                {{ $value }}
            </option>
        @endforeach
    </select>

</div>
