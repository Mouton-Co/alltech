@section('header-scripts')
    <script type="text/javascript">
        window.eventSources = {!! json_encode($eventSources) !!};
    </script>
@endsection

<x-dashboard>

    {{-- see if there's any modal errors and show the modal if the case --}}
    @php
        $hasStoreErrors  = false;
        $hasUpdateErrors = false;

        foreach ($errors->getBags() as $bagKey => $bag) {
            if ($bagKey === 'meetingStore') {
                $hasStoreErrors = true;
                $errors->default = $errors->$bagKey;
                break;
            }
        }
    @endphp

    {{-- curtain --}}
    <x-modals.curtain :show="$hasStoreErrors"/>

    {{-- add modal --}}
    <x-modals.resource :route="route('meeting.store')" :show="$hasStoreErrors" :title="'Creating meeting'"
                       :button="'Create'" id="add-resource-modal">
        <div class="flex w-full flex-col gap-3">
            <input type="hidden" name="grid" class="meeting-modal-input-grid">
            <input type="hidden" name="start_date" class="meeting-modal-input-start_date">

            @include('models.meeting.form', ['meeting' => null, 'contacts' => $contacts])
        </div>
    </x-modals.resource>

    {{-- title --}}
    <h1 class="mb-3">{{ __('Meetings') }}</h1>

    {{-- filter bar --}}
    <hr>
    <form action="{{ route('meeting.index') }}" method="get" id="meeting-index-filter">
        <div class="flex gap-3 my-2 items-center flex-wrap">

            {{-- users --}}
            <label class="min-w-fit">{{ __('Users') }}</label>
            <x-form.select
                :name="'users[]'"
                :options="$users"
                :value="'id'"
                :display="'name'"
                :selected="json_encode(request()->users) ?? ''"
                class="selector-for-calendar-users filter-field max-w-[40rem]"
                multiple
            />

            {{-- pill display --}}
            <label class="min-w-fit">{{ __('Show') }}</label>
            <select name="display" class="filter-field cursor-pointer max-w-[40rem]">
                <option
                    value="title"
                    selected
                >
                    {{ __("Meeting title") }}
                </option>
                <option
                    value="contact"
                    @if (! empty(request()->display) && request()->display == 'contact') selected @endif
                >
                    {{ __("Contact name") }}
                </option>
                <option
                    value="company"
                    @if (! empty(request()->display) && request()->display == 'company') selected @endif
                >
                    {{ __("Company name") }}
                </option>
            </select>

            <button type="submit" class="btn-orange min-w-[120px]">
                {{ __('Filter') }}
            </button>
            <a href="{{ route('meeting.index') }}" class="btn-transparent min-w-[120px] flex justify-center
                    items-center">
                {{ __('Clear Filters') }}
            </a>

        </div>
    </form>
    <hr>

    {{-- calendar --}}
    <div id="calendar" class="my-2"></div>

    {{-- custom styling for event pills --}}
    <script type="text/javascript">
        function formatPill(pill)
        {
            let color = 'black';
            let textColor = 'white';
            window.eventSources.forEach(eventSource => {
                if (eventSource.user == pill.id) {
                    color = eventSource.color;
                    textColor = eventSource.textColor;
                }
            });

            let $pill = $(`<div class='pill-key' style='background:${color};border:1px solid ${textColor}'></div>
            <div>${pill.text.trim()}</div>`);

            return $pill;
        }
    </script>
</x-dashboard>
