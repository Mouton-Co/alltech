<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password');

        foreach (config('seeders.users') as $role => $users) {
            $role = Role::where('name', $role)->first();
            foreach ($users as $user) {
                User::factory()->create([
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => $password,
                    'role_id' => $role->id,
                ]);
            }
        }
    }
}
