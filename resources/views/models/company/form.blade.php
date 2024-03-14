{{-- model id --}}
@if (!empty($user))
    <input name="company_id" type="hidden" value="{{ $company->id }}">
@endif

{{-- name --}}
<x-form.input class="w-full" type="text" value="{{ $company->name ?? old('name') }}" :name="'name'" placeholder="Name"
required>
    <x-icon.company class="text-darkgray absolute left-3 top-[50%] w-5 translate-y-[-50%]" />
</x-form.input>

{{-- location --}}
<x-form.input class="w-full" type="text" value="{{ $company->location ?? old('location') }}" :name="'location'"
placeholder="Location">
    <x-icon.location class="text-darkgray absolute left-3 top-[50%] w-5 translate-y-[-50%]" />
</x-form.input>

{{-- region --}}
<x-form.input class="w-full" type="text" value="{{ $company->region ?? old('region') }}" :name="'region'"
placeholder="Region">
    <x-icon.coordinates class="text-darkgray absolute left-3 top-[50%] w-5 translate-y-[-50%]" />
</x-form.input>

{{-- company types --}}
<div>
    <x-form.label for="company_type_id">
        {{ __('Company Type') }}
    </x-form.label>
    <x-form.select class="selector-for-js filter-field w-full" style="width:100%;" :name="'company_type_id'"
    :options="$companyTypes" :value="'id'" :display="'name'"
    :selected="$company->company_type_id ?? old('company_type_id')">
        <x-icon.company-type class="text-darkgray absolute left-3 top-[50%] w-5 translate-y-[-50%]" />
    </x-form.select>
</div>
