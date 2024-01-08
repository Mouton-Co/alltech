{{-- Name --}}
<x-form.input type="text" :name="'name'" value="{{  old('name') ?? $contact->name }}"
              placeholder="Name" class="w-full" required>
    <x-icon.name class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
</x-form.input>

{{-- Email --}}
<x-form.input type="email" :name="'email'" value="{{ old('email') ?? $contact->email }}"
              placeholder="Email" class="w-full" required>
    <x-icon.email class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
</x-form.input>

{{-- Phone --}}
<x-form.input type="text" :name="'phone'" value="{{ old('phone') ?? $contact->phone ?? '' }}"
              placeholder="Phone" class="w-full">
    <x-icon.phone class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
</x-form.input>

{{-- Company --}}
<div>
    <x-form.label for="company_id">
        {{ __('Company') }}
    </x-form.label>
    <x-form.select :name="'company_id'" class="w-full" :options="$companies" :value="'id'"
                   :display="'name'" :selected="old('company_id') ?? $contact->company_id">
        <x-icon.company class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
    </x-form.select>
</div>
