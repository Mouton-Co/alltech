@section('header-scripts')
    <script type="text/javascript">
        window.events = {!! json_encode($events) !!};
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
    <x-modals.curtain :show="$hasModalErrors" />

    {{-- add modal --}}
    <x-modals.resource :route="route('meeting.store')" :show="$hasModalErrors" :title="'Creating meeting'" :button="'Create'"
                       id="add-resource-modal">
        <div class="flex w-full flex-col gap-3">
            @include('models.meeting.form', ['meeting' => null, 'contacts' => $contacts])
        </div>
    </x-modals.resource>

    <div id="calendar"></div>

    @foreach($meetings as $event)
        @php
            $event = json_decode(json_encode($event), FALSE)
        @endphp
        <x-modals.resource :route="route('meeting.update', $event->id)" :show="$hasModalErrors" :title="'Editing meeting'" :button="'Update'"
                           id="edit-resource-modal-{{ $event->id }}">
            <div class="flex w-full flex-col gap-3">
                @include('models.meeting.form', ['meeting' => $event, 'contacts' => $contacts])
            </div>
        </x-modals.resource>
    @endforeach
</x-dashboard>

