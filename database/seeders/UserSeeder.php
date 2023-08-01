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
        ];
        
        foreach ($users as $user) {
            $role = Role::where('name', $user['role'])->first();
            $user = User::create([
                'name'     => $user['name'],
                'email'    => $user['email'],
                'password' => $password,
                'role_id'  => $role->id,
            ]);
        }
    }
}
