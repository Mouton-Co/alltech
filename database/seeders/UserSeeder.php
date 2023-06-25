<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
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
                'name' => 'Adriaan Admin',
                'roles' => ['admin'],
            ],
            [
                'email' => 'arouxmouton.sales@gmail.com',
                'name' => 'Adriaan Sales',
                'roles' => ['sales'],
            ],
        ];

        foreach($users as $user) {
            $roles = $user['roles'];
            $user = User::create([
                'name'     => $user['name'],
                'email'    => $user['email'],
                'password' => $password,
            ]);
            foreach ($roles as $roleSlug) {
                $role = Role::where('role', $roleSlug)->first();
                UserRole::create([
                    'user_id' => $user->id,
                    'role_id' => $role->id,
                ]);
            }
        }
    }
}
