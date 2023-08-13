<x-app>
    <div>
        {{-- mobile canvas --}}
        <div id="mobile-nav" class="-z-10 relative" role="dialog" aria-modal="true">
            
            {{-- curtain --}}
            <div id="curtain" class="opacity-0 fixed inset-0 bg-gray-900/80"></div>

            <div class="fixed inset-0 flex">
                
                {{-- off screen canvas --}}
                <div id="side-panel" class="-translate-x-full relative mr-16 flex w-full max-w-xs flex-1">
                    
                    {{-- close menu button --}}
                    <div id="close-button" class="opacity-0 absolute left-full top-0 flex w-16 justify-center pt-5">
                        <button type="button" class="-m-2.5 p-2.5" id="close-menu">
                            <span class="sr-only">Close sidebar</span>
                            <svg class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- mobile nav --}}
                    <x-navbar.sidebar />
                </div>
            </div>
        </div>

        {{-- desktop canvas --}}
        <div class="shadow-lg hidden lg:fixed lg:inset-y-0 lg:z-40 lg:flex lg:w-72 lg:flex-col">
            {{-- mobile nav --}}
            <x-navbar.sidebar />
        </div>

        <div class="lg:pl-72">

            {{-- top navbar --}}
            <x-navbar.top />

            {{-- dashboard content --}}
            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    @if (session('success'))
                        <x-navbar.message :type="'success'">
                            {{ session('success') }}
                        </x-navbar>
                    @endif
                    @if (session('error'))
                        <x-navbar.message :type="'error'">
                            {{ session('error') }}
                        </x-navbar>
                    @endif
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</x-app>
