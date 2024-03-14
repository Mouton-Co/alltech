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
            if (str_contains($bagKey, 'meetingUpdate')) {
                $hasUpdateErrors = true;
                $meetingErrorId = explode('--', $bagKey)[1];
                $errors->default = $errors->$bagKey;
                break;
            }
        }
    @endphp

    {{-- curtain --}}
    <x-modals.curtain :show="$hasStoreErrors | $hasUpdateErrors"/>

    {{-- add modal --}}
    <x-modals.resource :route="route('meeting.store')" :show="$hasStoreErrors" :title="'Creating meeting'"
                       :button="'Create'" id="add-resource-modal">
        <div class="flex w-full flex-col gap-3">
            @include('models.meeting.form', ['meeting' => null, 'contacts' => $contacts])
        </div>
    </x-modals.resource>

    {{-- title --}}
    <h1 class="mb-3">{{ __('Meetings') }}</h1>

    {{-- filter bar --}}
    <hr>
    <form action="{{ route('meeting.index') }}" method="get">
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

    {{-- edit modals --}}
    @foreach ($eventSources as $eventSource)
        @foreach($eventSource['events'] as $event)
            @php
                $event = json_decode(json_encode($event), false);
            @endphp
            @can('update', \App\Models\Meeting::find($event->id))
                <x-modals.resource :route="route('meeting.update', $event->id)" :title="'Editing meeting'"
                :show="$hasUpdateErrors && $meetingErrorId == $event->id"  :button="'Update'" :meeting="$event->id"
                id="edit-resource-modal-{{ $event->id }}">
                    <div class="flex w-full flex-col gap-3">
                        @include('models.meeting.form', ['meeting' => $event->model, 'contacts' => $contacts])
                    </div>
                </x-modals.resource>

                <x-modals.resource :route="route('meeting.cancel', $event->id)"
                :title="'Are you sure you want to cancel this meeting?'"
                :button="'Cancel'" id="cancel-resource-modal-{{ $event->id }}">
                    <input type="hidden" name="meeting_id" value="{{ $event->id }}">
                    {{-- reason --}}
                    <div class="w-full flex justify-start">
                        <x-form.label for="cancelled_reason">
                            {{ __('Reason for cancellation?') }}
                        </x-form.label>
                    </div>
                    <x-form.textarea :name="'cancelled_reason'" class="w-full" placeholder="Reason..." required>
                        {{ $meeting->cancelled_reason ?? old('cancelled_reason') }}
                    </x-form.textarea>
                </x-modals.resource>
            @endcan
        @endforeach
    @endforeach

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
