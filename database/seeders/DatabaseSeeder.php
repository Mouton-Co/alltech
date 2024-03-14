<?php

namespace Database\Seeders;

use App\Imports\MasterExcelImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Excel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CompanyTypeSeeder::class);

        // for contacts and company types
        (new MasterExcelImport())->import(storage_path('excel/MasterContactData.xlsx'), null, Excel::XLSX);
    }
}
