<x-dashboard>
    <a href="{{ route('user.index') }}" class="btn-primary flex items-center gap-2 max-w-fit">
        <x-icon.arrow class="w-6" :direction="'left'"/>
        {{ __('Back to users') }}
    </a>

    <div class="card mt-7">

        <h1>{{ __('Edit user') }}</h1>

        <form action="{{ route('user.update', $user->id) }}" method="POST">
            @csrf

            @include('models.user.form')

            {{-- button --}}
            <div class="w-full flex justify-end mt-3">
                <button type="submit" class="btn-primary max-w-fit">
                    {{ __('Update') }}
                </button>
            </div>

        </form>
    </div>
</x-dashboard>
