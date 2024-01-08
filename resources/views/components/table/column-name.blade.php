<th>
    <span class="flex items-center gap-2">
        {{ $column }}
            <form action="{{ route($route . '.index') }}" method="GET">
                <input type="hidden" name="filter" value="{{ request()->query('filter') ?? '' }}">
                <input type="hidden" name="order_by" value="{{ $field }}">
                <input type="hidden" name="page" value="{{ request()->query('page') ?? 1 }}">
                <input type="hidden" name="order_direction"
                       value="{{ !empty(request()->query('order_by')) &&
                       request()->query('order_by') == $field &&
                       request()->query('order_direction') == 'asc'
                       ? 'desc'
                       : 'asc'
                       }}">
                <button type="submit">
                    <x-icon.up-arrow
                        class="cursor-pointer h-[10px]
                        {{
                           !empty(request()->query('order_by')) &&
                            request()->query('order_by') == $field &&
                            request()->query('order_direction') == 'asc'
                            ? 'rotate-180'
                            : ''
                        }}
                    "/>
                </button>
        </form>
    </span>
</th>
