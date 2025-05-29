<x-dashboard>

    <x-modals.resource :route="route('reporting.store')" :title="'Save Filter'" :button="'Save As'"
    :show="false" id="add-resource-modal">
        <div class="flex w-full flex-col gap-3">
            @include('models.reporting.form')
        </div>
    </x-modals.resource>

    <x-modals.resource :route="route('email-cron.store')" :title="'Create Email'" :button="'Create'"
    :show="false" id="add-email-modal">
        @include('models.email-cron.form')
    </x-modals.resource>

    {{-- curtain --}}
    <x-modals.curtain :show="false"/>

    {{-- title --}}
    <div class="flex justify-between items-center py-2">
        <h1>{{ __('Meeting reports') }}</h1>
        <div class="flex gap-3 items-center justify-between">
            {{-- hide for now --}}
            {{-- <a href="{{ route('email-cron.index') }}" class="btn-transparent flex justify-center items-center
            px-2">
                {{ __('Saved Emails') }}
            </a> --}}
            <a href="{{ route('reporting.index') }}" class="btn-transparent flex justify-center items-center px-2">
                {{ __('Saved Filters') }}
            </a>
        </div>
    </div>

    {{-- filter bar --}}
    <hr>

    <form action="{{ route('reporting.report') }}" method="get" id="report-filter-form">
        <div class="grid grid-cols-2 smaller-than-740:grid-cols-1 gap-3 my-2">
            {{-- report id --}}
            @if(!empty($report->id))
                <input type="hidden" name="report_id" value="{{ $report->id }}">
            @endif

            {{-- users --}}
            <div class="flex gap-3">
                <label class="min-w-[120px]">{{ __('Users') }}</label>
                <x-form.select
                    :name="'users[]'"
                    :options="$users"
                    :value="'id'"
                    :display="'name'"
                    :selected="json_encode(request()->users) ?? ''"
                    class="selector-for-js filter-field" style="width:100%;"
                    multiple
                />
            </div>

            {{-- company types --}}
            <div class="flex gap-3">
                <label class="min-w-[120px]">{{ __('Company Types') }}</label>
                <x-form.select :name="'company_types[]'" class="selector-for-js filter-field" style="width:100%;"
                :options="$companyTypes" :value="'id'" :display="'name'" multiple
                :selected="json_encode(request()->query('company_types')) ?? ''" />
            </div>

            {{-- companies --}}
            <div class="flex gap-3">
                <label class="min-w-[120px]">{{ __('Companies') }}</label>
                <x-form.select :name="'companies[]'" class="selector-for-js filter-field" style="width:100%;"
                :options="$companies" multiple :value="'id'" :display="'name'"
                :selected="json_encode(request()->query('companies')) ?? ''" />
            </div>

            {{-- contacts --}}
            <div class="flex gap-3">
                <label class="min-w-[120px]">{{ __('Contacts') }}</label>
                <x-form.select :name="'contacts[]'" class="selector-for-js filter-field" style="width:100%;"
                :options="$contacts" multiple :value="'id'" :display="'name'"
                :selected="json_encode(request()->query('contacts')) ?? ''" />
            </div>

            {{-- date --}}
            <div class="flex gap-3">
                <label for="date" class="min-w-[120px]">{{ __('Date') }}</label>
                <x-form.date-range-picker :name="'date_range'" :value="request()->query('date_range') ?? ''"
                class="w-full"/>
            </div>

            {{-- search --}}
            <div class="flex gap-3">
                <label for="search" class="min-w-[120px]">{{ __('Search') }}</label>
                <input type="text" name="search" placeholder="Search..." value="{{ request()->query('search') ?? '' }}"
                       class="filter-field">
            </div>

            {{-- cancelled --}}
            <div class="flex gap-2 min-w-fit h-full items-center pr-5 justify-end">
                <label for="cancelled" class="min-w-[120px]">{{ __('Show cancelled meetings?') }}</label>
                <input type="checkbox" name="cancelled" @if (request()->query('cancelled') == 'on') checked @endif>
            </div>
        </div>
    </form>

    <div class="grid grid-cols-2 smaller-than-740:grid-cols-1 gap-3 my-2">
        <div class="flex justify-end gap-3">
            @if(empty($report))
                <button id="add-resource" class="btn-transparent min-w-[160px] flex justify-center
                items-center"
                        onclick="event.preventDefault();"
                        @if(!$hasQuery)
                            disabled
                    @endif
                >
                    {{ __('Save Filter') }}
                </button>
            @else
                <button id="update-resource" class="btn-transparent min-w-[160px] flex justify-center
                items-center"
                        onclick="event.preventDefault();"
                        @if(!$hasQuery)
                            disabled
                    @endif
                >
                    {{ __('Update Filter') }}
                </button>
            @endif
            {{-- hide for now --}}
            {{-- <button id="create-email" class="btn-transparent min-w-[160px] flex justify-center
            items-center" @if (!$hasQuery) disabled @endif>
                {{ __('Create Email') }}
            </button> --}}
            <form action="{{ route('reporting.export', [
                'users'         => request()->query('users') ?? '',
                'company_types' => request()->query('company_types') ?? '',
                'companies'     => request()->query('companies') ?? '',
                'contacts'      => request()->query('contacts') ?? '',
                'date_range'    => request()->query('date_range') ?? '',
                'search'        => request()->query('search') ?? '',
                'cancelled'     => request()->query('cancelled') ?? '',
            ]) }}" method="post">
                @csrf
                <input type="submit" value="Export" class="btn-transparent min-w-[160px] flex justify-center
                items-center cursor-pointer" @if (!$hasQuery) disabled @endif>
            </form>
        </div>
    
        <div class="flex justify-end gap-3">
            <input type="hidden" name="page" value="{{ request()->query('page') ?? 1 }}">
            <button type="submit" class="btn-orange min-w-[120px]" id="report-filter-submit">
                {{ __('Filter') }}
            </button>
            <a href="{{ route('reporting.report') }}" class="btn-transparent min-w-[120px] flex justify-center
                items-center">
                {{ __('Clear Filters') }}
            </a>
        </div>
    </div>

    <hr class="mb-3">

    {{-- list of reports --}}
    <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @if(count($meetings) > 0)
            @foreach ($meetings as $meeting)

                {{-- report card --}}
                <div id="report-card-{{ $meeting->id }}" class="report-card
                {{ !empty($meeting->cancelled_at) ? 'report-card-cancelled' : '' }}">
                    <div class="report-card-header">
                        <span>{{ __('Meeting title: ') . $meeting->title }}</span>
                    </div>
                    <div class="report-card-body">
                        <div class="report-card-body-item">
                            <x-icon.contact class="w-5 h-5"/>
                            <span>
                                {{ strlen($meeting->contact->name) > 20 ?
                                substr($meeting->contact->name,0,20)."..." :
                                $meeting->contact->name }}
                            </span>
                        </div>
                        <div class="report-card-body-item">
                            <x-icon.company class="w-5 h-5"/>
                            <span>
                                {{ strlen($meeting->contact->company->name) > 20 ?
                                substr($meeting->contact->company->name,0,20)."..." :
                                $meeting->contact->company->name }}
                            </span>
                        </div>
                        <div class="report-card-body-item">
                            <x-icon.date-picker class="w-5 h-5"/>
                            <span>
                                @if ($meeting->all_day ?? false)
                                    {{ $meeting->date . ' to ' . $meeting->end_date }}
                                @else
                                    {{ $meeting->date }}
                                @endif
                            </span>
                        </div>
                        <div class="report-card-body-item">
                            <x-icon.time-picker class="w-5 h-5"/>
                            <span>
                                @if ($meeting->all_day ?? false)
                                    {{ __("All day") }}
                                @else
                                    {{ $meeting->start_time . ' - ' . $meeting->end_time }}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="report-card-footer">
                        <x-icon.users class="w-5"/>
                        <span>{{ $meeting->user->name }}</span>
                    </div>
                </div>

                {{-- report modal --}}
                <div id="report-modal-{{ $meeting->id }}" class="hidden report-modal">
                    <div class="report-card">
                        <div class="report-card-header">
                            <span>{{ __('Meeting title: ') . $meeting->title }}</span>
                        </div>
                        <div class="report-card-body">
                            <div class="report-card-body-item">
                                <x-icon.contact class="w-5 h-5"/>
                                <span>
                                    {{ strlen($meeting->contact->name) > 20 ?
                                    substr($meeting->contact->name,0,20)."..." :
                                    $meeting->contact->name }}
                                </span>
                            </div>
                            <div class="report-card-body-item">
                                <x-icon.company class="w-5 h-5"/>
                                <span>
                                    {{ strlen($meeting->contact->company->name) > 20 ?
                                    substr($meeting->contact->company->name,0,20)."..." :
                                    $meeting->contact->company->name }}
                                </span>
                            </div>
                            <div class="report-card-body-item">
                                <x-icon.date-picker class="w-5 h-5"/>
                                <span>
                                    @if ($meeting->all_day ?? false)
                                        {{ $meeting->date . ' to ' . $meeting->end_date }}
                                    @else
                                        {{ $meeting->date }}
                                    @endif
                                </span>
                            </div>
                            <div class="report-card-body-item">
                                <x-icon.time-picker class="w-5 h-5"/>
                                <span>
                                    @if ($meeting->all_day ?? false)
                                        {{ __("All day") }}
                                    @else
                                        {{ $meeting->start_time . ' - ' . $meeting->end_time }}
                                    @endif
                                </span>
                            </div>
                            <div class="report-card-body-item">
                                <x-icon.location class="w-5 h-5"/>
                                <span>
                                    @if (!empty($meeting->location))
                                        {{ strlen($meeting->location) > 20 ?
                                        substr($meeting->location,0,20)."..." :
                                        $meeting->location }}
                                    @else
                                        {{ __("N/A") }}
                                    @endif
                                </span>
                            </div>
                            <div class="report-card-body-item text-wrap !block">
                                <p class="my-2"><b>{{ __('Report') }}</b></p>
                                <p>{{ $meeting->report }}</p>
                            </div>
                        </div>
                        <div class="report-card-footer">
                            <x-icon.users class="w-5"/>
                            <span>{{ $meeting->user->name }}</span>
                        </div>
                    </div>
                </div>

            @endforeach
        @else
            <p>No results found</p>
        @endif
    </ul>
    <br/>

    {{-- pagination --}}
    {{ $meetings->appends([
        'search' => request()->query('search') ?? '',
        'status' => request()->query('order_by') ?? '0',
        'supplier' => request()->query('order_direction') ?? '0',
        'date_range' => request()->query('date_range') ?? '',
        'users' => request()->query('users') ?? '',
        'company_types' => request()->query('company_types') ?? '',
        'companies' => request()->query('companies') ?? '',
        'contacts' => request()->query('contacts') ?? '',
        'cancelled' => request()->query('cancelled') ?? '',
    ])->links() }}

</x-dashboard>
