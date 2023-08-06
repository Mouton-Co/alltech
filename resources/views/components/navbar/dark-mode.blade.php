<button type="button" class="{{ $active ? 'bg-orange' : 'bg-gray-200' }} relative inline-flex
h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors
duration-200 ease-in-out dark-toggle" aria-checked="{{ $active ? 'true' : 'false' }}">
    <span class="{{ $active ? 'translate-x-5' : 'translate-x-0' }} pointer-events-none
    inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition
    duration-200 ease-in-out"></span>
</button>
