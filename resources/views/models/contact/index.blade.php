<x-dashboard>

    {{-- see if there's any modal errors and show the modal if the case --}}
    @php
        $hasStoreErrors = false;
        $hasUpdateErrors = false;

        foreach ($errors->getBags() as $bagKey => $bag) {
            if ($bagKey === 'contactStore') {
                $hasStoreErrors = true;
                $errors->default = $errors->$bagKey;
                break;
            }
            if (str_contains($bagKey, 'contactUpdate')) {
                $hasUpdateErrors = true;
                $updateErrorId = explode('--', $bagKey)[1];
                $errors->default = $errors->$bagKey;
                break;
            }
        }
    @endphp

    {{-- curtain --}}
    <x-modals.curtain :show="$hasStoreErrors | $hasUpdateErrors" />

    {{-- add modal --}}
    <x-modals.resource
        id="add-resource-modal"
        :route="route('contact.store')"
        :show="$hasStoreErrors"
        :title="'Creating contact'"
        :button="'Create'"
    >
        <div class="flex w-full flex-col gap-3">
            @include('models.contact.form', ['contact' => null, 'companies' => $companies])
        </div>
    </x-modals.resource>

    {{-- title and search --}}
    <div class="mb-3 flex justify-between">
        <h1>{{ __('Contacts') }}</h1>
        <div class="flex items-center justify-between gap-3">
            <a
                class="hover:text-orange"
                href="{{ route('contacts.export') }}"
            >
                <x-icon.excel class="h-4 w-4" />
            </a>
            <form
                class="relative"
                action=""
            >
                <input
                    class="smaller-than-740:w-full border-gray bg-lightgray focus:ring-orange focus:border-orange h-7 w-64 pb-[9.5px] shadow"
                    name="search"
                    type="text"
                    value="{{ request()->query('search') ?? '' }}"
                    placeholder="Search..."
                >
                <input
                    name="order_by"
                    type="hidden"
                    value="{{ request()->query('order_by') ?? 'name' }}"
                >
                <input
                    name="order_direction"
                    type="hidden"
                    value="{{ request()->query('order_direction') ?? 'asc' }}"
                >
                <input
                    name="page"
                    type="hidden"
                    value="{{ request()->query('page') ?? 1 }}"
                >
                <button
                    class="absolute right-[2px] top-[2px]"
                    type="submit"
                >
                    <x-icon.search />
                </button>
            </form>
        </div>
    </div>

    {{-- index table --}}
    <div class="no-scrollbar overflow-scroll">
        <table class="index-table">
            <caption class="hidden">{{ __('Contacts index table') }}</caption>
            <thead>
                <tr>
                    @foreach (config('models.contact.columns') as $field => $column)
                        <th>
                            <span class="flex items-center gap-2">
                                {{ $column }}
                                <form
                                    action="{{ route('contact.index') }}"
                                    method="GET"
                                >
                                    <input
                                        name="search"
                                        type="hidden"
                                        value="{{ request()->query('search') ?? '' }}"
                                    >
                                    <input
                                        name="order_by"
                                        type="hidden"
                                        value="{{ $field }}"
                                    >
                                    <input
                                        name="page"
                                        type="hidden"
                                        value="{{ request()->query('page') ?? 1 }}"
                                    >
                                    <input
                                        name="order_direction"
                                        type="hidden"
                                        value="{{ !empty(request()->query('order_by')) &&
                                        request()->query('order_by') == $field &&
                                        request()->query('order_direction') == 'asc'
                                            ? 'desc'
                                            : 'asc' }}"
                                    >
                                    <button type="submit">
                                        <x-icon.up-arrow
                                            class="{{ !empty(request()->query('order_by')) &&
                                            request()->query('order_by') == $field &&
                                            request()->query('order_direction') == 'asc'
                                                ? 'rotate-180'
                                                : '' }} h-[10px] cursor-pointer"
                                        />
                                    </button>
                                </form>
                            </span>
                        </th>
                    @endforeach
                    <th class="flex justify-end">
                        <span
                            class="hover:text-orange flex cursor-pointer items-center gap-3"
                            id="add-resource"
                        >
                            <x-icon.plus class="h-4 w-4" />
                            {{ __('Add contact') }}
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        @foreach (config('models.contact.columns') as $field => $column)
                            @if (str_contains($field, '->'))
                                <td>{{ App\Http\Services\ModelService::nestedValue($contact, $field) }}</td>
                            @else
                                <td>{{ $contact->$field }}</td>
                            @endif
                        @endforeach
                        <td class="flex items-center justify-end gap-2">
                            <x-icon.edit
                                class="text-blue hover:text-orange edit-icon w-4 cursor-pointer"
                                id="edit-{{ $contact->id }}"
                            />
                            <x-icon.delete
                                class="text-blue hover:text-orange delete-icon w-6 cursor-pointer"
                                id="delete-{{ $contact->id }}"
                            />
                            @if (auth()->user()->role->name === 'Admin')
                                <a
                                    class="text-blue hover:text-orange h-4 w-4 cursor-pointer"
                                    href="{{ route('contact.merge', $contact->id) }}"
                                >
                                    <x-icon.merge class="h-4 w-4" />
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($contacts as $contact)
        {{-- delete modals --}}
        <x-modals.delete
            id="delete-modal-{{ $contact->id }}"
            :resource="$contact"
            :route="'contact'"
            :message="'Are you sure you wish to delete the contact ' .
                $contact->name .
                '? All meetings
                                    associated with this contact will be removed as well.'"
        />

        {{-- edit modals --}}
        <x-modals.resource
            id="edit-resource-modal-{{ $contact->id }}"
            :route="route('contact.update', $contact->id)"
            :title="'Editing contact'"
            :button="'Update'"
            :show="$hasUpdateErrors && $updateErrorId == $contact->id"
        >
            <div class="flex w-full flex-col gap-3">
                @include('models.contact.form', ['contact' => $contact, 'companies' => $companies])
            </div>
        </x-modals.resource>
    @endforeach

    {{-- pagination --}}
    {{ $contacts->appends([
            'search' => request()->query('search') ?? '',
            'order_by' => request()->query('order_by') ?? 'name',
            'order_direction' => request()->query('order_direction') ?? 'asc',
        ])->links() }}

</x-dashboard>
