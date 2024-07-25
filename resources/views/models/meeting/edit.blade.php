<x-dashboard>

    {{-- curtain --}}
    <x-modals.curtain />
    
    <a
        class="btn-transparent mb-6 flex h-[30px] w-fit cursor-pointer items-center px-5"
        href="{{ route(
            'meeting.index',
            array_merge(
                [
                    'grid' => $grid,
                    'start_date' => $start_date,
                ],
                request()->query(),
            ),
        ) }}"
    >
        {{ __('<- Back to calendar') }}
    </a>

    @if ($meeting->cancelled_at)
        <x-navbar.message :color="'amber'">
            {{ __('This meeting has been cancelled') }}
        </x-navbar.message>
    @endif

    <div class="card mt-7">

        <div class="flex items-center justify-between">
            <h1>{{ __('Editing meeting') }}</h1>

            <button
                class="btn-orange h-[30px] w-fit px-5"
                id="cancel-meeting"
                datum-id="{{ $meeting->id }}"
                {{ $meeting->cancelled_at ? 'disabled' : '' }}
            >
                {{ __('Cancel meeting') }}
            </button>
        </div>

        <form
            action="{{ route('meeting.update', $meeting->id) }}"
            method="POST"
        >
            @csrf

            @include('models.meeting.form')

            <input
                name="grid"
                type="hidden"
                value="{{ $grid }}"
            >
            <input
                name="start_date"
                type="hidden"
                value="{{ $start_date }}"
            >

            {{-- button --}}
            <div class="mt-3 flex w-full justify-end">
                <button
                    class="btn-orange h-[30px] w-fit px-5"
                    type="submit"
                    {{ $meeting->cancelled_at ? 'disabled' : '' }}
                >
                    {{ __('Update') }}
                </button>
            </div>

        </form>
    </div>

    <x-modals.resource
        id="cancel-resource-modal-{{ $meeting->id }}"
        :route="route('meeting.cancel', $meeting->id)"
        :title="'Are you sure you want to cancel this meeting?'"
        :button="'Cancel meeting'"
    >
        <input
            name="meeting_id"
            type="hidden"
            value="{{ $meeting->id }}"
        >

        {{-- reason --}}
        <div class="flex w-full justify-start">
            <x-form.label for="cancelled_reason">
                {{ __('Reason for cancellation?') }}
            </x-form.label>
        </div>

        <x-form.textarea
            class="w-full"
            :name="'cancelled_reason'"
            placeholder="Reason..."
            required
        >
            {{ $meeting->cancelled_reason ?? old('cancelled_reason') }}
        </x-form.textarea>
    </x-modals.resource>

</x-dashboard>
