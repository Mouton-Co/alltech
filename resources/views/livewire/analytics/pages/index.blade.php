<div>
    {{-- title --}}
    <h1 class="mb-3">Please specify the specifics for the report</h1>
    <hr class="mb-2">

    {{-- update report --}}
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
            {{-- group by A --}}
            <div class="flex w-full flex-col gap-1">
                <label for="group_by_a">
                    <span class="text-red-500">*</span>
                    Group results by
                </label>
                <select
                    class="filter-field w-full"
                    name='group_by_a'
                >
                    <option value="">--Please select--</option>
                    @foreach ($this->groupBy as $groupByOption)
                        <option
                            value="{{ $groupByOption }}"
                            @selected($this->groupByA === $groupByOption)
                        >{{ $groupByOption }}</option>
                    @endforeach
                </select>
            </div>
            {{-- group by B --}}
            <div class="flex w-full flex-col gap-1">
                <label for="group_by_b">Then by</label>
                <select
                    class="filter-field w-full"
                    name='group_by_b'
                >
                    <option value="">--Please select--</option>
                    @foreach ($this->groupBy as $groupByOption)
                        <option
                            value="{{ $groupByOption }}"
                            @selected($this->groupByB === $groupByOption)
                        >{{ $groupByOption }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-1 flex w-full items-end justify-between">
            {{-- metric --}}
            <div class="flex flex-col gap-1">
                <label for="group_by_a">
                    <span class="text-red-500">*</span>
                    Metric - What do you need to count?
                </label>
                <div class="flex flex-col space-y-1">
                    @foreach ($this->metrics as $metricOption)
                        <div class="flex items-center">
                            <input
                                class="not-checked:before:hidden checked:border-orange checked:bg-orange focus-visible:outline-orange relative size-4 cursor-pointer appearance-none rounded-full border border-gray-300 bg-white before:absolute before:inset-1 before:rounded-full before:bg-white focus-visible:outline-2 focus-visible:outline-offset-2 disabled:border-gray-300 disabled:bg-gray-100 disabled:before:bg-gray-400 forced-colors:appearance-auto forced-colors:before:hidden"
                                name="metric"
                                type="radio"
                                value="{{ $metricOption }}"
                                @checked($this->metric === $metricOption)
                            />
                            <label class="ml-3 block text-sm/6 font-medium text-gray-900">{{ $metricOption }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- button --}}
            <button
                class="btn-orange-thin max-w-fit px-4"
                type="submit"
            >Update report</button>
        </div>
    </form>

    {{-- view report --}}
    <h1 class="mb-3 mt-6">Analytics report</h1>
    <hr class="mb-2">

    <div
        class="max-w-fit rounded border border-red-600 bg-red-200 px-8 py-2 text-red-600"
        wire:show="$errors.has('groupByA') || $errors.has('metric')"
    >
        <ul class="list-disc">
            <li
                wire:show="$errors.has('groupByA')"
                wire:text="$errors.first('groupByA')"
            ></li>
            <li
                wire:show="$errors.has('metric')"
                wire:text="$errors.first('metric')"
            ></li>
        </ul>
    </div>
    {{-- table --}}
    <div class="no-scrollbar mt-3 max-h-96 overflow-scroll">
        <table class="index-table">
            <thead>
                <tr>
                    @if ($this->groupByA)
                        <th class="sticky top-0 z-10">
                            <span class="flex items-center gap-2">
                                {{ $this->groupByA }}
                            </span>
                        </th>
                    @endif
                    @if ($this->groupByB)
                        <th class="sticky top-0 z-10">
                            <span class="flex items-center gap-2">
                                {{ $this->groupByB }}
                            </span>
                        </th>
                    @endif
                    @if ($this->metric)
                        <th class="sticky top-0 z-10">
                            <span class="flex items-center gap-2">
                                {{ $this->metric }}
                            </span>
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($this->results as $row)
                    <tr>
                        @if ($this->groupByA)
                            <td>{{ $row['column_1'] ?? '' }}</td>
                        @endif
                        @if ($this->groupByB)
                            <td>{{ $row['column_2'] ?? '' }}</td>
                        @endif
                        @if ($this->metric)
                            <td>{{ $row['metric'] ?? '' }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
