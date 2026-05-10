<?php

namespace App\Livewire\Contact\Forms;

use App\Models\Company;
use App\Models\Contact;
use Livewire\Form;

class ContactAndCompanyForm extends Form
{
    public ?string $contactName = '';
    public ?string $contactEmail = '';
    public ?string $contactPhone = '';
    public ?int $contactCompanyId = null;

    public string $companyMode = 'existing';

    public ?string $companyName = '';
    public ?string $companyLocation = '';
    public ?string $companyRegion = '';
    public ?string $companyTypeId = '';

    public function contactRules(): array
    {
        return [
            'contactName' => 'required|string|min:3|max:255',
            'contactEmail' => 'required|email|unique:contacts,email',
            'contactPhone' => 'nullable|string|min:3|max:255',
            'contactCompanyId' => 'required|int|exists:companies,id',
        ];
    }

    public function companyRules(): array
    {
        return [
            'companyName' => 'required|unique:companies,name|string|min:3|max:255',
            'companyLocation' => 'required|string|min:3|max:255',
            'companyRegion' => 'required|string|min:3|max:255',
            'companyTypeId' => 'required|int|exists:company_types,id',
        ];
    }

    public function submit(): void
    {
        $this->validate($this->contactRules());
        if ($this->companyMode === 'new') {
            $this->validate($this->companyRules());
        }

        if ($this->companyMode === 'new') {

            $company = Company::create([
                'name' => $this->companyName,
                'location' => $this->companyLocation,
                'region' => $this->companyRegion,
                'company_type_id' => $this->companyTypeId,
            ]);

            $this->contactCompanyId = $company->getKey();
        }

        Contact::create([
            'name' => $this->contactName,
            'email' => $this->contactEmail,
            'phone' => $this->contactPhone,
            'company_id' => $this->contactCompanyId,
        ]);
    }
}
