<x-dashboard>
    <a href="{{ route('company-type.index') }}" class="btn-primary flex items-center gap-2 max-w-fit">
        <x-icon.arrow class="w-6" :direction="'left'" />
        {{ __('Back to company types') }}
    </a>

    <div class="card mt-7">

        <h1>{{ __('Add company type') }}</h1>

        <form action="{{ route('company-type.store') }}" method="POST">
            @csrf

            {{-- name --}}
            <div>
                <x-form.label class="mt-2" :value="'Name'" />
                <div class="mt-2">
                    <x-form.input :name="'name'" required
                        value="{{ old('name') }}" />
                </div>
            </div>

            {{-- minimum required --}}
            <div>
                <x-form.label class="mt-2" :value="'Minimum required'" />
                <div class="mt-2">
                    <x-form.input :name="'minimum_required'" required
                    value="{{ old('minimum_required') }}" />
                </div>
            </div>

            {{-- button --}}
            <div class="w-full flex justify-end mt-3">
                <button type="submit" class="btn-primary max-w-fit">
                    {{ __('Create') }}
                </button>
            </div>

        </form>
    </div>
</x-dashboard>
