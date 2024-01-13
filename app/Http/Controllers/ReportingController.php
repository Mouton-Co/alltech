<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyType;
use App\Models\Contact;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReportingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return View
     */
    public function index(Request $request): View
    {
        return view('models.reporting.index');
    }

    public function report(Request $request): View
    {
        $users = User::all();
        $companies = Company::all();
        $companyTypes = CompanyType::all();
        $contacts = Contact::all();

        $meetings = app(Meeting::class)::query();

        if ($request->has('contacts')) {
            $queryContacts = Contact::whereIn('contact_id', $request->get('contacts'))->pluck('id')->toArray();
        } else {
            $queryContacts = [];
        }

        if ($request->has('companies')) {
            $queryContacts = array_merge(Contact::whereIn('company_id', $request->get('companies'))->pluck('id')->toArray(), $queryContacts);
        }

        if ($request->has('company_types')) {
            $queryCompanies = Company::whereIn('company_type_id', $request->get('company_types'))->get();
            foreach ($queryCompanies as $company) {
                $queryContacts = array_merge(Contact::where('company_id', $company->id)->pluck('id')->toArray(), $queryContacts);
            }
        }

        if ( ! empty($queryContacts)) {
            $meetings->whereIn('contact_id', $queryContacts);
        }

        if ($request->has('users')) {
            $meetings->whereIn('user_id', $request->get('users'));
        }

        if ($request->has('date_range') && ! empty($request->get('date_range'))) {
            $dateRange = explode(' to ', $request->get('date_range'));
            $meetings->where('date', '>=', $dateRange[0])->where('date', '<=', $dateRange[1]);
        }

        $meetings = $meetings->paginate(20);

        return view(
            'models.reporting.report',
            compact(
                'users',
                'companies',
                'companyTypes',
                'contacts',
                'meetings'
            )
        );
    }
}
