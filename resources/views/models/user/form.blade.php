{{-- user id --}}
@if(!empty($user))
    <input type="hidden" name="user_id" value="{{ $user->id }}">
@endif

{{-- name --}}
<x-form.label for="name">
    {{ __('Name') }}
</x-form.label>
<x-form.input :name="'name'" class="w-full" required
              placeholder="John Doe" value="{{ $user->name ?? old('name') }}">
    <x-icon.name class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray"/>
</x-form.input>
{{-- email address --}}
<x-form.label for="email">
    {{ __('Email') }}
</x-form.label>
<x-form.input :type="'email'" :name="'email'" class="w-full" autocomplete="email" required
              placeholder="johndoe@gmail.com" value="{{ $user->email ?? old('email') }}">
    <x-icon.email class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray"/>
</x-form.input>

{{-- password --}}
<x-form.label for="password">
    {{ __('Password') }}
</x-form.label>
<x-form.input :type="'password'" :name="'password'" class="w-full">
    <x-icon.password class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray"/>
</x-form.input>


{{-- confirm password --}}
<x-form.label for="confirm_password">
    {{ __('Confirm Password') }}
</x-form.label>
<x-form.input :type="'password'" :name="'confirm_password'" class="w-full">
    <x-icon.password class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray"/>
</x-form.input>

{{-- role --}}
<div>
    <x-form.label for="role_id">
        {{ __('Role') }}
    </x-form.label>
    <x-form.select :name="'role_id'" class="selector-for-js w-full" :options="$roles" :value="'id'"
                   :display="'name'" :selected="old('role_id') ?? ($user->role_id ?? null)">
        <x-icon.role class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray"/>
    </x-form.select>
</div>

