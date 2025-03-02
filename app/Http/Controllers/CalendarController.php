<?php

namespace App\Http\Controllers;

use App\Http\Services\CalendarService;
use App\Models\Company;
use App\Models\CompanyType;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

use function Spatie\LaravelPdf\Support\pdf;

class CalendarController extends Controller
{
    /**
     * The calendar service.
     *
     * @var \App\Http\Services\CalendarService
     */
    protected CalendarService $service;

    /**
     * Create a new controller instance.
     *
     * @param \App\Http\Services\CalendarService $service
     */
    public function __construct(CalendarService $service)
    {
        $this->service = $service;
    }

    /**
     * Display the index page.
     */
    public function index()
    {
        return view('models.calendar.index', [
            'users' => User::all(),
            'months' => $this->service->months,
            'fields' => $this->service->fields,
            'contacts' => Contact::all(),
            'companies' => Company::all(),
            'companyTypes' => CompanyType::all(),
        ]);
    }

    /**
     * Export the calendar to PDF.
     */
    public function export(Request $request)
    {
        $user = User::find($request->get('user'));
        $month = $request->get('month');
        $year = $request->get('year');
        $type = $request->get('type') ?? '';
        $formattedCalendar = $this->service->getFormattedCalendar($user, $year, $month, $type, $request);

        return pdf()
            ->view('pdf.calendar', [
                'days' => $this->service->days,
                'user' => $user,
                'month' => date('F', strtotime("$year-$month-01")),
                'year' => $year,
                'calendar' => $formattedCalendar,
            ])
            ->landscape()
            ->name('calendar.pdf');
    }
}
