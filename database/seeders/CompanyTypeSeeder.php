<?php

namespace Database\Seeders;

use App\Models\CompanyType;
use Illuminate\Database\Seeder;

class CompanyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companyTypes = [
            [
                'name' => 'Feedmill/Co-op',
                'minimum_required' => 4,
            ],
            [
                'name' => 'Farms/Producers',
                'minimum_required' => 5,
            ],
            [
                'name' => 'Consultants',
                'minimum_required' => 2,
            ],
            [
                'name' => 'Veterinarians',
                'minimum_required' => 3,
            ],
            [
                'name' => 'Other',
                'minimum_required' => 3,
            ],
        ];

        foreach ($companyTypes as $companyType) {
            CompanyType::create([
                'name' => $companyType['name'],
                'minimum_required' => $companyType['minimum_required'],
            ]);
        }
    }
}
