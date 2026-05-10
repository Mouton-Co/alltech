<?php

namespace App\Livewire\Contact\Pages;

use App\Models\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $sort = 'name';

    #[Url]
    public string $direction = 'asc';

    #[On('contact.pages.index.render')]
    public function render(): View
    {
        return view('livewire.contact.pages.index');
    }

    #[Computed]
    public function contacts(): LengthAwarePaginator
    {
        return Contact::with(['company.companyType'])
            ->when($this->search, fn ($query) => $this->applySearch($query))
            ->tap(fn ($query) => $this->applySort($query))
            ->paginate(10);
    }

    public function applySearch(Builder $query): void
    {
        $query->where(function ($query) {
            $query
                ->where('name', 'like', "%{$this->search}%")
                ->orWhere('email', 'like', "%{$this->search}%")
                ->orWhere('phone', 'like', "%{$this->search}%")
                ->orWhereHas('company', function ($query) {
                    $query->where(function ($query) {
                        $query
                            ->where('name', 'like', "%{$this->search}%")
                            ->orWhere('location', 'like', "%{$this->search}%")
                            ->orWhere('region', 'like', "%{$this->search}%")
                            ->orWhereHas('companyType', function ($query) {
                                $query->where('name', 'like', "%{$this->search}%");
                            });
                    });
                });
        });
    }

    public function applySort(Builder $query): void
    {
        $direction = $this->direction === 'desc' ? 'desc' : 'asc';

        match ($this->sort) {
            // company type fields
            'company_type' => $query
                ->leftJoin('companies', 'contacts.company_id', '=', 'companies.id')
                ->leftJoin('company_types', 'companies.company_type_id', '=', 'company_types.id')
                ->orderBy('company_types.name', $direction)
                ->select('contacts.*'),

            // company fields
            'company_name' => $query
                ->leftJoin('companies', 'contacts.company_id', '=', 'companies.id')
                ->orderBy('companies.name', $direction)
                ->select('contacts.*'),
            'company_location' => $query
                ->leftJoin('companies', 'contacts.company_id', '=', 'companies.id')
                ->orderBy('companies.location', $direction)
                ->select('contacts.*'),
            'company_region' => $query
                ->leftJoin('companies', 'contacts.company_id', '=', 'companies.id')
                ->orderBy('companies.region', $direction)
                ->select('contacts.*'),

            // contact fields
            'name',
            'email',
            'phone' => $query->orderBy($this->sort, $direction),

            default => $query->orderBy('name'),
        };
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $column): void
    {
        if ($this->sort === $column) {
            $this->direction = $this->direction === 'desc' ? 'asc' : 'desc';

            return;
        }

        $this->sort = $column;
        $this->direction = 'asc';
    }
}
