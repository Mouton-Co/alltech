<x-dashboard>

    {{-- see if there's any modal errors and show the modal if the case --}}
    @php
        $modalErrors = ['name', 'company_type_id'];

        $hasModalErrors = false;
        foreach ($modalErrors as $modalError) {
            if (!empty($errors->get($modalError))) {
                $hasModalErrors = true;
                break;
            }
        }
    @endphp

    {{-- curtain --}}
    <x-modals.curtain :show="$hasModalErrors" />

    {{-- add modal --}}
    <x-modals.resource :route="route('company.store')" :show="$hasModalErrors" :title="'Creating company'"
    :button="'Create'" id="add-resource-modal">
        <div class="flex w-full flex-col gap-3">

            <x-form.input type="text" :name="'name'" value="{{ old('name') }}" placeholder="Name" class="w-full"
                required>
                <x-icon.company class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
            </x-form.input>

            <x-form.input type="text" :name="'location'" value="{{ old('location') }}" placeholder="Location"
            class="w-full">
                <x-icon.location class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
            </x-form.input>

            <x-form.input type="text" :name="'coordinates'" value="{{ old('coordinates') }}" placeholder="Coordinates"
            class="w-full">
                <x-icon.coordinates class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
            </x-form.input>

            <div>
                <x-form.label for="company_type_id">
                    {{ __('Company Type') }}
                </x-form.label>
                <x-form.select :name="'company_type_id'" class="w-full" :options="$companyTypes" :value="'id'"
                :display="'name'" :selected="old('company_type_id')">
                    <x-icon.company-type class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
                </x-form.select>
            </div>

        </div>
    </x-modals.resource>

    {{-- title and search --}}
    <div class="flex justify-between mb-3">
        <h1>{{ __('Companies') }}</h1>
        <form action="" class="relative">
            <input type="text" name="search" placeholder="Search..." value="{{ request()->query('search') ?? '' }}"
                class="w-64 smaller-than-740:w-full h-7 pb-[9.5px] border-gray bg-lightgray shadow
                focus:ring-orange focus:border-orange">
            <input type="hidden" name="order_by" value="{{ request()->query('order_by') ?? 'name' }}">
            <input type="hidden" name="order_direction" value="{{ request()->query('order_direction') ?? 'asc' }}">
            <input type="hidden" name="page" value="{{ request()->query('page') ?? 1 }}">
            <button type="submit" class="absolute right-[2px] top-[2px]">
                <x-icon.search />
            </button>
        </form>
    </div>

    {{-- index table --}}
    <div class="overflow-scroll no-scrollbar">
        <table class="index-table">
            <caption class="hidden">{{ __('Company index table') }}</caption>
            <thead>
                <tr>
                    @foreach (config('models.company.columns') as $field => $column)
                        <th>
                            <span class="flex items-center gap-2">
                                {{ $column }}
                                <form action="{{ route('company.index') }}" method="GET">
                                    <input type="hidden" name="search"
                                        value="{{ request()->query('search') ?? '' }}">
                                    <input type="hidden" name="order_by" value="{{ $field }}">
                                    <input type="hidden" name="page" value="{{ request()->query('page') ?? 1 }}">
                                    <input type="hidden" name="order_direction"
                                        value="{{ !empty(request()->query('order_by')) &&
                                        request()->query('order_by') == $field &&
                                        request()->query('order_direction') == 'asc'
                                            ? 'desc'
                                            : 'asc' }}">
                                    <button type="submit">
                                        <x-icon.up-arrow
                                            class="cursor-pointer h-[10px]
                                            {{ !empty(request()->query('order_by')) &&
                                            request()->query('order_by') == $field &&
                                            request()->query('order_direction') == 'asc'
                                                ? 'rotate-180'
                                                : '' }}" />
                                    </button>
                                </form>
                            </span>
                        </th>
                    @endforeach
                    <th class="flex justify-end">
                        <span class="flex items-center gap-3 cursor-pointer hover:text-orange" id="add-resource">
                            <x-icon.plus class="w-4 h-4" />
                            {{ __('Add company') }}
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companies as $company)
                    <tr>
                        @foreach (config('models.company.columns') as $field => $column)
                            @if (str_contains($field, '->'))
                                <td>{{ App\Http\Services\ModelService::nestedValue($company, $field) }}</td>
                            @else
                                <td>{{ $company->$field }}</td>
                            @endif
                        @endforeach
                        <td class="flex justify-end gap-2">
                            <x-icon.edit class="text-blue w-4 cursor-pointer hover:text-orange edit-icon"
                                id="edit-{{ $company->id }}"/>
                            <x-icon.delete class="text-blue w-6 cursor-pointer hover:text-orange delete-icon"
                                id="delete-{{ $company->id }}" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($companies as $company)
        {{-- delete modals --}}
        <x-modals.delete id="delete-modal-{{ $company->id }}" :resource="$company" :route="'company'"
            :message="'Are you sure you wish to delete the company ' . $company->name . '? All meetings
            and contacts associated with this company will be removed as well.'" />

        {{-- edit modals --}}
        <x-modals.resource :route="route('company.update', $company->id)" :show="$hasModalErrors"
            :title="'Editing company'" :button="'Update'" id="edit-resource-modal-{{ $company->id }}">
            <div class="flex w-full flex-col gap-3">

                <x-form.input type="text" :name="'name'" value="{{ old('name') ?? $company->name  }}" placeholder="Name"
                    class="w-full" required>
                    <x-icon.company class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
                </x-form.input>

                <x-form.input type="text" :name="'location'" value="{{ old('location') ?? $company->location ?? '' }}"
                    placeholder="Location" class="w-full">
                    <x-icon.location class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
                </x-form.input>

                <x-form.input type="text" :name="'coordinates'" placeholder="Coordinates" class="w-full"
                value="{{ old('coordinates') ?? $company->coordinates ?? '' }}">
                    <x-icon.coordinates class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
                </x-form.input>

                <div>
                    <x-form.label for="company_type_id">
                        {{ __('Company Type') }}
                    </x-form.label>
                    <x-form.select :name="'company_type_id'" class="w-full" :options="$companyTypes" :value="'id'"
                    :display="'name'" :selected=" old('company_type_id') ?? $company->company_type_id">
                        <x-icon.company-type class="absolute w-5 top-[50%] translate-y-[-50%] left-3 text-darkgray" />
                    </x-form.select>
                </div>

            </div>
        </x-modals.resource>
    @endforeach

    {{-- pagination --}}
    {{ $companies->appends([
        'search' => request()->query('search') ?? '',
        'order_by' => request()->query('order_by') ?? 'name',
        'order_direction' => request()->query('order_direction') ?? 'asc',
    ])->links() }}

</x-dashboard>
