<?php

namespace App\Livewire\Analytics\Pages;

use App\Models\Company;
use App\Models\CompanyType;
use App\Models\User;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public array $users = [];
    public array $companyTypes = [];
    public array $regions = [];
    public string $selectedDateRange = '';
    public array $selectedCompanyTypeIds = [];
    public array $selectedUserIds = [];
    public array $selectedRegions = [];

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
    }

    /**
     * Render the blade view.
     */
    public function render(): View
    {
        return view('livewire.analytics.pages.index');
    }
}
