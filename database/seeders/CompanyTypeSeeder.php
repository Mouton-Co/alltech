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
        foreach (config('seeders.company-types') as $type) {
            CompanyType::factory()->create([
                'name' => $type,
            ]);
        }
    }
}
