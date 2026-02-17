<?php

namespace App\Livewire\Analytics\Pages;

use App\Models\Company;
use App\Models\CompanyType;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    /**
     * Options that are initialised for the dropdowns.
     */
    public array $users = [];
    public array $companyTypes = [];
    public array $regions = [];

    /**
     * These are multi select options which gets updated manually via form submission.
     */
    public array $selectedCompanyTypeIds = [];
    public array $selectedUserIds = [];
    public array $selectedRegions = [];

    /**
     * These are string which gets updated manually via form submission.
     */
    public string $selectedDateRange = '';
    public string $groupByA = '';
    public string $groupByB = '';
    public string $metric = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->users = User::orderBy('name')->pluck('name', 'id')->toArray();
        $this->companyTypes = CompanyType::orderBy('name')->pluck('name', 'id')->toArray();
        $this->regions = Company::orderBy('region')->pluck('region')->unique()->toArray();
        $this->selectedDateRange = request()->get('date_range', '') ?? '';
        $this->selectedCompanyTypeIds = request()->get('company_type_ids', []);
        $this->selectedUserIds = request()->get('user_ids', []);
        $this->selectedRegions = request()->get('regions', []);
        $this->groupByA = request()->get('group_by_a', '') ?? '';
        $this->groupByB = request()->get('group_by_b', '') ?? '';
        $this->metric = request()->get('metric', '') ?? '';
    }

    /**
     * Render the blade view.
     */
    public function render(): View
    {
        return view('livewire.analytics.pages.index');
    }
}
