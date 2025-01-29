<?php

namespace App\Http\Services;

use App\Models\User;

class CalendarService
{
    /**
     * Get the calendar for the given user, year, and month.
     *
     * @param \App\Models\User $user
     * @param string $year
     * @param string $month
     * @return array
     */
    public function getFormattedCalendar(User $user, string $year, string $month): array
    {
        $firstDay = date('N', strtotime("$year-$month-01")); // 31
        $lastDay = date('t', strtotime("$year-$month-01")); // 1

        // get all meetings where date is between the first and last day of the month
        $meetings = $user
            ->meetings()
            ->whereBetween('date', ["$year-$month-01", "$year-$month-$lastDay"])
            ->orderBy('date')
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
