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
        $types = [
            'Feedmill/Co-op',
            'Farms/Producers',
            'Consultants',
            'Veterinarians',
            'Other',
        ];

        foreach ($types as $type) {
            CompanyType::factory()->create([
                'name' => $type,
            ]);
        }
    }
}
