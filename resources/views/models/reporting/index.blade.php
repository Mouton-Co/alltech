<x-dashboard>

    {{-- title --}}
    <h1 class="mb-3">{{ __('Meeting reports') }}</h1>

    {{-- curtain --}}
    <div id="modal-curtain" class="hidden"></div>

    {{-- filter bar --}}
    <hr>
    <form action="{{ route('reporting.index') }}" method="get">
        <div class="flex gap-3 my-2 items-center flex-wrap">

            {{-- multiple dropdown typeahead --}}
            @php
                $options = [
                    'option1' => 'Option 1',
                    'option2' => 'Option 2',
                    'option3' => 'Option 3',
                ];
            @endphp
            <label class="min-w-fit">{{ __('Dropdown') }}</label>
            <select name="options[]" multiple="multiple" class="selector-for-js filter-field"
            placeholder="Dropdown options...">
                @foreach ($options as $optionKey => $optionValue)
                    <option value="{{ $optionKey }}">
                        {{ $optionValue }}
                    </option>
                @endforeach
            </select>

            {{-- search --}}
            <label for="search" class="min-w-fit">{{ __('Search') }}</label>
            <input type="text" name="search" placeholder="Search..." value="{{ request()->query('search') ?? '' }}"
                class="filter-field">

            <input type="hidden" name="page" value="{{ request()->query('page') ?? 1 }}">
            <button type="submit" class="btn-orange min-w-[120px]">
                {{ __('Filter') }}
            </button>
            <a href="{{ route('reporting.index') }}" class="btn-transparent min-w-[120px] flex justify-center
            items-center">
                {{ __('Clear Filters') }}
            </a>

        </div>
    </form>
    <hr class="mb-3">

    {{-- list of reports --}}
    <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @for ($i=0; $i < 10; $i++)

            {{-- report card --}}
            <div id="report-card-{{ $i }}" class="report-card">
                <div class="report-card-header">
                    <span>{{ __('Some title') }}</span>
                </div>
                <div class="report-card-body">
                    <div class="report-card-body-item">
                        <x-icon.company class="w-5" />
                        <span>{{ __('Some value') }}</span>
                    </div>
                </div>
                <div class="report-card-footer">
                    <span>{{ __('Part summary') }}</span>
                </div>
            </div>

            {{-- report modal --}}
            <div id="report-modal-{{ $i }}" class="hidden">
                <div class="report-card">
                    <div class="report-card-header">
                        <span>{{ __('Some title') }}</span>
                    </div>
                    <div class="report-card-body">
                        <div class="report-card-body-item">
                            <x-icon.company class="w-5" />
                            <span>{{ __('Some value') }}</span>
                        </div>
                    </div>
                    <div class="report-card-footer">
                        <span>{{ __('Part summary') }}</span>
                    </div>
                </div>
            </div>

        @endfor
    </ul>

    {{-- pagination --}}
    {{-- {{ $orders->appends([
        'search' => request()->query('search') ?? '',
        'status' => request()->query('order_by') ?? '0',
        'supplier' => request()->query('order_direction') ?? '0',
    ])->links() }} --}}

</x-dashboard>
