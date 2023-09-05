<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Contact;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                'name'    => 'John Doe',
                'email'   => 'johndoe@gmail.com',
                'phone'   => '01234556789',
                'company' => 'Test Comp 1',
            ],
            [
                'name'    => 'Jane Doe',
                'email'   => 'janedoe@gmail.com',
                'phone'   => '01234556789',
                'company' => 'Test Comp 2',
            ],
        ];

        foreach($contacts as $contact) {
            $company = Company::where('name', $contact['company'])->first();
            Contact::create([
                'name'       => $contact['name'],
                'email'      => $contact['email'],
                'phone'      => $contact['phone'],
                'company_id' => $company->id,
            ]);
        }
    }
}
