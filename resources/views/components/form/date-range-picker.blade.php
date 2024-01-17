<div {{ $attributes->merge(['class' => 'relative']) }}>
    <div class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none">
        <x-icon.date-picker class="h-4" />
    </div>
    <input type="text" class="js-date-range-picker bg-transparent border border-gray-300 text-gray-900 text-sm
    rounded-lg focus:ring-orange focus:border-orange block w-full pl-10 p-2.5
    dark:border-gray-600 dark:placeholder-gray-400 dark:text-white
    dark:focus:ring-orange dark:focus:border-orange" placeholder="Select date"
    value="{{ $value }}"
    name="{{ $name}}"
    >
</div>
