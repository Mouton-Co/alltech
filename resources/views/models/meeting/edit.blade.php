<x-dashboard>
    <a href="{{ route('meetings.index') }}" class="btn-primary flex items-center gap-2 max-w-fit">
        <x-icon.arrow class="w-6" :direction="'left'" />
        {{ __('Back to calendar') }}
    </a>

    <div class="card mt-7">

        <h1>{{ __('Edit meeting') }}</h1>

        <form action="{{ route('meetings.update') }}" method="POST">
            @csrf

            @include('models.meeting.form')

            {{-- button --}}
            <div class="w-full flex justify-end mt-3">
                <button type="submit" class="btn-primary max-w-fit">
                    {{ __('Update') }}
                </button>
            </div>

        </form>
    </div>
</x-dashboard>
