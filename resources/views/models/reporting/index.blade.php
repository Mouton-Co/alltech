<x-dashboard>

    {{-- title and search --}}
    <div class="flex justify-between mb-3">
        <h1>{{ __('Report Filters') }}</h1>
        <form action="" class="relative">
            <input type="text" name="search" placeholder="Search..." value="{{ request()->query('search') ?? '' }}"
                   class="w-64 smaller-than-740:w-full h-7 pb-[9.5px] border-gray bg-lightgray shadow
                focus:ring-orange focus:border-orange">
            <input type="hidden" name="order_by" value="{{ request()->query('order_by') ?? 'name' }}">
            <input type="hidden" name="order_direction" value="{{ request()->query('order_direction') ?? 'asc' }}">
            <input type="hidden" name="page" value="{{ request()->query('page') ?? 1 }}">
            <button type="submit" class="absolute right-[2px] top-[2px]">
                <x-icon.search/>
            </button>
        </form>
    </div>

    {{-- index table --}}
    <div class="overflow-scroll no-scrollbar">
        <table class="index-table">
            <caption class="hidden">{{ __('Report Filter index table') }}</caption>
            <thead>
            <tr>
                @foreach (config('models.report.columns') as $field => $column)
                    <x-table.column-name :field="$field" :column="$column" :route="'user'"/>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @if($reports->isEmpty())
                <tr>
                    <td colspan="8" class="text-center">{{ __('No reports found') }}</td>
                </tr>
            @else
                @foreach ($reports as $report)
                    <tr>
                        @foreach (config('models.user.columns') as $field => $column)
                            @if (str_contains($field, 'filter_used'))
                                <td><p>{{ $report->formatted_filter_used }}</p></td>
                            @else
                                <td>{{ $report->$field }}</td>
                            @endif
                        @endforeach
                        <td class="flex justify-end gap-2">
                            <x-icon.edit class="text-blue w-4 cursor-pointer hover:text-orange edit-icon"
                                         id="edit-{{ $report->id }}"/>
                            <x-icon.delete class="text-blue w-6 cursor-pointer hover:text-orange delete-icon"
                                           id="delete-{{ $report->id }}"/>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

    @foreach ($reports as $report)
        {{-- delete modals --}}
        <x-modals.delete id="delete-modal-{{ $report->id }}" :resource="$user" :route="'user'"
                         :message="'Are you sure you wish to delete the account for user ' . $user->name . '? All meetings
            associated with this account will be removed as well.'"/>
    @endforeach

    {{-- pagination --}}
    {{ $reports->appends([
        'search' => request()->query('search') ?? '',
        'order_by' => request()->query('order_by') ?? 'name',
        'order_direction' => request()->query('order_direction') ?? 'asc',
    ])->links() }}

</x-dashboard>
