<x-dashboard>

    {{-- see if there's any modal errors and show the modal if the case --}}
    @php
        $modalErrors = ['name', 'email', 'role_id'];

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
    <x-modals.resource :route="route('user.store')" :show="$hasModalErrors" :title="'Creating user'" :button="'Create'"
    id="add-resource-modal">
        <div class="flex w-full flex-col gap-3">
            @include('models.user.form', ['user' => null, 'roles' => $roles])
        </div>
    </x-modals.resource>

    {{-- title and search --}}
    <div class="flex justify-between mb-3">
        <h1>{{ __('Users') }}</h1>
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
            <caption class="hidden">{{ __('User index table') }}</caption>
            <thead>
                <tr>
                    @foreach (config('models.user.columns') as $field => $column)
                        <x-table.column-name :field="$field" :column="$column" :route="'user'" />
                    @endforeach
                    <th class="flex justify-end">
                        <span class="flex items-center gap-3 cursor-pointer hover:text-orange" id="add-resource">
                            <x-icon.plus class="w-4 h-4" />
                            {{ __('Add user') }}
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        @foreach (config('models.user.columns') as $field => $column)
                            @if (str_contains($field, '->'))
                                <td>{{ App\Http\Services\ModelService::nestedValue($user, $field) }}</td>
                            @else
                                <td>{{ $user->$field }}</td>
                            @endif
                        @endforeach
                        <td class="flex justify-end gap-2">
                            <x-icon.edit class="text-blue w-4 cursor-pointer hover:text-orange edit-icon"
                                id="edit-{{ $user->id }}"/>
                            <x-icon.delete class="text-blue w-6 cursor-pointer hover:text-orange delete-icon"
                                id="delete-{{ $user->id }}" />
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach ($users as $user)
        {{-- delete modals --}}
        <x-modals.delete id="delete-modal-{{ $user->id }}" :resource="$user" :route="'user'"
            :message="'Are you sure you wish to delete the account for user ' . $user->name . '? All meetings
            associated with this account will be removed as well.'" />

        {{-- edit modals --}}
        <x-modals.resource :route="route('user.update', $user->id)" :show="$hasModalErrors" :title="'Editing user'"
        :button="'Update'" id="edit-resource-modal-{{ $user->id }}">
            <div class="flex w-full flex-col gap-3">
                @include('models.user.form', ['user' => $user, 'roles' => $roles])
            </div>
        </x-modals.resource>
    @endforeach

    {{-- pagination --}}
    {{ $users->appends([
        'search' => request()->query('search') ?? '',
        'order_by' => request()->query('order_by') ?? 'name',
        'order_direction' => request()->query('order_direction') ?? 'asc',
    ])->links() }}

</x-dashboard>
