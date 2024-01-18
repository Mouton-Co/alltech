@section('header-scripts')
    <script type="text/javascript">
        window.eventSources = {!! json_encode($eventSources) !!};
    </script>
@endsection

<x-dashboard>

    {{-- see if there's any modal errors and show the modal if the case --}}
    @php
        $modalErrors = ['name', 'email', 'role_id'];

        $hasModalErrors = false;
        foreach ($modalErrors as $modalError) {
            if (!empty($errors->get($modalError))) {
                $hasModalErrors = true;
                break;
            }
        }
    @endphp

    {{-- curtain --}}
    <x-modals.curtain :show="$hasModalErrors"/>

    {{-- add modal --}}
    <x-modals.resource :route="route('meeting.store')" :show="$hasModalErrors" :title="'Creating meeting'"
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

    @foreach ($eventSources as $eventSource)
        @foreach($eventSource['events'] as $event)
            @php
                $event = json_decode(json_encode($event), false);
            @endphp
            <x-modals.resource :route="route('meeting.update', $event->id)" :show="$hasModalErrors"
                               :title="'Editing meeting'" :button="'Update'" id="edit-resource-modal-{{ $event->id }}">
                <div class="flex w-full flex-col gap-3">
                    @include('models.meeting.form', ['meeting' => $event->model, 'contacts' => $contacts])
                </div>
            </x-modals.resource>
        @endforeach
    @endforeach

    <script type="text/javascript">
        function formatPill(pill)
        {
            let color = 'black';
            window.eventSources.forEach(eventSource => {
                if (eventSource.user == pill.id) {
                    color = eventSource.color;
                }
            });

            let $pill = $(`<div class='pill-key' style='background:${color};'></div>
            <span>${pill.text.trim()}</span>`);

            return $pill;
        }
    </script>
</x-dashboard>
