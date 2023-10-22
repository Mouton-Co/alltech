<x-app>
    {{-- form --}}
    <div class="w-[380px] smaller-than-380:w-full mx-auto flex h-full flex-col justify-center">
        {{-- logo --}}
        <img src="{{ asset('img/logo-black.png') }}" alt="No image found" class="ml-1">

        {{-- login form --}}
        <form class="space-y-7 flex flex-col px-[40px]" action="{{ route('login') }}" method="POST">
            @csrf

            {{-- email address --}}
            <x-form.input :type="'email'" :name="'email'" autocomplete="email" required
                placeholder="Email" value="{{ old('email') }}" class="w-full">
                <x-icon.email class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
            </x-form.input>

            {{-- password --}}
            <x-form.input :type="'password'" :name="'password'" placeholder="Password" required class="w-full">
                <x-icon.password class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
            </x-form.input>

            {{-- button --}}
            <button type="submit" class="btn-orange">
                {{ __('Login') }}
            </button>
        </form>
    </div>

    {{-- bottom image --}}
    <div class="w-full flex overflow-hidden">
        <x-img.footer-line />
    </div>
</x-app>
