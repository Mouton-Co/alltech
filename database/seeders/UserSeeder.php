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

        $users = [
            [
                'email' => 'arouxmouton@gmail.com',
                'name'  => 'Adriaan Mouton',
                'role'  => 'Admin',
            ],
            [
                'email' => 'theamouton@gmail.com',
                'name'  => 'Thea Mouton',
                'role'  => 'Admin',
            ],
            [
                'email' => 'nicole.geyser@Alltech.com',
                'name'  => 'Nicole Geyser',
                'role'  => 'Admin',
            ],
        ];

        foreach ($users as $user) {
            User::factory()->create([
                'role_id' => Role::where('name', $user['role'])->first()->id,
                'password' => $password,
                'name'     => $user['name'],
                'email'    => $user['email'],
            ]);
        }
    }
}
