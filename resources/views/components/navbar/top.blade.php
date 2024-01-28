{{-- top navbar --}}
<nav class="w-full h-16 relative flex justify-between items-center border-b border-gray-200 shadow-sm gap-x-4 px-4
sm:gap-x-6 sm:px-6 cursor-default bg-white">
    {{-- menu open icon --}}
    <x-icon.stripes id="sidebar-toggle-open" class="aspect-square w-7 text-gray-500 cursor-pointer z-40"/>

    {{-- profile --}}
    <div id="profile-dropdown-toggle" class="-m-1.5 flex items-center p-1.5 cursor-pointer z-20">
        <span class="inline-block aspect-square h-10 overflow-hidden rounded-full bg-gray-100 shadow">
            <x-icon.profile class="h-full aspect-square text-gray-300" />
        </span>
        <span class="hidden md:flex md:items-center">
            <span class="ml-4 text-base font-semibold leading-6 text-gray-700" aria-hidden="true">
                {{ auth()->user()->name }}
            </span>
            <x-icon.dropdown-arrow class="h-5 aspect-square ml-2 text-gray-400" />
        </span>
    </div>

    {{-- profile dropdown --}}
    <div id="profile-dropdown" class="absolute right-0 top-0 z-20 mt-14 mr-4 sm:mr-6 w-32 rounded-md bg-white
    py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none transition ease-in duration-75 transform
    opacity-0 scale-95" aria-hidden="true">
        <a href="{{ route('user.edit', auth()->user()->id) }}" class="block px-3 py-1 text-sm leading-6
        text-gray-900 hover:bg-gray-50">
            {{ __('Your profile') }}
        </a>
        <form action="{{ route('logout') }}" method="post" class="w-full cursor-pointer">
            @csrf
            <input type="submit" value="Sign out" class="block px-3 py-1 text-sm leading-6 text-gray-900
            hover:bg-gray-50 w-full cursor-pointer text-left">
        </form>
    </div>
</nav>
