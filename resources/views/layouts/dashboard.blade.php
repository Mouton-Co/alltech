<x-app>

    {{-- navbar top --}}
    <nav class="w-full bg-torquise flex justify-end py-4 pr-16 shadow-solidlightblue" aria-label="navbar">

        <div class="relative font-bold text-lg">
            {{-- dropdown toggle --}}
            <div class="h-14 bg-gray flex w-fit items-center p-1 pr-5 rounded-pill cursor-pointer z-20 relative
            border border-[#d0d0d0] shadow" id="settings-toggle">
                <div class="h-full aspect-square rounded-[50vw] mr-4 bg-cover bg-center bg-no-repeat"
                style="background-image: url({{ asset("img/profile.jpeg") }})">
                </div>
                <div>{{ auth()->user()->name }}</div>
                <x-icon.arrow :direction="'down'" class="h-6 transition-all" id="settings-arrow" />
            </div>

            {{-- dropdown --}}
            <div class="h-14 pt-14 w-full absolute top-0 left-0 z-10 bg-gray
            transition-all overflow-hidden rounded-[1.8rem] text-darkgray text-base shadow"
            id="settings-dropdown" aria-expanded="false">
                <a href=""
                    class="block w-full pl-5 py-2 hover:bg-[#c5c5c5] mt-[5px]">
                    {{ __('Your profile') }}
                </a>
                <form class="block w-full pl-5 py-2 hover:bg-[#c5c5c5]" action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" class="w-full text-left">
                        {{ __('Sign out') }}
                    </button>
                </form>
            </div>
        </div>

    </nav>

    {{-- sidebar desktop --}}
    <nav class="absolute top-0 left-0 h-full bg-transparent pt-20 pb-4 pl-4 pr-10" aria-label="sidebar">
        <div class="bg-black text-white h-full w-full rounded-pill pt-28 pl-4 pr-8 shadow-solidnothing
        relative">
            <div class="flex flex-1 flex-col gap-y-7">
                <div class="space-y-3">
                    <x-navbar.link :link="route('meeting.index')"
                    :active="request()->segment(1) == 'meetings'">
                        <x-icon.calendar class="w-7"/>
                        {{ __('Meeting planner') }}
                    </x-navbar.link>
                    <x-navbar.link :link="route('reporting.index')"
                    :active="request()->segment(1) == 'reporting'" class="mb-7">
                        <x-icon.reporting class="w-7"/>
                        {{ __('Reporting') }}
                    </x-navbar.link>
                    <div class="text-xs leading-6 text-gray">{{ __('Administration') }}</div>
                    <x-navbar.link :link="route('user.index')"
                    :active="request()->segment(1) == 'users'">
                        <x-icon.users class="w-7" />
                        {{ __('Users') }}
                    </x-navbar.link>
                    <x-navbar.link :link="route('contact.index')"
                    :active="request()->segment(1) == 'contacts'">
                        <x-icon.contact class="w-8 -mx-[3px]"/>
                        {{ __('Contacts') }}
                    </x-navbar.link>
                    <x-navbar.link :link="route('company.index')"
                    :active="request()->segment(1) == 'companies'">
                        <x-icon.company class="w-7"/>
                        {{ __('Companies') }}
                    </x-navbar.link>
                    <x-navbar.link :link="route('company-type.index')"
                    :active="request()->segment(1) == 'company-types'">
                        <x-icon.company-type class="w-7"/>
                        {{ __('Company types') }}
                    </x-navbar.link>
                </div>
            </div>
            <img src="{{ asset('img/logo-white.png') }}" alt="No image found"
            class="max-w-[164px] absolute bottom-24 ml-1">
        </div>
    </nav>

    {{-- dashboard --}}
    <main class="w-full" aria-label="main">
        <div class="w-full pt-[106px] pl-80 pr-20 pb-28">
            @php $messageTypes = ['success', 'error']; @endphp
            @foreach ($messageTypes as $messageType)
                @if (session()->has($messageType))
                    <x-navbar.message :type="$messageType">
                        {{ session()->get($messageType) }}
                    </x-navbar.message>
                @endif
            @endforeach
            {{ $slot ?? null }}
        </div>
    </main>

</x-app>
