<x-app>
    <div class="flex min-h-full flex-col justify-center py-12 sm:px-6 lg:px-8">

        {{-- logo --}}
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <x-img.logo-full-light />
        </div>

        {{-- login form --}}
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
            <div class="card">
                <form class="space-y-6" action="#" method="POST">

                    {{-- email address --}}
                    <div>
                        <x-forms.label :value="'Email address'" />
                        <div class="mt-2">
                            <x-forms.input :type="'email'" name="email" autocomplete="email" required
                                placeholder="johndoe@gmail.com" />
                        </div>
                    </div>

                    {{-- password --}}
                    <div>
                        <x-forms.label :value="'Password'" />
                        <div class="mt-2">
                            <x-forms.input :type="'password'" name="password" required />
                        </div>
                    </div>

                    {{-- button --}}
                    <div>
                        <button type="submit" class="btn-primary">
                            {{ __('Sign in') }}
                        </button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

</x-app>
