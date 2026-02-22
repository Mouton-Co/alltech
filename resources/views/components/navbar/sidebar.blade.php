<div
    class="fixed left-0 top-0 z-30 flex h-full w-80 -translate-x-full transform flex-col border border-gray-200 bg-white px-6 py-6 transition duration-300 ease-in-out lg:translate-x-0"
    id="sidebar"
>

    {{-- close icon --}}
    <x-icon.x
        class="absolute -right-10 top-6 hidden aspect-square w-7 cursor-pointer text-white"
        id="sidebar-toggle-close"
    />

    {{-- logo --}}
    <a
        class="mb-12 w-full pr-12"
        href="{{ route('dashboard') }}"
    >
        <img
            class="w-full"
            src="{{ asset('img/logo-black.png') }}"
            alt="No image found"
        >
    </a>

    {{-- nav links --}}
    <div class="flex flex-col gap-1">

        {{-- top nav links --}}
        <x-navbar.link
            href="{{ route('meeting.index') }}"
            :active="request()->segment(1) == 'meetings'"
        >
            <x-icon.calendar
                class="group-hover:text-orange {{ request()->segment(1) == 'meetings' ? 'text-orange' : 'text-gray-400' }} w-7"
            />
            {{ __('Meeting planner') }}
        </x-navbar.link>
        <x-navbar.link
            href="{{ route('reporting.report') }}"
            :active="request()->segment(1) == 'reporting'"
        >
            <x-icon.reporting
                class="group-hover:text-orange {{ request()->segment(1) == 'reporting' ? 'text-orange' : 'text-gray-400' }} w-7"
            />
            {{ __('Reporting') }}
        </x-navbar.link>
        <x-navbar.link
            href="{{ route('calendar.index') }}"
            :active="request()->segment(1) == 'calendar'"
        >
            <x-icon.pdf
                class="group-hover:text-orange {{ request()->segment(1) == 'calendar' ? 'text-orange' : 'text-gray-400' }} w-7"
            />
            {{ __('Calendar export') }}
        </x-navbar.link>
        @if (auth()->user()->role?->name === 'Admin')
            <x-navbar.link
                href="{{ route('analytics.index') }}"
                :active="request()->segment(1) == 'analytics'"
            >
                <x-icon.analytics
                    class="group-hover:text-orange {{ request()->segment(1) == 'analytics' ? 'text-orange' : 'text-gray-400' }} w-7"
                />
                {{ __('Analytics') }}
            </x-navbar.link>
        @endif

        <div class="pt-8 text-sm font-semibold leading-6 text-gray-400">{{ __('Administration') }}</div>

        {{-- bottom nav links --}}
        <x-navbar.link
            href="{{ route('user.index') }}"
            :active="request()->segment(1) == 'users'"
        >
            <x-icon.users
                class="group-hover:text-orange {{ request()->segment(1) == 'users' ? 'text-orange' : 'text-gray-400' }} w-7"
            />
            {{ __('Users') }}
        </x-navbar.link>
        <x-navbar.link
            href="{{ route('contact.index') }}"
            :active="request()->segment(1) == 'contacts'"
        >
            <x-icon.contact
                class="group-hover:text-orange {{ request()->segment(1) == 'contacts' ? 'text-orange' : 'text-gray-400' }} w-7"
            />
            {{ __('Contacts') }}
        </x-navbar.link>
        <x-navbar.link
            href="{{ route('company.index') }}"
            :active="request()->segment(1) == 'companies'"
        >
            <x-icon.company
                class="group-hover:text-orange {{ request()->segment(1) == 'companies' ? 'text-orange' : 'text-gray-400' }} w-7"
            />
            {{ __('Companies') }}
        </x-navbar.link>
        <x-navbar.link
            href="{{ route('company-type.index') }}"
            :active="request()->segment(1) == 'company-types'"
        >
            <x-icon.company-type
                class="group-hover:text-orange {{ request()->segment(1) == 'company-types' ? 'text-orange' : 'text-gray-400' }} w-7"
            />
            {{ __('Company types') }}
        </x-navbar.link>

    </div>

</div>
