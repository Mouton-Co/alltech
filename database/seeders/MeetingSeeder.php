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
         * Create 5 meetings for each company type for each user.
         */

        $companyTypes = CompanyType::all();
        $users        = User::all();
        
        foreach ($users as $user) {
            foreach ($companyTypes as $companyType) {
                // get a random company for the company type
                $company = $companyType->companies->random();
                // get a random contact for the company
                $contact = $company->contacts->random();

                Meeting::factory()->count(5)->create([
                    'contact_id'      => $contact->id,
                    'company_id'      => $company->id,
                    'company_type_id' => $companyType->id,
                    'user_id'         => $user->id,
                ]);
            }
        }
    }
}
