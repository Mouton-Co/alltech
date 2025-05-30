<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;

class CalendarService
{
    /**
     * Days of the week.
     *
     * @var array
     */
    public array $days = [
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday'
    ];

    /**
     * Months of the year.
     *
     * @var array
     */
    public array $months = [
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
     * Lookup field options to show on the calendar for each meeting.
     *
     * @var array
     */
    public array $fields = [
        'start_time' => 'Times',
        'type' => 'Call/Visit',
        'title' => 'Meeting title',
        'location' => 'Location',
        'contact' => 'Contact',
        'company' => 'Company',
    ];

    /**
     * Get the calendar for the given user, year, and month.
     *
     * @param \App\Models\User $user
     * @param string $year
     * @param string $month
     * @param string $type
     * @return array
     */
    public function getFormattedCalendar(User $user, string $year, string $month, string $type, Request $request): array
    {
        $firstDay = date('N', strtotime("$year-$month-01")); // 31
        $lastDay = date('t', strtotime("$year-$month-01")); // 1

        // get all meetings where date is between the first and last day of the month
        $meetings = $user
            ->meetings()
            ->where('cancelled_at', null)
            ->with(['contact', 'contact.company', 'contact.company.companyType'])
            ->whereBetween('date', ["$year-$month-01", "$year-$month-$lastDay"]);

        // if type is present, filter by type
        if (! empty($type)) {
            $meetings = $meetings->where('type', $type);
        }

        if ($request->has('contacts')) {
            $meetings = $meetings->whereIn('contact_id', $request->get('contacts'));
        }

        if ($request->has('companies')) {
            $meetings = $meetings->whereIn('company_id', $request->get('companies'));
        }

        if ($request->has('company_types')) {
            $meetings = $meetings->whereIn('company_type_id', $request->get('company_types'));
        }

        if ($request->has('search')) {
            $search = $request->get('search');
            $meetings = $meetings->where(function ($query) use ($search) {
                $query->where('title', 'like', "%$search%")
                    ->orWhere('location', 'like', "%$search%")
                    ->orWhereRelation('contact', 'name', 'like', "%$search%")
                    ->orWhereRelation('contact.company', 'name', 'like', "%$search%")
                    ->orWhereRelation('contact.company', 'location', 'like', "%$search%")
                    ->orWhereRelation('contact.company', 'region', 'like', "%$search%")
                    ->orWhereRelation('contact.company.companyType', 'name', 'like', "%$search%");
            });
        }

        $meetings = $meetings->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy('date');

        // MON TUE WED THU FRI SAT SUN
        // 01  02  03  04  05  06  07
        // 08  09  10  11  12  13  14
        // 15  16  17  18  19  20  21
        // 22  23  24  25  26  27  28
        // 29  30  31
        $calendar = $this->getCalendarStructure($firstDay, $lastDay);

        // format the calendar for the table on the PDF
        $formattedCalendar = [];
        for ($week = 1; $week <= 6; $week++) {
            $formattedCalendar[$week] = [];
            for ($day = 1; $day <= 5; $day++) {
                // format the day as 01
                $theDay = str_pad($calendar[$week][$day], 2, '0', STR_PAD_LEFT);
                $formattedCalendar[$week][$day] = [
                    'day' => $theDay,
                    'meetings' => array_key_exists("$year-$month-$theDay", $meetings->toArray()) ? $meetings["$year-$month-$theDay"] : [],
                ];
            }
        }

        $formattedCalendar = $this->cleanCalendar($formattedCalendar);

        return $formattedCalendar;
    }

    /**
     * Get the calendar structure for the given first and last day of the month.
     *
     * @param int $firstDay
     * @param int $lastDay
     * @return array
     */
    protected function getCalendarStructure(int $firstDay, int $lastDay): array
    {
        $month = [];
        $week = 1;
        $day = 1;
        for ($i = 1; $i <= 6; $i++) {
            for ($j = 1; $j <= 7; $j++) {
                if ($i === 1 && $j < $firstDay) {
                    $month[$week][$j] = null;
                } elseif ($day <= $lastDay) {
                    $month[$week][$j] = $day;
                    $day++;
                } else {
                    $month[$week][$j] = null;
                }
            }
            $week++;
        }

        return $month;
    }

    /**
     * Clean the calendar by removing the first and last week if they have no weekdays.
     *
     * @param array $calendar
     * @return array
     */
    protected function cleanCalendar(array $calendar): array
    {
        // remove the first week if it has no weekdays
        if ($calendar[1][5]['day'] == '00') {
            unset($calendar[1]);
        }

        // remove the last week if it has no weekdays
        if ($calendar[6][1]['day'] == '00') {
            unset($calendar[6]);
        }

        return $calendar;
    }
}
