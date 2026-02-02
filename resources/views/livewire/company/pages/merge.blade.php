<div>
    {{-- title --}}
    <h1 class="mb-3">Merge companies into {{ $targetCompany['name'] ?? '' }}</h1>

    {{-- target company details --}}
    <div class="mb-3">
        {{-- title --}}
        <div class="border-b border-gray-300 pb-3">
            <div class="-ml-2 -mt-2 flex flex-wrap items-baseline">
                <h3 class="ml-2 mt-2 text-base font-semibold text-gray-900">Target Company</h3>
                <p class="ml-2 mt-1 truncate text-sm text-gray-500">
                    This is the company that will remain after the merge.
                </p>
            </div>
        </div>
        <div class="flex items-start justify-between gap-3">
            {{-- card information --}}
            <div class="pt-3 lg:col-start-3 lg:row-end-1">
                <div class="shadow-xs rounded-lg bg-white outline-1 outline-gray-900/5">
                    <dl class="flex flex-wrap">
                        <div class="flex-auto pl-6 pt-3">
                            <div class="flex gap-4">
                                <x-icon.company class="h-5 w-5 text-gray-400" />
                                <h3 class="text-sm font-medium leading-6 text-gray-900">
                                    {{ $targetCompany['name'] ?? '' }}
                                </h3>
                            </div>
                        </div>
                    </dl>
                    <div class="mt-3 border-t border-gray-900/5 px-6 py-3">
                        <div class="flex gap-4">
                            <x-icon.location class="h-5 w-5 text-gray-400" />
                            <h3 class="text-sm font-medium leading-6 text-gray-900">
                                {{ $targetCompany['location'] ?? '' }}
                            </h3>
                        </div>
                        <div class="flex gap-4">
                            <x-icon.coordinates class="h-5 w-5 text-gray-400" />
                            <h3 class="text-sm font-medium leading-6 text-gray-900">
                                {{ $targetCompany['region'] ?? '' }}
                            </h3>
                        </div>
                        <div class="flex gap-4">
                            <x-icon.company-type class="h-5 w-5 text-gray-400" />
                            <h3 class="text-sm font-medium leading-6 text-gray-900">
                                {{ $targetCompany['company_type'] ?? '' }}
                            </h3>
                        </div>
                        <div class="flex gap-4">
                            <x-icon.contact class="h-5 w-5 text-gray-400" />
                            <h3 class="flex items-center gap-1 text-sm font-medium leading-6 text-gray-900">
                                <span>Has {{ $targetCompany['contacts_count'] }} contacts</span>
                                <span class="flex items-center gap-1 text-yellow-400">
                                    <x-icon.arrow class="h-4 w-4 -rotate-90" />
                                    {{ $this->newContactCount() }} contacts
                                </span>
                            </h3>
                        </div>
                        <div class="flex gap-4">
                            <x-icon.meeting class="h-5 w-5 text-gray-400" />
                            <h3 class="flex items-center gap-1 text-sm font-medium leading-6 text-gray-900">
                                <span>Has {{ $targetCompany['meetings_count'] }} meetings</span>
                                <span class="flex items-center gap-1 text-yellow-400">
                                    <x-icon.arrow class="h-4 w-4 -rotate-90" />
                                    {{ $this->newMeetingCount() }} meetings
                                </span>
                            </h3>
                        </div>
                    </div>
                </div>
            </div>
            {{-- warning --}}
            <div class="max-w-md flex-auto pt-3 lg:col-start-3 lg:row-end-1">
                <div class="shadow-xs rounded-lg border border-yellow-400 bg-yellow-50 p-4">
                    <div class="flex items-center gap-2 text-yellow-500">
                        <x-icon.warning class="h-6 w-6" />
                        <span class="font-bold">Warning</span>
                    </div>
                    <p class="text-sm text-yellow-400">
                        Merging companies is irreversible. All selected companies will be permanently merged into
                        <strong>{{ $targetCompany['name'] ?? '' }}</strong>. All related contacts and meetings
                        for selected companies will permanently transfer to the target company.
                        Please ensure you have selected the correct companies to merge before proceeding.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- select companies to merge --}}
    <div>
        <div class="flex items-center justify-between border-b border-gray-300 pb-3">
            {{-- title --}}
            <div class="-ml-2 -mt-2 flex items-baseline">
                <h3 class="ml-2 mt-2 text-base font-semibold text-gray-900">Companies to merge</h3>
                <p class="ml-2 mt-1 truncate text-sm text-gray-500">
                    Select the ones to merge into the target company.
                </p>
            </div>
            {{-- search --}}
            <div class="relative">
                <input
                    class="border-gray bg-lightgray focus:ring-orange focus:border-orange h-7 w-96 pb-[9.5px] shadow"
                    type="text"
                    placeholder="Search..."
                    wire:model.live.debounce.250ms="search"
                >
                <x-icon.search class="absolute right-[2px] top-[2px] h-5 w-5 cursor-text text-gray-400" />
            </div>
        </div>
        {{-- table --}}
        <div class="no-scrollbar mt-3 max-h-96 overflow-scroll">
            <table class="index-table">
                <thead>
                    <tr>
                        <th class="sticky top-0 z-10">
                            {{ count(array_filter($this->companies, fn($company) => $company['selected'])) }} selected
                        </th>
                        <th class="sticky top-0 z-10"><span class="flex items-center gap-2">Name</span></th>
                        <th class="sticky top-0 z-10"><span class="flex items-center gap-2">Location</span></th>
                        <th class="sticky top-0 z-10"><span class="flex items-center gap-2">Region</span></th>
                        <th class="sticky top-0 z-10"><span class="flex items-center gap-2">Company Type</span></th>
                        <th class="sticky top-0 z-10"><span class="flex items-center gap-2">Contacts</span></th>
                        <th class="sticky top-0 z-10"><span class="flex items-center gap-2">Meetings</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->filteredCompanies() as $id => $company)
                        <tr>
                            <td>
                                <input
                                    class="cursor-pointer"
                                    type="checkbox"
                                    wire:key="company-select-{{ $id }}"
                                    wire:model.live="companies.{{ $id }}.selected"
                                />
                            </td>
                            <td>{{ $company['name'] }}</td>
                            <td>{{ $company['location'] }}</td>
                            <td>{{ $company['region'] }}</td>
                            <td>{{ $company['company_type'] }}</td>
                            <td>{{ $company['contacts_count'] }}</td>
                            <td>{{ $company['meetings_count'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- confirm --}}
    <div class="mb-48 flex justify-end">
        <div class="flex flex-col items-end gap-2">
            {{-- confirmation --}}
            <div class="mt-6 flex items-center gap-3">
                <input
                    class="cursor-pointer"
                    type="checkbox"
                    wire:model.live="confirm"
                />
                <label
                    class="text-sm text-gray-700"
                    for="confirm-merge"
                >
                    I understand that this action cannot be undone.
                </label>
            </div>
            {{-- button --}}
            @php
                $class = !$this->confirm ? '!bg-gray-300 cursor-not-allowed' : '';
            @endphp
            <button
                class="btn-orange {{ $class }} w-fit px-5"
                wire:click="merge"
                wire:target="merge"
                wire:loading.class="!bg-gray-300 cursor-not-allowed"
                wire:loading.attr="disabled"
            >
                <div
                    wire:loading.remove
                    wire:target="merge"
                >Merge</div>
                <div
                    wire:loading
                    wire:target="merge"
                >Merging...</div>
            </button>
        </div>
    </div>
</div>
