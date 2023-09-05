<x-dashboard>
    <a href="{{ route('company.index') }}" class="btn-primary flex items-center gap-2 max-w-fit">
        <x-icon.arrow class="w-6" :direction="'left'" />
        {{ __('Back to companies') }}
    </a>

    <div class="card mt-7">

        <h1>{{ __('Add company') }}</h1>

        <form action="{{ route('company.store') }}" method="POST">
            @csrf

            {{-- name --}}
            <div>
                <x-form.label class="mt-2" :value="'Name'" />
                <div class="mt-2">
                    <x-form.input :name="'name'" required value="{{ old('name') }}" />
                </div>
            </div>

            {{-- location --}}
            <div>
                <x-form.label class="mt-2" :value="'Location'" />
                <div class="mt-2">
                    <x-form.input :name="'location'" value="{{ old('location') }}" />
                </div>
            </div>

            {{-- coordinates --}}
            <div>
                <x-form.label class="mt-2" :value="'Coordinates'" />
                <div class="mt-2">
                    <x-form.input :name="'coordinates'" value="{{ old('coordinates') }}" />
                </div>
            </div>

            {{-- company types --}}
            <div>
                <x-form.label class="mt-2" :value="'Company types'" />
                <div class="mt-2">
                    <select name="company_type_id" class="field"
                    class="{{ !empty($errors->get('company_type_id')) ? '!ring-red-600' : '' }}" >
                        @if (!empty($companyTypes))
                            @foreach ($companyTypes as $companyType)
                                <option value="{{ $companyType->id }}">
                                    {{ $companyType->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @if (!empty($errors->get('company_type_id')))
                        <x-form.error :messages="$errors->get('company_type_id')" />
                    @endif
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
