<x-dashboard>
    <a href="{{ route('contact.index') }}" class="btn-primary flex items-center gap-2 max-w-fit">
        <x-icon.arrow class="w-6" :direction="'left'" />
        {{ __('Back to contacts') }}
    </a>

    <div class="card mt-7">

        <h1>{{ __('Add contact') }}</h1>

        <form action="{{ route('contact.store') }}" method="POST">
            @csrf

            {{-- name --}}
            <div>
                <x-form.label class="mt-2" :value="'Name'" />
                <div class="mt-2">
                    <x-form.input :name="'name'" required value="{{ old('name') }}" />
                </div>
            </div>

            {{-- email --}}
            <div>
                <x-form.label class="mt-2" :value="'Email'" />
                <div class="mt-2">
                    <x-form.input :type="'email'" :name="'email'" required
                        placeholder="johndoe@gmail.com" value="{{ old('email') }}" />
                </div>
            </div>

            {{-- phone --}}
            <div>
                <x-form.label class="mt-2" :value="'Phone'" />
                <div class="mt-2">
                    <x-form.input :name="'phone'" value="{{ old('phone') }}" />
                </div>
            </div>

            {{-- companies --}}
            <div>
                <x-form.label class="mt-2" :value="'Company'" />
                <div class="mt-2">
                    <select name="company_id" class="field"
                    class="{{ !empty($errors->get('company_id')) ? '!ring-red-600' : '' }}" >
                        @if (!empty($companies))
                            @foreach ($companies as $company)
                                <option value="{{ $company->id }}">
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
                    {{ __('Create') }}
                </button>
            </div>

        </form>
    </div>
</x-dashboard>
