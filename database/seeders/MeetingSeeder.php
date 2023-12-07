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
        $user = User::where('email', 'arouxmouton@gmail.com')->first();
        $companyTypes = CompanyType::all();

        // get start of this week
        $startOfWeek = now()->startOfWeek();

        // for each day of the week
        for ($i = 0; $i < 7; $i++) {
            // create random meeting
            $companyType = $companyTypes->random();
            $company     = $companyType->companies->random();
            $contact     = $company->contacts->random();
            Meeting::factory()->create([
                'user_id'         => $user->id,
                'company_type_id' => $companyType->id,
                'company_id'      => $company->id,
                'contact_id'      => $contact->id,
                'date'            => $startOfWeek->format('Y-m-d'),
            ]);

            // go to next day
            $startOfWeek->addDay();
        }
    }
}
