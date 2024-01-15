<?php

namespace App\Http\Controllers;

use App\Http\Requests\Report\StoreRequest;
use App\Http\Requests\Report\UpdateRequest;
use App\Models\Company;
use App\Models\CompanyType;
use App\Models\Contact;
use App\Models\Meeting;
use App\Models\Report;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReportingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $reports = Report::where('user_id', auth()->id())->paginate(10);

        return view('models.reporting.index', compact('reports'));
    }

    public function report(Request $request): View
    {
        $users = User::all();
        $companies = Company::all();
        $companyTypes = CompanyType::all();
        $contacts = Contact::all();

        $meetings = app(Meeting::class)::query();

        $hasQuery = false;

        if ($request->has('contacts') && ! empty($request->get('contacts'))) {
            $hasQuery = true;
            $queryContacts = Contact::whereIn('contact_id', $request->get('contacts'))->pluck('id')->toArray();
        } else {
            $queryContacts = [];
        }

        if ($request->has('companies') && ! empty($request->get('companies'))) {
            $hasQuery = true;
            $queryContacts = array_merge(Contact::whereIn('company_id', $request->get('companies'))->pluck('id')->toArray(), $queryContacts);
        }

        if ($request->has('company_types') && ! empty($request->get('company_types'))) {
            $hasQuery = true;
            $queryCompanies = Company::whereIn('company_type_id', $request->get('company_types'))->get();
            foreach ($queryCompanies as $company) {
                $queryContacts = array_merge(Contact::where('company_id', $company->id)->pluck('id')->toArray(), $queryContacts);
            }
        }

        if (! empty($queryContacts)) {
            $meetings->whereIn('contact_id', $queryContacts);
        }

        if ($request->has('users') && ! empty($request->get('users'))) {
            $hasQuery = true;
            $meetings->whereIn('user_id', $request->get('users'));
        }

        if ($request->has('date_range') && ! empty($request->get('date_range'))) {
            $hasQuery = true;
            $dateRange = explode(' to ', $request->get('date_range'));
            $meetings->where('date', '>=', $dateRange[0])->where('date', '<=', $dateRange[1]);
        }

        if ($request->has('search') && ! empty($request->get('search'))) {
            $hasQuery = true;
            $meetings->where('objectives', 'LIKE', '%'.$request->get('search').'%');
            $meetings->orWhere('marketing_requirements', 'LIKE', '%'.$request->get('search').'%');
        }

        $meetings = $meetings->paginate(20);

        return view(
            'models.reporting.report',
            compact(
                'users',
                'companies',
                'companyTypes',
                'contacts',
                'meetings',
                'hasQuery'
            )
        );
    }

    /**
     * save the report
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $report = new Report();
        $report->filter_name = $request->input('filter_name');
        $report->filter_used = $request->input('filter_used');
        $report->recipient = $request->input('recipient');
        $report->send_at = $request->input('send_at');
        $report->repeat = $request->input('repeat');
        $report->repeat_frequency = $request->input('repeat_frequency');
        $report->user_id = auth()->id();
        $report->save();

        return redirect()->route('reporting.report', $request->all());
    }

    /**
     * update the report
     */
    public function update(UpdateRequest $request): RedirectResponse
    {
        $report = Report::find($request->input('report_id'));
        $report->filter_name = $request->input('filter_name');
        $report->filter_used = $request->input('filter_used');
        $report->recipient = $request->input('recipient');
        $report->send_at = $request->input('send_at');
        $report->repeat = $request->input('repeat');
        $report->repeat_frequency = $request->input('repeat_frequency');
        $report->user_id = auth()->id();
        $report->save();

        return redirect()->route('reporting.report', $request->all());
    }

    /**
     * delete the report
     */
    public function destroy(Request $request): RedirectResponse
    {
        $report = Report::find($request->input('report_id'));
        $report->delete();

        return redirect()->route('reporting.index');
    }
}
