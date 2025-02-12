<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        $this->call(CompanySeeder::class);
        $this->call(ContactSeeder::class);
        $this->call(MeetingSeeder::class);
    }
}
