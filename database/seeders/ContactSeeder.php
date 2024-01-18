<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Generate 10 contacts for each company
         */
        $companies = Company::all();

        foreach ($companies as $company) {
            Contact::factory()->count(10)->create([
                'company_id' => $company->id,
            ]);
        }
    }
}
