<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;

new class extends Component {
    public bool $expanded = false;
    public string $placeholder = '';
    public bool $multiple = false;
    public string $icon = '';
    public string $search = '';

    #[Modelable]
    public mixed $value = null;

    // selected keys
    public array $selected = [];

    // key value pairs
    public array $options = [];

    public function mount(): void
    {
        $this->selected = match (true) {
            is_array($this->value) => $this->value,
            blank($this->value) => [],
            default => [$this->value],
        };
    }

    #[Computed]
    public function filteredOptions(): array
    {
        if ($this->search === '') {
            return $this->options;
        }

        return collect($this->options)->filter(fn($label) => str_contains(strtolower($label), strtolower($this->search)))->all();
    }

    public function select(int $id): void
    {
        if (!$this->multiple) {
            $this->selected = [$id];
            $this->value = $id;

            return;
        }

        $this->selected = in_array($id, $this->selected) ? array_values(array_diff($this->selected, [$id])) : [...$this->selected, $id];
        $this->value = $this->selected;
    }
};
?>

<div
    class="field-thin relative flex w-full cursor-pointer items-center"
    wire:click="$toggle('expanded')"
>
    @if (empty($this->selected))
        <span class="text-gray-500">{{ $this->placeholder }}</span>
    @elseif (count($this->selected) === 1)
        <span class="text-black">{{ $this->options[$this->selected[0]] }}</span>
    @elseif (count($this->selected) > 1)
        <span class="text-black">{{ count($this->selected) }} selected</span>
    @endif
    @if ($icon)
        <x-dynamic-component
            class="absolute left-3 top-[50%] w-5 translate-y-[-50%] text-darkgray"
            :component="'icon.' . $icon"
        />
    @endif

    <div
        class="absolute left-0 top-full mt-1 w-full overflow-hidden rounded border-none bg-white shadow ring-1 ring-gray"
        wire:cloak
        wire:show='expanded'
        wire:click.outside="$set('expanded', false)"
    >
        <div class="relative w-full border-b border-gray bg-transparent pl-8">
            <input
                class="w-full border-none bg-transparent outline-none focus:ring-0"
                type="text"
                wire:model.live.debounce.250ms="search"
                wire:click.stop
            >
            <x-icon.search class="absolute left-4 top-1/2 size-5 -translate-y-1/2 text-gray" />
        </div>
        <div class="max-h-56 overflow-y-scroll p-1">
            @foreach ($this->filteredOptions as $key => $value)
                <div
                    class="relative w-full rounded px-8 py-1 text-slate-700 hover:bg-slate-200"
                    wire:click="select('{{ $key }}')"
                >
                    <span>{{ $value }}</span>
                    @if (!empty($this->selected) && in_array($key, $this->selected))
                        <x-icon.checked class="absolute left-3 top-1/2 size-3 -translate-y-1/2" />
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
