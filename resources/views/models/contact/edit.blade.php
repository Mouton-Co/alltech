<x-dashboard>
    <a href="{{ route('contact.index') }}" class="btn-primary flex items-center gap-2 max-w-fit">
        <x-icon.arrow class="w-6" :direction="'left'"/>
        {{ __('Back to contacts') }}
    </a>
    
    <div class="card mt-7">

        <h1>{{ __('Edit contact') }}</h1>

        <form action="{{ route('contact.update', $contact->id) }}" method="POST">
            @csrf

            {{-- name --}}
            <div>
                <x-form.label class="mt-2" :value="'Name'" />
                <div class="mt-2">
                    <x-form.input :name="'name'" required value="{{ $contact->name }}" />
                </div>
            </div>

            {{-- email --}}
            <div>
                <x-form.label class="mt-2" :value="'Email'" />
                <div class="mt-2">
                    <x-form.input :type="'email'" :name="'email'" required
                        placeholder="johndoe@gmail.com" value="{{ $contact->email }}" />
                </div>
            </div>

            {{-- phone --}}
            <div>
                <x-form.label class="mt-2" :value="'Phone'" />
                <div class="mt-2">
                    <x-form.input :name="'phone'" value="{{ $contact->phone }}" />
                </div>
            </div>

            {{-- companies --}}
            <div>
                <x-form.label class="mt-2" :value="'Company'" />
                <div class="mt-2">
                    <select name="company_id" class="field">
                        @if (!empty($companies))
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}"
                                {{ $company->id == $contact->company->id ? 'selected' : '' }}>
                                    {{ $company->name }}
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
