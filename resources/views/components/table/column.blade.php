<th>
    <div class="flex items-center gap-2">
        <span>{{ $label }}</span>
        <x-icon.up-arrow
            @class([
                'h-3 cursor-pointer hover:opacity-80 rotate-90',
                '!rotate-0' => $this->sort === $column && $this->direction === 'desc',
                '!rotate-180' => $this->sort === $column && $this->direction === 'asc',
            ])
            wire:click="sortBy('{{ $column }}')"
        />
    </div>
</th>
