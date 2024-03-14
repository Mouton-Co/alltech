<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
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
    public $request;

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
        $meetings      = Meeting::with(['user', 'contact', 'contact.company', 'contact.company.companyType']);
        $hasQuery      = false;
        $this->request = $request;

        // filter contacts
        if (! empty($request->get('contacts'))) {
            $hasQuery = true;
            $meetings->whereIn('contact_id', $request->get('contacts'));
        }

        // filter companies
        if (! empty($request->get('companies'))) {
            $hasQuery = true;
            $meetings->whereIn(
                'contact_id',
                Contact::whereIn('company_id', $request->get('companies'))->pluck('id')->toArray()
            );
        }

        // filter company types
        if (! empty($request->get('company_types'))) {
            $hasQuery = true;
            $meetings->whereIn(
                'contact_id',
                Contact::whereIn(
                    'company_id',
                    Company::whereIn('company_type_id', $request->get('company_types'))->pluck('id')->toArray()
                )->pluck('id')->toArray()
            );
        }

        // filter users
        if (! empty($request->get('users'))) {
            $hasQuery = true;
            $meetings->whereIn('user_id', $request->get('users'));
        }

        // filter date range
        if (! empty($request->get('date_range'))) {
            $hasQuery = true;
            $dateRange = explode(' to ', $request->get('date_range'));
            $meetings->where('date', '>=', $dateRange[0])->where('date', '<=', $dateRange[1]);
        }

        // filter search
        if (! empty($request->get('search'))) {
            $hasQuery = true;
            $meetings = $meetings->where(function ($query) {
                $query->where('report', 'LIKE', '%'.$this->request->get('search').'%')
                    ->orWhere('title', 'LIKE', '%'.$this->request->get('search').'%')
                    ->orWhere('location', 'LIKE', '%'.$this->request->get('search').'%');
            });
        }

        return view('models.reporting.report', [
            'report'       => Report::find($request->get('report_id')),
            'hasQuery'     => $hasQuery,
            'users'        => User::all(),
            'companies'    => Company::all(),
            'companyTypes' => CompanyType::all(),
            'contacts'     => Contact::all(),
            'meetings'     => $meetings->paginate(8),
        ]);
    }

    /**
     * save the report
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $report          = new Report();
        $report->name    = $request->input('name');
        $report->filter  = $request->input('filter');
        $report->user_id = auth()->id();
        $report->save();

        return redirect()->route('reporting.report', json_decode($report->filter, true));
    }

    /**
     * update the report
     */
    public function update(UpdateRequest $request): RedirectResponse
    {
        $report          = Report::find($request->input('report_id'));
        $report->name    = $request->input('name');
        $report->filter  = $request->input('filter');
        $report->user_id = auth()->id();
        $report->save();

        return redirect()->route('reporting.report', json_decode($report->filter_used, true));
    }

    /**
     * delete the report
     */
    public function destroy($id): RedirectResponse
    {
        $report = Report::find($id);
        $report->delete();

        return redirect()->route('reporting.index');
    }

    /**
     * export the report
     */
    public function export(Request $request)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new ReportExport($request), 'reports.xlsx');
    }
}
