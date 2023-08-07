<a href="{{ $link ?? '#' }}" class="group flex gap-x-3 dark:hover:bg-transparent dark:hover:text-orange
{{ !empty($active) && $active ? 'bg-gray-50 dark:bg-transparent text-orange' : 'text-black dark:text-white' }}
rounded-md p-2 text-sm leading-6 font-semibold hover:text-orange hover:bg-gray-50 items-center">
    {{ $slot }}
</a>
