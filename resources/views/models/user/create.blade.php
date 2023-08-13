<x-dashboard>
    <a href="{{ route('user.index') }}" class="btn-primary flex items-center gap-2 max-w-fit">
        <x-icon.arrow class="w-6" :direction="'left'" />
        {{ __('Back to users') }}
    </a>

    <div class="card mt-7">

        <h1>{{ __('Add user') }}</h1>

        <form action="{{ route('user.store') }}" method="POST">
            @csrf

            {{-- name --}}
            <div>
                <x-form.label class="mt-2" :value="'Name'" />
                <div class="mt-2">
                    <x-form.input :name="'name'" required
                        placeholder="John Doe" value="{{ old('name') }}" />
                </div>
            </div>

            {{-- email address --}}
            <div>
                <x-form.label class="mt-2" :value="'Email address'" />
                <div class="mt-2">
                    <x-form.input :type="'email'" :name="'email'" autocomplete="email" required
                        placeholder="johndoe@gmail.com" value="{{ old('email') }}" />
                </div>
            </div>

            {{-- role --}}
            <div>
                <x-form.label class="mt-2" :value="'Email address'" />
                <div class="mt-2">
                    <select name="role_id" class="field"
                    class="{{ !empty($errors->get('role_id')) ? '!ring-red-600' : '' }}" >
                        @if (!empty($roles))
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @if (!empty($errors->get('role_id')))
                        <x-form.error :messages="$errors->get('role_id')" />
                    @endif
                </div>
            </div>

            {{-- password --}}
            <div>
                <x-form.label class="mt-2" :value="'Password'" />
                <div class="mt-2">
                    <x-form.input :type="'password'" :name="'password'" required />
                </div>
            </div>

            {{-- confirm password --}}
            <div>
                <x-form.label class="mt-2" :value="'Confirm password'" />
                <div class="mt-2">
                    <x-form.input :type="'password'" required :name="'confirm_password'" />
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
