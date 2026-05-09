<div>
    {{-- title and search --}}
    <div class="mb-3 flex items-center justify-between">
        {{-- title --}}
        <h1>Contacts</h1>

        {{-- search --}}
        <div class="flex items-center gap-3">
            <a
                class="hover:text-orange"
                href="{{ route('contacts.export') }}"
            >
                <x-icon.excel class="h-4 w-4" />
            </a>
            <div class="relative">
                <input
                    class="h-7 w-96 border-gray bg-lightgray pb-[9.5px] shadow focus:border-orange focus:ring-orange"
                    type="text"
                    placeholder="Search..."
                    wire:model.live.debounce.250ms="search"
                >
                <x-icon.search class="absolute right-[2px] top-[5px] h-5 w-5 cursor-text text-gray-400" />
            </div>
        </div>
    </div>

    {{-- table --}}
    <div class="no-scrollbar mt-3 overflow-scroll">
        <table class="index-table">
            <thead>
                <tr>
                    <x-table.column
                        label='Name'
                        column='name'
                    />
                    <x-table.column
                        label='Email'
                        column='email'
                    />
                    <x-table.column
                        label='Phone'
                        column='phone'
                    />
                    <x-table.column
                        label='Company'
                        column='company_name'
                    />
                    <x-table.column
                        label='Location'
                        column='company_location'
                    />
                    <x-table.column
                        label='Region'
                        column='company_region'
                    />
                    <x-table.column
                        label='Type'
                        column='company_type'
                    />
                    <th>
                        <div
                            class="flex cursor-pointer items-center gap-2 hover:text-orange"
                            wire:click="$dispatch('contact.modals.create.show')"
                        >
                            <x-icon.plus class="size-4" />
                            <span>Add contact</span>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($this->contacts as $contact)
                    <tr wire:key='{{ $contact->id }}'>
                        <td>{{ $contact->name ?? '' }}</td>
                        <td>{{ $contact->email ?? '' }}</td>
                        <td>{{ $contact->phone ?? '' }}</td>
                        <td>{{ $contact->company?->name ?? '' }}</td>
                        <td>{{ $contact->company?->location ?? '' }}</td>
                        <td>{{ $contact->company?->region ?? '' }}</td>
                        <td>{{ $contact->company?->companyType?->name ?? '' }}</td>
                        <td class="flex justify-end">
                            <div class="flex items-center gap-2">
                                <x-icon.edit
                                    class="edit-icon w-4 cursor-pointer text-blue hover:text-orange"
                                    wire:click="$dispatch('contact.modals.edit.show', {
                                        id: {{ $contact->id }}
                                    })"
                                />
                                <x-icon.delete
                                    class="delete-icon w-6 cursor-pointer text-blue hover:text-orange"
                                    wire:click="$dispatch('modals.delete.show', {
                                        id: {{ $contact->id }},
                                        class: 'App\\\\Models\\\\Contact',
                                        callback: 'contact.pages.index.render'
                                    })"
                                />
                                @if (auth()->user()->role->name === 'Admin')
                                    <a
                                        class="h-4 w-4 cursor-pointer text-blue hover:text-orange"
                                        href="{{ route('contact.merge', $contact->id) }}"
                                        wire:navigate
                                    >
                                        <x-icon.merge class="h-4 w-4" />
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- pagination --}}
    {{ $this->contacts->links() }}

    {{-- modals --}}
    <livewire:modals.delete />
    <livewire:contact.modals.edit />
    <livewire:contact.modals.create />
</div>
