<div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white dark:bg-bg_gray px-6 pb-4
dark:border-solid dark:border-r-2 dark:border-r-bg_seperator">
    {{-- app logo --}}
    <div class="flex h-16 shrink-0 items-center">
        <x-img.logo-full-light class="w-[146px] logo-light {{ auth()->user()->dark ? 'hidden' : '' }}"/>
        <x-img.logo-full-dark class="w-[146px] logo-dark {{ !auth()->user()->dark ? 'hidden' : '' }}"/>
    </div>
    <nav class="flex flex-1 flex-col">
        <ul role="list" class="flex flex-1 flex-col gap-y-7">
            {{-- user links --}}
            <li>
                <ul role="list" class="-mx-2 space-y-1">
                    <li>
                        <x-navbar.link>
                            <x-icon.calendar class="w-7"/>
                            Meeting planner
                        </x-navbar.link>
                    </li>
                </ul>
            </li>
            {{-- admin links --}}
            <li>
                <div class="text-xs font-semibold leading-6 text-gray-400">Administration</div>
                <ul role="list" class="-mx-2 mt-2 space-y-1">
                    <li>
                        <x-navbar.link :link="route('user.index')"
                        :active="request()->segment(1) == 'users' ? true : false">
                            <x-icon.users class="w-7" />
                            Users
                        </x-navbar.link>
                        <x-navbar.link :link="route('contact.index')"
                        :active="request()->segment(1) == 'contacts' ? true : false">
                            <x-icon.contact class="w-8 -mx-[3px]"/>
                            Contacts
                        </x-navbar.link>
                        <x-navbar.link :link="route('company.index')"
                        :active="request()->segment(1) == 'companies' ? true : false">
                            <x-icon.company class="w-7"/>
                            Companies
                        </x-navbar.link>
                        <x-navbar.link :link="route('company-type.index')"
                        :active="request()->segment(1) == 'company-types' ? true : false">
                            <x-icon.company-type class="w-7"/>
                            Company types
                        </x-navbar.link>
                    </li>
                </ul>
            </li>
            {{-- dark mode toggle --}}
            <li class="mt-auto flex justify-end">
                <x-navbar.dark-mode :active="auth()->user()->dark"/>
            </li>
        </ul>
    </nav>
</div>
