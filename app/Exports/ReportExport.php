<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\Contact;
use App\Models\Meeting;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class ReportExport implements FromView
{
    public $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function view(): View
    {
        $meetings = app(Meeting::class)::query();

        if ($this->request->has('contacts') && ! empty($this->request->get('contacts'))) {
            $queryContacts = Contact::whereIn('contact_id', $this->request->get('contacts'))->pluck('id')->toArray();
        } else {
            $queryContacts = [];
        }

        if ($this->request->has('companies') && ! empty($this->request->get('companies'))) {
            $queryContacts = array_merge(
                Contact::whereIn('company_id', $this->request->get('companies'))->pluck('id')->toArray(),
                $queryContacts
            );
        }

        if ($this->request->has('company_types') && ! empty($this->request->get('company_types'))) {
            $queryCompanies = Company::whereIn('company_type_id', $this->request->get('company_types'))->get();
            foreach ($queryCompanies as $company) {
                $queryContacts = array_merge(
                    Contact::where('company_id', $company->id)->pluck('id')->toArray(),
                    $queryContacts
                );
            }
        }

        if (! empty($queryContacts)) {
            $meetings->whereIn('contact_id', $queryContacts);
        }

        if ($this->request->has('users') && ! empty($this->request->get('users'))) {
            $meetings->whereIn('user_id', $this->request->get('users'));
        }

        if ($this->request->has('date_range') && ! empty($this->request->get('date_range'))) {
            $dateRange = explode(' to ', $this->request->get('date_range'));
            $meetings->where('date', '>=', $dateRange[0])->where('date', '<=', $dateRange[1]);
        }

        if ($this->request->has('search') && ! empty($this->request->get('search'))) {
            $meetings->where('objectives', 'LIKE', '%'.$this->request->get('search').'%');
            $meetings->orWhere('marketing_requirements', 'LIKE', '%'.$this->request->get('search').'%');
        }

        return view('models.reporting.export', [
            'meetings' => $meetings->get(),
        ]);
    }
}
