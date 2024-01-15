<x-dashboard>

    {{-- see if there's any modal errors and show the modal if the case --}}
    @php
        $hasStoreErrors  = false;
        $hasUpdateErrors = false;

        foreach ($errors->getBags() as $bagKey => $bag) {
            if ($bagKey === 'userStore') {
                $hasStoreErrors = true;
                $errors->default = $errors->$bagKey;
                break;
            }
            if (str_contains($bagKey, 'userUpdate')) {
                $hasUpdateErrors = true;
                $updateErrorId = explode('--', $bagKey)[1];
                $errors->default = $errors->$bagKey;
                break;
            }
        }
    @endphp
    <x-modals.resource :route="route('reporting.store')" :title="'Save Report Filter'" :button="'Save'"
                       :show="$hasStoreErrors" id="add-resource-modal">
        <div class="flex w-full flex-col gap-3">
            <input type="hidden" name="filter_used" value="{{ json_encode(request()->query()) }}">
            {{-- filter name --}}
            <div class="flex gap-3">
                <label for="filter_name" class="min-w-fit">{{ __('Filter Name') }}</label>
                <input type="text" name="filter_name" placeholder="Filter Name" value="" class="filter-field">
            </div>

            {{-- recipient --}}
            <div class="flex gap-3">
                <label for="recipient" class="min-w-fit">{{ __('Recipient') }}</label>
                <input type="text" name="recipient" placeholder="example@alltech.com" value="" class="filter-field">
            </div>

            {{-- send at --}}
            <div class="flex gap-3">
                <label for="send_at" class="min-w-fit">{{ __('Send At') }}</label>
                <x-form.date-picker :name="'send_at'" :value="request()->query('send_at') ?? ''"
                                    class="filter-field"/>
            </div>

            {{-- repeat --}}
            <div class="flex gap-3">
                <label for="repeat" class="min-w-fit">{{ __('Repeat') }}</label>
                <input type="checkbox" name="repeat" placeholder="Repeat" class="filter-field">
            </div>

            {{-- repeat frequency --}}
            <div class="flex gap-3">
                <label for="repeat_frequency" class="min-w-fit">{{ __('Repeat Frequency') }}</label>
                <select name="repeat_frequency" class="filter-field selector-for-js">
                    @foreach(\App\Models\Report::REPEAT_FREQUENCY as $key => $value)
                        <option
                            value="{{ $key }}"
                            @if($key == old('repeat_frequency'))
                                selected
                            @endif
                        >
                            {{ $value }}
                        </option>
                    @endforeach
                </select>

            </div>
        </div>
    </x-modals.resource>

    {{-- curtain --}}
    <x-modals.curtain :show="$hasStoreErrors | $hasUpdateErrors"/>

    {{-- title --}}
    <div class="flex ">
        <h1 class="mb-3 grow">{{ __('Meeting reports') }}</h1>
        <a href="{{route('reporting.index')}}" class="btn-transparent">Saved Reports</a>
    </div>
    {{-- filter bar --}}
    <hr>

    <form action="{{ route('reporting.report') }}" method="get">
        <div class="grid grid-cols-2 smaller-than-740:grid-cols-1 gap-3 my-2">
            {{-- users --}}
            <div class="flex gap-3">
                <label class="min-w-fit">{{ __('Users') }}</label>
                <x-form.select
                    :name="'users[]'"
                    :options="$users"
                    :value="'id'"
                    :display="'name'"
                    :selected="json_encode(request()->users) ?? ''"
                    class="filter-field"
                    multiple
                />
            </div>

            {{-- company types --}}
            <div class="flex gap-3">
                <label class="min-w-fit">{{ __('Company Types') }}</label>
                <x-form.select :name="'company_types[]'" class="filter-field" :options="$companyTypes" :value="'id'"
                               :display="'name'" :selected="json_encode(request()->query('company_types')) ?? ''"
                               multiple/>
            </div>

            {{-- companies --}}
            <div class="flex gap-3">
                <label class="min-w-fit">{{ __('Companies') }}</label>
                <x-form.select :name="'companies[]'" class="filter-field" :options="$companies" :value="'id'"
                               :display="'name'" :selected="json_encode(request()->query('companies')) ?? ''" multiple/>
            </div>

            {{-- contacts --}}
            <div class="flex gap-3">
                <label class="min-w-fit">{{ __('Contacts') }}</label>
                <x-form.select :name="'contacts[]'" class="filter-field" :options="$contacts" :value="'id'"
                               :display="'name'" :selected="json_encode(request()->query('contacts')) ?? ''" multiple/>
            </div>

            {{-- date --}}
            <div class="flex gap-3">
                <label for="date" class="min-w-fit">{{ __('Date') }}</label>
                <x-form.date-range-picker :name="'date_range'" :value="request()->query('date') ?? ''"
                                          class="filter-field"/>
            </div>

            {{-- search --}}
            <div class="flex gap-3">
                <label for="search" class="min-w-fit">{{ __('Search') }}</label>
                <input type="text" name="search" placeholder="Search..." value="{{ request()->query('search') ?? '' }}"
                       class="filter-field">
            </div>

            <div class="flex gap-3">
                <button id="add-resource" class="btn-transparent min-w-[160px] flex justify-center
                    items-center"
                        onclick="event.preventDefault();"
                        @if(!$hasQuery)
                            disabled
                    @endif
                >
                    {{ __('Save Filter') }}
                </button>
                <button class="btn-transparent min-w-[160px] flex justify-center"
                        onclick="event.preventDefault();"
                        @if(!$hasQuery)
                            disabled
                    @endif
                >
                    {{ __('Download Filter') }}
                </button>
            </div>

            <div class="flex gap-3">
                <input type="hidden" name="page" value="{{ request()->query('page') ?? 1 }}">
                <button type="submit" class="btn-orange min-w-[120px]">
                    {{ __('Filter') }}
                </button>
                <a href="{{ route('reporting.report') }}" class="btn-transparent min-w-[120px] flex justify-center
                    items-center">
                    {{ __('Clear Filters') }}
                </a>
            </div>
        </div>
    </form>

    <hr class="mb-3">

    {{-- list of reports --}}
    <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
        @if(count($meetings) > 0)
            @foreach ($meetings as $meeting)

                {{-- report card --}}
                <div id="report-card-{{ $meeting->id }}" class="report-card">
                    <div class="report-card-header">
                        <span>{{ __('Meeting with: ') . $meeting->contact->name }}</span>
                    </div>
                    <div class="report-card-body">
                        <div class="report-card-body-item">
                            <x-icon.company class="w-5"/>
                            <span>{{ strlen($meeting->contact->company->name) > 20 ? substr($meeting->contact->company->name,0,20)."..." : $meeting->contact->company->name }}</span>
                        </div>
                        <div class="report-card-body-item">
                            <x-icon.date-picker class="w-5"/>
                            <span>{{ $meeting->date }}</span>
                        </div>
                    </div>
                    <div class="report-card-footer">
                        <x-icon.users class="w-5"/>
                        <span>{{ $meeting->user->name }}</span>
                    </div>
                </div>

                {{-- report modal --}}
                <div id="report-modal-{{ $meeting->id }}" class="hidden">
                    <div class="report-card">
                        <div class="report-card-header">
                            <span>{{ __('Meeting with: ') . $meeting->contact->name }}</span>
                        </div>
                        <div class="report-card-body">
                            <div class="report-card-body-item">
                                <x-icon.company class="w-5"/>
                                <span>{{ strlen($meeting->contact->company->name) > 20 ? substr($meeting->contact->company->name,0,20)."..." : $meeting->contact->company->name }}</span>
                            </div>
                            <div class="report-card-body-item">
                                <x-icon.date-picker class="w-5"/>
                                <span>{{ $meeting->date }}</span>
                            </div>
                            <div class="report-card-body-item">
                                <p>{{ __('Objective') . $meeting->objective }}</p>
                            </div>
                            <div class="report-card-body-item">
                                <p>{{ __('Marketing Requirements') . $meeting->marketing_requirements }}</p>
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
    ])->links() }}

</x-dashboard>
