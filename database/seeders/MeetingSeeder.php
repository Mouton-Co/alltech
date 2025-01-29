<?php

namespace Database\Seeders;

use App\Models\Meeting;
use App\Models\User;
use Illuminate\Database\Seeder;

class MeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1);

        // For the current month, generate between 0-5 meetings per day
        // Skip weekends
        $month = date('m');
        $year = date('Y');
        $lastDay = date('t', strtotime("$year-$month-01"));

        for ($i = 1; $i <= $lastDay; $i++) {
            if (in_array(date('N', strtotime("$year-$month-$i")), [6, 7])) {
                continue;
            }

            $meetings = rand(0, 5);
            for ($j = 0; $j < $meetings; $j++) {
                Meeting::factory()->create([
                    'user_id' => $user->id,
                    'date' => "$year-$month-$i",
                ]);
            }
        }
    }
}
