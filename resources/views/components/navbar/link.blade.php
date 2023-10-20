<a href="{{ $link ?? '#' }}"
    {{ $attributes->merge(['class' => 'flex items-center gap-3 hover:text-orange']) }}>
    {{ $slot }}
</a>
