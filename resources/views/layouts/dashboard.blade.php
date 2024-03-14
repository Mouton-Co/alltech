<x-app>

    {{-- curtains --}}
    <div id="curtain-invisible" class="w-full h-full fixed top-0 left-0 z-10 opacity-70 bg-transparent hidden"></div>
    <div id="curtain" class="w-full h-full fixed top-0 left-0 z-40 opacity-70 bg-black hidden"></div>
    <div id="curtain-mobile" class="w-full h-full fixed top-0 left-0 z-20 opacity-70 bg-black hidden"></div>
    
    {{-- top navbar --}}
    <x-navbar.top />

    {{-- sidebar --}}
    <x-navbar.sidebar />

    {{-- dashboard --}}
    <main class="w-full max-h-screen overflow-auto" aria-label="main">
        <div class="w-full pt-10 lg:pl-80 pr-20 pb-28">
            <div class="w-full pl-6">
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
        </div>
    </main>

</x-app>
