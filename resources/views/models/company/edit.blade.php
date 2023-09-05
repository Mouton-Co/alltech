<x-dashboard>
    <a href="{{ route('company.index') }}" class="btn-primary flex items-center gap-2 max-w-fit">
        <x-icon.arrow class="w-6" :direction="'left'"/>
        {{ __('Back to companies') }}
    </a>
    
    <div class="card mt-7">

        <h1>{{ __('Edit company') }}</h1>

        <form action="{{ route('company.update', $company->id) }}" method="POST">
            @csrf

            {{-- name --}}
            <div>
                <x-form.label class="mt-2" :value="'Name'" />
                <div class="mt-2">
                    <x-form.input :name="'name'" required value="{{ $company->name }}" />
                </div>
            </div>

            {{-- location --}}
            <div>
                <x-form.label class="mt-2" :value="'Location'" />
                <div class="mt-2">
                    <x-form.input :name="'location'" value="{{ $company->location }}" />
                </div>
            </div>

            {{-- coordinates --}}
            <div>
                <x-form.label class="mt-2" :value="'Coordinates'" />
                <div class="mt-2">
                    <x-form.input :name="'coordinates'" value="{{ $company->coordinates }}" />
                </div>
            </div>

            {{-- company types --}}
            <div>
                <x-form.label class="mt-2" :value="'Company type'" />
                <div class="mt-2">
                    <select name="company_type_id" class="field">
                        @if (!empty($companyTypes))
                            @foreach ($companyTypes as $companyType)
                                <option value="{{ $companyType->id }}"
                                {{ $companyType->id == $company->companyType->id ? 'selected' : '' }}>
                                    {{ $companyType->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            {{-- button --}}
            <div class="w-full flex justify-end mt-3">
                <button type="submit" class="btn-primary max-w-fit">
                    {{ __('Update') }}
                </button>
            </div>

        </form>
    </div>
</x-dashboard>
