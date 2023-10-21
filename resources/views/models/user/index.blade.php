<x-dashboard>

    <div class="flex justify-between mb-3">
        <h1>{{ __('Users') }}</h1>
        <form action="" class="relative">
            <input type="text" name="search" placeholder="Search..." value="{{ request()->query('search') ?? '' }}"
                class="w-64 smaller-than-740:w-full h-7 pb-[9.5px] border-gray bg-lightgray
                focus:ring-orange focus:border-orange">
            <input type="hidden" name="order_by" value="{{ request()->query('order_by') ?? 'name' }}">
            <input type="hidden" name="order_direction" value="{{ request()->query('order_direction') ?? 'asc' }}">
            <input type="hidden" name="page" value="{{ request()->query('page') ?? 1 }}">
            <button type="submit" class="absolute right-[2px] top-[2px]">
                <x-icon.search />
            </button>
        </form>
    </div>
    
    <div class="overflow-scroll no-scrollbar">
        <table class="index-table">
            <caption class="hidden">{{ __('User index table') }}</caption>
            <thead>
                <tr>
                    @foreach (config('models.user.columns') as $field => $column)
                        <th>
                            <span class="flex items-center gap-2">
                                {{ $column }}
                                <form action="{{ route('user.index') }}" method="GET">
                                    <input type="hidden" name="search" value="{{ request()->query('search') ?? '' }}">
                                    <input type="hidden" name="order_by" value="{{ $field }}">
                                    <input type="hidden" name="page" value="{{ request()->query('page') ?? 1 }}">
                                    <input type="hidden" name="order_direction"
                                        value="{{ !empty(request()->query('order_by')) &&
                                            request()->query('order_by') == $field &&
                                            request()->query('order_direction') == 'asc' ? 'desc' : 'asc' }}">
                                    <button type="submit">
                                        <x-icon.up-arrow class="cursor-pointer h-[10px]
                                            {{ !empty(request()->query('order_by')) &&
                                                request()->query('order_by') == $field &&
                                                request()->query('order_direction') == 'asc' ? 'rotate-180' : '' }}"/>
                                    </button>
                                </form>
                            </span>
                        </th>
                    @endforeach
                    <th class="flex justify-end">
                        <span class="flex items-center gap-3 cursor-pointer hover:text-orange">
                            <x-icon.plus class="w-4 h-4"/>
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
                        <td class="flex justify-end"><x-icon.ellipse class="text-blue w-5 cursor-pointer" /></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $users->appends([
        'search'          => request()->query('search') ?? '',
        'order_by'        => request()->query('order_by') ?? 'name',
        'order_direction' => request()->query('order_direction') ?? 'asc',
    ])->links() }}

</x-dashboard>
