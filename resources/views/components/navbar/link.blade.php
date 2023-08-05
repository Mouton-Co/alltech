<a href="{{ $link ?? '#' }}" class="{{ !empty($active) && $active ? 'bg-gray-50 text-orange' : 'text-black' }}
group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold hover:text-orange hover:bg-gray-50 items-center">
    {{ $slot }}
</a>
