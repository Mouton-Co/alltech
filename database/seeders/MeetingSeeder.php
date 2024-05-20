<?php

namespace Database\Seeders;

use App\Models\Meeting;
use Illuminate\Database\Seeder;

class MeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Meeting::truncate();
        // create 5 random meetings each day for the next 100 days
        for ($i = 0; $i < 100; $i++) {
            Meeting::factory(5)->create([
                'date' => now()->addDays($i)->format('Y-m-d'),
                'user_id' => '1',
            ]);
        }
    }
}
