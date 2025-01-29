<?php

namespace App\Http\Controllers;

use App\Http\Services\CalendarService;
use App\Models\User;
use Illuminate\Http\Request;

use function Spatie\LaravelPdf\Support\pdf;

class CalendarController extends Controller
{
    /**
     * Days of the week.
     *
     * @var array
     */
    protected array $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

    /**
     * Months of the year.
     *
     * @var array
     */
    protected array $months = [
        '01' => 'January',
        '02' => 'February',
        '03' => 'March',
        '04' => 'April',
        '05' => 'May',
        '06' => 'June',
        '07' => 'July',
        '08' => 'August',
        '09' => 'September',
        '10' => 'October',
        '11' => 'November',
        '12' => 'December',
    ];

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
            'months' => $this->months,
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
        $formattedCalendar = $this->service->getFormattedCalendar($user, $year, $month);

        return pdf()
            ->view('pdf.calendar', [
                'days' => $this->days,
                'user' => $user,
                'month' => date('F', strtotime("$year-$month-01")),
                'year' => $year,
                'calendar' => $formattedCalendar,
            ])
            ->landscape()
            ->name('calendar.pdf');
    }
}
