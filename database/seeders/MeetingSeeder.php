<?php

namespace Database\Seeders;

use App\Models\CompanyType;
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
        /**
         * Create 1 random meeting per day for this user for this week.
         */
        $users = User::whereIn('email', ['arouxmouton@gmail.com', 'nicole.geyser@Alltech.com', 'theamouton@gmail.com'])->get();
        $companyTypes = CompanyType::all();

        // get start of this week
        $startOfWeek = now()->startOfWeek();

        // for each day of the week
        foreach ($users as $user) {
            for ($i = 0; $i < 7; $i++) {
                // create random meeting
                $companyType = $companyTypes->random();
                $company = $companyType->companies->random();
                $contact = $company->contacts->random();
                Meeting::factory()->create([
                    'user_id' => $user->id,
                    'company_type_id' => $companyType->id,
                    'company_id' => $company->id,
                    'contact_id' => $contact->id,
                    'date' => $startOfWeek->format('Y-m-d'),
                ]);

                // go to next day
                $startOfWeek->addDay();
            }
        }
    }
}
