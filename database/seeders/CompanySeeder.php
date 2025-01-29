<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyType;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
         * Generate 5 companies for each company type
         */
        CompanyType::all()->each(function (CompanyType $companyType) {
            Company::factory()->count(5)->create([
                'company_type_id' => $companyType->id,
            ]);
        });
    }
}
