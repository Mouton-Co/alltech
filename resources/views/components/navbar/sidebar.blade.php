<div class="fixed top-0 left-0 h-full z-30 flex w-80 flex-col bg-white
border border-gray-200 py-6 px-6 -translate-x-full lg:translate-x-0 transition ease-in-out
duration-300 transform" id="sidebar">

    {{-- close icon --}}
    <x-icon.x class="absolute top-6 -right-10 w-7 aspect-square text-white cursor-pointer hidden"
    id="sidebar-toggle-close"/>

    {{-- logo --}}
    <a class="w-full pr-12 mb-12" href="{{ route('dashboard') }}">
        <img src="{{ asset('img/logo-black.png') }}" alt="No image found" class="w-full">
    </a>

    {{-- nav links --}}
    <div class="flex flex-col gap-1">

        {{-- top nav links --}}
        <x-navbar.link href="{{ route('meeting.index') }}" :active="request()->segment(1) == 'meetings'">
            <x-icon.calendar class="w-7 group-hover:text-orange {{ request()->segment(1) == 'meetings' ?
            'text-orange' : 'text-gray-400' }}"/>
            {{ __('Meeting planner') }}
        </x-navbar.link>
        <x-navbar.link href="{{ route('reporting.report') }}" :active="request()->segment(1) == 'reporting'">
            <x-icon.reporting class="w-7 group-hover:text-orange {{ request()->segment(1) == 'reporting' ?
            'text-orange' : 'text-gray-400' }}"/>
            {{ __('Reporting') }}
        </x-navbar.link>
        <x-navbar.link href="{{ route('calendar.index') }}" :active="request()->segment(1) == 'calendar'">
            <x-icon.pdf class="w-7 group-hover:text-orange {{ request()->segment(1) == 'calendar' ?
            'text-orange' : 'text-gray-400' }}"/>
            {{ __('Calendar export') }}
        </x-navbar.link>

        <div class="pt-8 text-sm font-semibold leading-6 text-gray-400">{{ __('Administration') }}</div>

        {{-- bottom nav links --}}
        <x-navbar.link href="{{ route('user.index') }}" :active="request()->segment(1) == 'users'">
            <x-icon.users class="w-7 group-hover:text-orange {{ request()->segment(1) == 'users' ?
            'text-orange' : 'text-gray-400' }}"/>
            {{ __('Users') }}
        </x-navbar.link>
        <x-navbar.link href="{{ route('contact.index') }}" :active="request()->segment(1) == 'contacts'">
            <x-icon.contact class="w-7 group-hover:text-orange {{ request()->segment(1) == 'contacts' ?
            'text-orange' : 'text-gray-400' }}"/>
            {{ __('Contacts') }}
        </x-navbar.link>
        <x-navbar.link href="{{ route('company.index') }}" :active="request()->segment(1) == 'companies'">
            <x-icon.company class="w-7 group-hover:text-orange {{ request()->segment(1) == 'companies' ?
            'text-orange' : 'text-gray-400' }}"/>
            {{ __('Companies') }}
        </x-navbar.link>
        <x-navbar.link href="{{ route('company-type.index') }}" :active="request()->segment(1) == 'company-types'">
            <x-icon.company-type class="w-7 group-hover:text-orange
            {{ request()->segment(1) == 'company-types' ? 'text-orange' : 'text-gray-400' }}"/>
            {{ __('Company types') }}
        </x-navbar.link>

    </div>

</div>
