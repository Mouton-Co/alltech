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
    public bool $confirm = false; // Flag to confirm merge action

    /**
     * Mount the component with the target company ID.
     */
    public function mount(int $targetCompanyId): void
    {
        if (auth()->user()->role->name !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        $company = Company::with(['companyType', 'contacts', 'meetings'])->findOrFail($targetCompanyId);
        $this->targetCompany = [
            'id' => $company->id,
            'name' => $company->name ?? '',
            'location' => $company->location ?? '',
            'region' => $company->region ?? '',
            'company_type' => $company->companyType?->name ?? '',
            'meetings_count' => $company->meetings->count(),
            'contacts_count' => $company->contacts->count(),
        ];

        $this->companies = Company::with(['companyType', 'contacts', 'meetings'])
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
                    'meetings_count' => $company->meetings->count(),
                    'contacts_count' => $company->contacts->count(),
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

    /**
     * Calculate the new total contacts after merging.
     */
    public function newContactCount(): int
    {
        return collect($this->companies)
            ->where('selected', true)
            ->sum('contacts_count') + $this->targetCompany['contacts_count'];
    }

    /**
     * Calculate the new total meetings after merging.
     */
    public function newMeetingCount(): int
    {
        return collect($this->companies)
            ->where('selected', true)
            ->sum('meetings_count') + $this->targetCompany['meetings_count'];
    }

    /**
     * Execute the merge operation.
     */
    public function merge(): void
    {
        if (auth()->user()->role->name !== 'Admin') {
            abort(403, 'Unauthorized action.');
        }

        if (! $this->confirm) {
            session()->flash('error', 'You must confirm before proceeding.');
            return;
        }

        // Get all the selected company IDs to merge
        $idsToMerge = collect($this->companies)
            ->where('selected', true)
            ->keys()
            ->toArray();

        // Load the companies to be merged
        $companiesToMerge = Company::with(['contacts', 'meetings'])
            ->whereIn('id', $idsToMerge)
            ->get();

        // Update all related contacts and meetings to point to the target company and then delete the merged companies
        foreach ($companiesToMerge as $company) {
            $company->contacts()->update(['company_id' => $this->targetCompany['id']]);
            $company->meetings()->update(['company_id' => $this->targetCompany['id']]);
            $company->delete();
        }

        session()->flash('success', 'Companies merged successfully.');
        $this->redirectRoute(
            name: 'company.index',
        );
    }
}
