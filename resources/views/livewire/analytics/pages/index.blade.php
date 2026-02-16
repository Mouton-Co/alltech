<div>
    {{-- title --}}
    <h1 class="mb-3">Analytics</h1>
    <hr class="mb-2">

    {{-- apply filters --}}
    <div>
        <form
            method="GET"
            action="{{ route('analytics.index') }}"
        >
            {{-- 4 filters in a grid --}}
            <div class="grid w-full grid-cols-2 gap-x-4 gap-y-1">
                {{-- date range --}}
                <div class="flex w-full flex-col gap-1">
                    <label>Date Range</label>
                    <div class="relative w-full">
                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                            <x-icon.date-picker class="h-4" />
                        </div>
                        <input
                            class="js-date-range-picker focus:ring-orange focus:border-orange dark:focus:ring-orange dark:focus:border-orange block w-full rounded-lg border border-gray-300 bg-transparent bg-white p-2.5 pl-10 text-sm text-gray-900 dark:border-gray-600 dark:text-white dark:placeholder-gray-400"
                            name='date_range'
                            value='{{ $this->selectedDateRange }}'
                            placeholder="Select date"
                        >
                    </div>
                </div>
                {{-- company types --}}
                <div class="flex w-full flex-col gap-1">
                    <label for="company_type_ids[]">Company Types</label>
                    <select
                        class="selector-for-js filter-field w-full"
                        id="companyTypeSelect"
                        name="company_type_ids[]"
                        multiple
                    >
                        @foreach ($this->companyTypes as $id => $name)
                            <option
                                value="{{ $id }}"
                                @selected(in_array((string) $id, array_map('strval', $this->selectedCompanyTypeIds)))
                            >
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- users --}}
                <div class="flex w-full flex-col gap-1">
                    <label for="user_ids[]">Users</label>
                    <select
                        class="selector-for-js filter-field w-full"
                        name="user_ids[]"
                        multiple
                    >
                        <option value="">--Please select--</option>
                        @foreach ($this->users as $id => $name)
                            <option
                                value="{{ $id }}"
                                @selected(in_array((string) $id, array_map('strval', $this->selectedUserIds)))
                            >
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- regions --}}
                <div class="flex w-full flex-col gap-1">
                    <label for="regions[]">Regions</label>
                    <select
                        class="selector-for-js filter-field w-full"
                        name="regions[]"
                        multiple
                    >
                        <option value="">--Please select--</option>
                        @foreach ($this->regions as $name)
                            <option
                                value="{{ $name }}"
                                @selected(in_array((string) $name, array_map('strval', $this->selectedRegions)))
                            >
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- button --}}
            <div class="mt-3 flex w-full justify-end">
                <button
                    class="btn-orange max-w-fit px-4"
                    type="submit"
                >Update filters</button>
            </div>
        </form>
    </div>
</div>
