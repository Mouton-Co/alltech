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
        $meetings = Meeting::with(['user', 'contact', 'contact.company', 'contact.company.companyType']);

        // filter contacts
        if (!empty($this->request->get('contacts'))) {
            $meetings->whereIn('contact_id', $this->request->get('contacts'));
        }
        
        // filter companies
        if (!empty($this->request->get('companies'))) {
            $meetings->whereIn(
                'contact_id',
                Contact::whereIn('company_id', $this->request->get('companies'))->pluck('id')->toArray()
            );
        }
        
        // filter company types
        if (!empty($this->request->get('company_types'))) {
            $meetings->whereIn(
                'contact_id',
                Contact::whereIn(
                    'company_id',
                    Company::whereIn('company_type_id', $this->request->get('company_types'))->pluck('id')->toArray()
                )->pluck('id')->toArray()
            );
        }
        
        // filter users
        if (!empty($this->request->get('users'))) {
            $meetings->whereIn('user_id', $this->request->get('users'));
        }

        // filter date range
        if (!empty($this->request->get('date_range'))) {
            $dateRange = explode(' to ', $this->request->get('date_range'));
            $meetings->where('date', '>=', $dateRange[0])->where('date', '<=', $dateRange[1]);
        }

        // filter search
        if (!empty($this->request->get('search'))) {
            $meetings = $meetings->where(function ($query) {
                $query->where('objective', 'LIKE', '%'.$this->request->get('search').'%')
                    ->orWhere('marketing_requirements', 'LIKE', '%'.$this->request->get('search').'%');
            });
        }

        return view('models.reporting.export', [
            'meetings' => $meetings->get(),
        ]);
    }
}
