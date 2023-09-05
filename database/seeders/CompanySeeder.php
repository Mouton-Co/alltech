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
        $companies = [
            [
                'name'         => 'Test Comp 1',
                'location'     => 'Africa',
                'coordinates'  => '104 189 012',
                'company_type' => 'Consultants',
            ],
            [
                'name'         => 'Test Comp 2',
                'location'     => 'America',
                'coordinates'  => '7767 876',
                'company_type' => 'Veterinarians',
            ],
        ];

        foreach($companies as $company) {
            $companyType = CompanyType::where('name', $company['company_type'])->first();
            Company::create([
                'name'            => $company['name'],
                'location'        => $company['location'],
                'coordinates'     => $company['coordinates'],
                'company_type_id' => $companyType->id,
            ]);
        }
    }
}
