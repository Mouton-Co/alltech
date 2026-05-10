<?php

use Livewire\Component;
use Livewire\Attributes\On;

new class extends Component {
    public $show = false;
    public $id = null;
    public $class = '';
    public $warning = '';
    public $message = '';
    public $callback = '';

    public function mount($message = 'Are you sure you want to delete this resource?', $warning = 'Are you sure?'): void
    {
        $this->warning = $warning;
        $this->message = $message;
    }

    #[On('modals.delete.show')]
    public function show($id, $class, $callback = ''): void
    {
        $this->id = $id;
        $this->class = $class;
        $this->callback = $callback;
        $this->show = true;
    }

    public function delete(): void
    {
        $this->class::findOrFail($this->id)->delete();
        $this->show = false;

        if ($this->callback) {
            $this->dispatch($this->callback);
        }

        $this->dispatch('flash.success.show', message: 'Resource has been deleted');
    }
};
?>

<div
    class="fixed inset-0 z-40 flex h-screen w-screen items-center justify-center bg-black/50"
    wire:show='show'
    wire:cloak
>
    <div
        class="flex-col gap-3 rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all"
        wire:click.outside="$toggle('show')"
    >
        <div class="flex items-center gap-2">
            <div
                class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                <x-icon.warning class="w-5 text-red-600" />
            </div>
            <h2 class="w-full">{{ $this->warning }}</h2>
        </div>
        <p class="w-full">
            {{ $this->message }}
        </p>
        <div class="mt-3 flex w-full gap-3">
            <form
                class="w-full"
                wire:submit='delete'
            >
                <button
                    class="btn-orange-thin h-[30px] w-full"
                    type="submit"
                >
                    {{ __('Delete') }}
                </button>
            </form>
            <button
                class="btn-transparent-thin modal-cancel w-full"
                wire:click="$toggle('show')"
            >
                {{ __('Cancel') }}
            </button>
        </div>
    </div>
</div>
