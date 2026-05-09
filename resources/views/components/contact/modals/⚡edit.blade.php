<?php

use App\Livewire\Contact\Forms\ContactForm;
use App\Models\Company;
use App\Models\Contact;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component {
    public ContactForm $form;
    public bool $show = false;

    #[Computed]
    public function companies(): array
    {
        return Company::orderBy('name')->pluck('name', 'id')->toArray();
    }

    #[On('contact.modals.edit.show')]
    public function show(int $id): void
    {
        $contact = Contact::findOrFail($id);
        $this->form->setContact($contact);
        $this->show = true;
    }

    public function update(): void
    {
        $this->form->submit();
        $this->show = false;
        $this->dispatch('contact.pages.index.render');
        $this->dispatch('flash.success.show', message: 'Contact updated');
    }
};
?>

<div
    class="fixed inset-0 z-40 flex h-screen w-screen items-center justify-center bg-black/50"
    wire:show='show'
    wire:cloak
>
    <div
        class="flex w-full max-w-2xl flex-col gap-3 rounded-lg bg-white px-4 py-6 shadow"
        wire:click.outside="$toggle('show')"
    >
        <h1>{{ __('Edit contact') }}</h1>
        <x-contact.forms.contact-form />
        <button
            class="btn-orange-thin h-[30px] w-fit self-end px-4"
            wire:click='update'
        >
            {{ __('Update') }}
        </button>
    </div>
</div>
