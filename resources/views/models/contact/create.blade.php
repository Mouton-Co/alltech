<x-dashboard>
    <a href="{{ route('contact.index') }}" class="btn-primary flex items-center gap-2 max-w-fit">
        <x-icon.arrow class="w-6" :direction="'left'" />
        {{ __('Back to contacts') }}
    </a>

    <div class="card mt-7">

        <h1>{{ __('Add contact') }}</h1>

        <form action="{{ route('contact.store') }}" method="POST">
            @csrf

            @include('models.contact.form')

            {{-- button --}}
            <div class="w-full flex justify-end mt-3">
                <button type="submit" class="btn-primary max-w-fit">
                    {{ __('Create') }}
                </button>
            </div>

        </form>
    </div>
</x-dashboard>
