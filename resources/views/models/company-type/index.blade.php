<x-dashboard>

    {{-- see if there's any modal errors and show the modal if the case --}}
    @php
        $modalErrors = ['name', 'minimum_required'];

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
    <x-modals.resource :route="route('company-type.store')" :show="$hasModalErrors" :title="'Creating company type'"
    :button="'Create'" id="add-resource-modal">
        <div class="flex w-full flex-col gap-3">
            @include('models.company-type.form', ['companyType' => null])
        </div>
    </x-modals.resource>

    {{-- title and search --}}
    <div class="flex justify-between mb-3">
        <h1>{{ __('Company types') }}</h1>
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
            <caption class="hidden">{{ __('Company types index table') }}</caption>
            <thead>
                <tr>
                    @foreach (config('models.company-type.columns') as $field => $column)
                        <th>
                            <span class="flex items-center gap-2">
                                {{ $column }}
                                <form action="{{ route('company-type.index') }}" method="GET">
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
                            {{ __('Add company type') }}
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($companyTypes as $companyType)
                    <tr>
                        @foreach (config('models.company-type.columns') as $field => $column)
                            @if (str_contains($field, '->'))
                                <td>{{ App\Http\Services\ModelService::nestedValue($companyType, $field) }}</td>
                            @else
                                <td>{{ $companyType->$field }}</td>
                            @endif
                        @endforeach
                        <td class="flex justify-end gap-2">
                            <x-icon.edit class="text-blue w-4 cursor-pointer hover:text-orange edit-icon"
                                id="edit-{{ $companyType->id }}"/>
                            <x-icon.delete class="text-blue w-6 cursor-pointer hover:text-orange delete-icon"
                                id="delete-{{ $companyType->id }}" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($companyTypes as $companyType)
        {{-- delete modals --}}
        <x-modals.delete id="delete-modal-{{ $companyType->id }}" :resource="$companyType" :route="'company-type'"
            :message="'Are you sure you wish to delete ' . $companyType->name . '? All companies, contacts and
            meetings associated with this company type will be removed as well.'" />

        {{-- edit modals --}}
        <x-modals.resource :route="route('company-type.update', $companyType->id)" :show="$hasModalErrors"
            :title="'Editing company type'" :button="'Update'" id="edit-resource-modal-{{ $companyType->id }}">
            <div class="flex w-full flex-col gap-3">
                @include('models.company-type.form', ['companyType' => $companyType])
            </div>
        </x-modals.resource>
    @endforeach

    {{-- pagination --}}
    {{ $companyTypes->appends([
        'search' => request()->query('search') ?? '',
        'order_by' => request()->query('order_by') ?? 'name',
        'order_direction' => request()->query('order_direction') ?? 'asc',
    ])->links() }}

</x-dashboard>
