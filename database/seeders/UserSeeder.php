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

        $admins = [
            [
                'email' => 'arouxmouton@gmail.com',
                'name' => 'Adriaan Mouton',
            ],
            [
                'email' => 'theamouton@gmail.com',
                'name' => 'Thea Mouton',
            ],
            [
                'email' => 'nicole.geyser@alltech.com',
                'name' => 'Nicole Geyser',
            ],
        ];

        foreach ($admins as $admin) {
            User::factory()->create([
                'name' => $admin['name'],
                'email' => $admin['email'],
                'password' => $password,
                'role_id' => Role::where('name', 'Admin')->first()->id,
            ]);
        }

        $clients = [
            [
                'name' => 'Alretha Naude',
                'email' => 'avanheerden@alltech.com',
            ],
            [
                'name' => 'Janke Bestbier',
                'email' => 'janke.bestbier@alltech.com',
            ],
            [
                'name' => 'Johanet van der Merwe',
                'email' => 'johanet.vandermerwe@alltech.com',
            ],
            [
                'name' => 'Murray van Niekerk',
                'email' => 'mvanniekerk@alltech.com',
            ],
            [
                'name' => 'Olga Dreyer',
                'email' => 'olga.dreyer@alltech.com',
            ],
        ];

        foreach ($clients as $client) {
            User::factory()->create([
                'name' => $client['name'],
                'email' => $client['email'],
                'password' => $password,
                'role_id' => Role::where('name', 'Client')->first()->id,
            ]);
        }
    }
}
