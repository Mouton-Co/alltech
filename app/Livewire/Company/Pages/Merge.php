<?php

namespace App\Livewire\Company\Pages;

use App\Models\Company;
use Livewire\Component;

class Merge extends Component
{
    public array $targetCompany = []; // Details of the main company
    public ?string $search = ''; // Search term for filtering companies
    public array $companies = []; // All companies available for merging

    public function mount(int $targetCompanyId)
    {
        $this->targetCompany = Company::with('companyType')->findOrFail($targetCompanyId)->toArray();
        $this->companies = Company::where('id', '!=', $targetCompanyId)
            ->orderBy('name')
            ->get()
            ->pluck('id', 'name', 'location', 'region')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.company.pages.merge');
    }
}
