<div class="relative max-w-sm">
    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
        <x-icon.date-picker class="h-4" />
    </div>
    <input id="datepicker" type="text" class="js-date-picker bg-transparent border border-gray-300 text-gray-900 text-sm
    rounded-lg focus:ring-orange focus:border-orange block w-full pl-10 p-2.5
    dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
    dark:focus:ring-orange dark:focus:border-orange" placeholder="Select date"
    value="{{
        !empty($date) ? Carbon\Carbon::createFromFormat('Y-m-d', $date)->format('Y-m-d'):
        ""
    }}"
    name="{{ $name}}"
    >
</div>
