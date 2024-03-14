{{-- company type id --}}
@if(!empty($companyType))
    <input type="hidden" name="company_type_id" value="{{ $companyType->id }}">
@endif

{{-- name --}}
<x-form.input type="text" :name="'name'" value="{{ $companyType->name ?? old('name') }}"
              placeholder="Name" class="w-full" required>
    <x-icon.company-type class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
</x-form.input>
