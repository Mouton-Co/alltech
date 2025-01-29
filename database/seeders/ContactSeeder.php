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
         * Generate 5 contacts for each company
         */
        Company::all()->each(function (Company $company) {
            Contact::factory()->count(5)->create([
                'company_id' => $company->id,
            ]);
        });
    }
}
