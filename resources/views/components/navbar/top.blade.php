<div class="sticky top-0 z-30 flex h-16 shrink-0 items-center gap-x-4
bg-white px-4 sm:gap-x-6 sm:px-6 lg:px-8 shadow-sidebar dark:bg-bg_gray dark:shadow-none
dark:border-b-2 dark:border-b-bg_seperator dark:border-solid">

    {{-- open menu button --}}
    <button type="button" class="-m-2.5 p-2.5 text-black lg:hidden dark:text-white">
        <x-icon.stripes id="open-menu" class="h-6" />
    </button>

    <div class="flex flex-1 justify-end gap-x-4 self-stretch lg:gap-x-6">
        <div class="flex items-center gap-x-4 lg:gap-x-6">

            {{-- profile --}}
            <div class="relative">

                {{-- profile on navbar --}}
                <button class="flex gap-2 items-center p-1.5" id="profile-dropdown-toggle" aria-expanded="false">
                    <x-icon.profile class="h-9" />

                    <span class="text-sm font-semibold leading-6">
                        {{ auth()->user()->name }}
                    </span>

                    <x-icon.arrow class="w-6" :direction="'down'" />
                </button>
                
                {{-- profile dropdown --}}
                <div class="absolute right-0 z-10 mt-1 w-32 origin-top-right rounded-md
                bg-white shadow-lg ring-1 ring-gray-900/5 focus:outline-none hidden profile-dropdown-hide
                dark:bg-bg_lightgray border-2 border-solid border-transparent dark:border-bg_seperator"
                id="profile-dropdown">
                    <a href="{{ route('user.edit', auth()->user()->id) }}"
                    class="block px-3 py-1 text-sm leading-6 rounded-t-md hover:bg-orange hover:text-white">
                        {{ __('Your profile') }}
                    </a>
                    <form class="w-full" action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="w-full block px-3 py-1 text-sm leading-6 rounded-b-md
                        hover:bg-orange hover:text-white text-left">
                            {{ __('Sign out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
