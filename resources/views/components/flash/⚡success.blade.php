<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component {
    public ?string $message = '';
    public bool $show = false;

    #[On('flash.success.show')]
    public function show(string $message): void
    {
        $this->message = $message;
        $this->show = true;
    }
};
?>

<div
    class="fixed bottom-8 right-8 z-40 transition-all duration-300"
    wire:show='show'
    wire:cloak
>
    <div class="flex items-center gap-4 rounded bg-green-100 px-4 py-2 text-green-500 shadow">
        <x-icon.info class="size-5 flex-shrink-0" />
        <div class="text-sm font-medium">{{ $message }}</div>
        <x-icon.x
            class="size-4 cursor-pointer hover:text-slate-500"
            wire:click="$toggle('show')"
        />
    </div>
</div>
