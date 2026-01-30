<?php

namespace App\Livewire\Company\Pages;

use App\Models\Company;
use Livewire\Component;

class Merge extends Component
{
    /**
     * Properties
     */
    public array $targetCompany = []; // Details of the main company
    public array $companies = []; // All companies available for merging
    public ?string $search = ''; // Search term for filtering companies

    /**
     * Mount the component with the target company ID.
     */
    public function mount(int $targetCompanyId): void
    {
        $this->targetCompany = Company::with('companyType')->findOrFail($targetCompanyId)->toArray();
        $this->companies = Company::with('companyType')
            ->where('id', '!=', $targetCompanyId)
            ->orderBy('name')
            ->get()
            ->keyBy('id')
            ->map(function ($company) {
                return [
                    'name' => $company->name ?? '',
                    'location' => $company->location ?? '',
                    'region' => $company->region ?? '',
                    'company_type' => $company->companyType?->name ?? '',
                    'selected' => false,
                ];
            })
            ->toArray();
    }

    /**
     * Render the Livewire component view.
     */
    public function render(): \Illuminate\View\View
    {
        return view('livewire.company.pages.merge');
    }

    /**
     * Get the filtered list of companies based on the search term.
     */
    public function filteredCompanies(): array
    {
        if (empty($this->search)) {
            return $this->companies;
        }

        $searchTerm = strtolower($this->search);

        return array_filter($this->companies, function ($company) use ($searchTerm) {
            return str_contains(strtolower($company['name']), $searchTerm) ||
                str_contains(strtolower($company['location']), $searchTerm) ||
                str_contains(strtolower($company['region']), $searchTerm) ||
                str_contains(strtolower($company['company_type']), $searchTerm);
        });
    }
}
