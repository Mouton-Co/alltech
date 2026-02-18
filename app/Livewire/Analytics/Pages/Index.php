<?php

namespace App\Livewire\Analytics\Pages;

use App\Models\Company;
use App\Models\CompanyType;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Validation\Rule;
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
    public array $groupBy = ['User', 'Contact', 'Company', 'Region', 'Company Type'];
    public array $metrics = ['Number of meetings', 'Number of unique contacts', 'Number of unique companies'];

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
     * The results of the report.
     */
    public array $results = [];

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
        $this->viewReport();
    }

    /**
     * Render the blade view.
     */
    public function render(): View
    {
        return view('livewire.analytics.pages.index');
    }

    /**
     * The rules to validate before showing the report.
     */
    public function rules(): array
    {
        return [
            'groupByA' => [
                'required',
                'string',
                Rule::in($this->groupBy)
            ],
            'groupByB' => [
                'nullable',
                'string',
                Rule::in($this->groupBy)
            ],
            'metric' => [
                'required',
                'string',
                Rule::in($this->metrics)
            ],
        ];
    }

    /**
     * View the report.
     */
    public function viewReport(): void
    {
        $this->validate();

        $select = array_merge(
            config("analytics.select.a.{$this->groupByA}"),
            config("analytics.select.b.{$this->groupByB}"),
        );
        $groupBy = array_values(array_unique(array_merge(
            config("analytics.group_by.{$this->groupByA}"),
            config("analytics.group_by.{$this->groupByB}"),
        )));

        $this->results = Meeting::query()
            ->join('users', 'meetings.user_id', '=', 'users.id')
            ->join('contacts', 'contacts.id', '=', 'meetings.contact_id')
            ->join('companies', 'companies.id', '=', 'contacts.company_id')
            ->join('company_types', 'companies.company_type_id', '=', 'company_types.id')
            ->select($select)
            ->selectRaw(config("analytics.select.count.{$this->metric}"))
            ->groupBy($groupBy)
            ->get()
            ->toArray();
    }
}
