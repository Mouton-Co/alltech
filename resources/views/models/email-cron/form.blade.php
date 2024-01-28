<div class="flex w-full flex-col gap-3">
    <div class="flex gap-3 items-center">
        <label class="label min-w-[55px]">{{ __('Every') }}</label>
    
        {{-- day of the week --}}
        <select name="day" class="filter-field !max-w-[200px]" required>
            <option value="">{{ __('--Please select--') }}</option>
            @foreach (config('models.email-cron.days') as $value => $name)
                <option value="{{ $value }}"
                @if (isset($emailCron) && $emailCron->day == $value)
                    selected
                @endif>
                    {{ $name }}
                </option>
            @endforeach
        </select>
    
        <label class="label">{{ __('@') }}</label>
        
        {{-- time of day --}}
        <input type="number" name="hour" class="field-thin !pl-3" min="0" max="23" required
        @if (isset($emailCron)) value="{{ $emailCron->hour }}" @endif>
    
        <label class="label">{{ __(':00') }}</label>
    </div>
    
    {{-- to --}}
    <div class="flex gap-3 items-center">
        <label class="label min-w-[55px]">{{ __('To:') }}</label>
        <input type="email" name="to" placeholder="To" class="field-thin !pl-3 w-full" required
        @if (isset($emailCron)) value="{{ $emailCron->to }}" @endif>
    </div>
    
    {{-- subject --}}
    <div class="flex gap-3 items-center">
        <label class="label min-w-[55px]">{{ __('Subject:') }}</label>
        <input type="text" name="subject" placeholder="Subject" class="field-thin !pl-3 w-full" required
        @if (isset($emailCron)) value="{{ $emailCron->subject }}" @endif>
    </div>
</div>

{{-- filter --}}
<input type="hidden" name="filter" value="{{ json_encode(request()->query()) }}">
