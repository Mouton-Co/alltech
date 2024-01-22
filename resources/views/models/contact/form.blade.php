{{-- model id --}}
@if(!empty($user))
    <input type="hidden" name="contact_id" value="{{ $contact->id }}">
@endif

{{-- Name --}}
<x-form.input type="text" :name="'name'" value="{{ $contact->name ?? old('name')  }}"
              placeholder="Name" class="w-full" required>
    <x-icon.name class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
</x-form.input>

{{-- Email --}}
<x-form.input type="email" :name="'email'" value="{{ $contact->email ?? old('email') }}"
              placeholder="Email" class="w-full" required>
    <x-icon.email class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
</x-form.input>

{{-- Phone --}}
<x-form.input type="text" :name="'phone'" value="{{ $contact->phone ?? old('phone') }}"
              placeholder="Phone" class="w-full">
    <x-icon.phone class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
</x-form.input>

{{-- Company --}}
<div>
    <x-form.label for="company_id">
        {{ __('Company') }}
    </x-form.label>
    <x-form.select :name="'company_id'" class="selector-for-js w-full filter-field" style="width:100%;" :options="$companies" :value="'id'"
                   :display="'name'" :selected="$contact->company_id ?? old('company_id')">
        <x-icon.company class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
    </x-form.select>
</div>
