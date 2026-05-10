<?php

namespace App\Livewire\Contact\Forms;

use App\Models\Contact;
use Illuminate\Validation\Rule;
use Livewire\Form;

class ContactForm extends Form
{
    public ?Contact $contact = null;
    public ?string $name = '';
    public ?string $email = '';
    public ?string $phone = '';
    public ?int $companyId = null;

    public function setContact(Contact $contact): void
    {
        $this->contact = $contact;
        $this->name = $this->contact->name;
        $this->email = $this->contact->email;
        $this->phone = $this->contact->phone;
        $this->companyId = $this->contact->company_id;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('contacts', 'email')->ignore($this->contact),
            ],
            'phone' => 'nullable|string|min:3|max:255',
            'companyId' => [
                'required',
                'int',
                Rule::exists('companies', 'id'),
            ],
        ];
    }

    public function submit(): void
    {
        $this->validate();

        if ($this->contact) {
            $this->contact->update([
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'company_id' => $this->companyId,
            ]);

            return;
        }

        Contact::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'company_id' => $this->companyId,
        ]);
    }
}
