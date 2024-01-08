{{-- name --}}
<x-form.input type="text" :name="'name'" value="{{ old('name') ?? $company->name  }}" placeholder="Name"
              class="w-full" required>
    <x-icon.company class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
</x-form.input>

{{-- location --}}
<x-form.input type="text" :name="'location'" value="{{ old('location') ?? $company->location ?? '' }}"
              placeholder="Location" class="w-full">
    <x-icon.location class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
</x-form.input>

{{-- coordinates --}}
<x-form.input type="text" :name="'coordinates'" placeholder="Coordinates" class="w-full"
              value="{{ old('coordinates') ?? $company->coordinates ?? '' }}">
    <x-icon.coordinates class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
</x-form.input>

{{-- company types --}}
<div>
    <x-form.label for="company_type_id">
        {{ __('Company Type') }}
    </x-form.label>
    <x-form.select :name="'company_type_id'" class="w-full" :options="$companyTypes" :value="'id'"
                   :display="'name'" :selected=" old('company_type_id') ?? $company->company_type_id">
        <x-icon.company-type class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
    </x-form.select>
</div>
