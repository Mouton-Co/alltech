<x-dashboard>

    {{-- title --}}
    <div class="flex items-center justify-between py-2">
        <h1>{{ __('Calendar export') }}</h1>
    </div>

    {{-- filters --}}
    <hr class="mb-2">
    <form
        action="{{ route('calendar.export') }}"
        method="get"
        class="flex gap-8 flex-col lg:flex-row lg:justify-between lg:items-end"
        target="_blank"
    >
        <div class="flex flex-col gap-2 lg:flex-row lg:gap-3">
            {{-- user --}}
            <div>
                <label
                    class="mb-1"
                    for="user"
                >{{ __('User') }}</label>
                <x-form.select
                    class="selector-for-js filter-field"
                    style="width:100%;"
                    :name="'user'"
                    :options="$users"
                    :value="'id'"
                    :display="'name'"
                    :selected="request()->get('user') ?? ''"
                />
            </div>
    
            {{-- year --}}
            <div>
                <label
                    class="mb-1"
                    for="year"
                >{{ __('Year') }}</label>
                <x-form.input
                    class="filter-field"
                    name="year"
                    type="number"
                    value="{{ request()->year ?? date('Y') }}"
                    min="2000"
                    max="{{ date('Y') + 3 }}"
                >
                    <x-icon.date-picker class="text-darkgray absolute left-3 top-1/2 w-5 -translate-y-1/2" />
                </x-form.input>
            </div>
    
            {{-- month --}}
            <div>
                <label
                    class="mb-1"
                    for="month"
                >{{ __('Month') }}</label>
                <select
                    class="selector-for-js filter-field"
                    name="month"
                    style="width:100%;"
                >
                    @foreach ($months as $value => $month)
                        <option
                            value="{{ $value }}"
                            @if (request()->get('month') == $month) selected @endif
                        >
                            {{ $month }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex justify-end">
            <button
                class="btn-orange min-w-[120px]"
                type="submit"
            >
                {{ __('Export') }}
            </button>
        </div>
    </form>

</x-dashboard>
