<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\CompanyType;
use App\Models\Contact;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class MasterExcelImport implements ToCollection, WithChunkReading
{
    use Importable;

    public function collection(Collection $rows)
    {
        $emails = [];

        foreach ($rows as $key => $row) {
            if ($key < 2) {
                continue;
            }

            $user = $this->createUser($row, $emails);
            $company = $this->createCompany($row);
            $this->createContact($row, $company, $user);
        }

        $this->sendPasswordResetEmails($emails);
    }

    public function chunkSize(): int
    {
        return 100;
    }

    private function createUser(mixed $row, array &$emails): ?User
    {
        if (
            $row[0] != null &&
            $row[1] != null &&
            $row[2] != null
        ) {
            $role = Role::where('name', 'Admin')->first();
            $password = Hash::make('password');
            $user = User::firstOrCreate(
                [
                    'name' => $row[0] ?? '',
                    'email' => $row[1] ?? '',
                    'phone_number' => $row[2] ?? '',
                ], [
                    'role_id' => $role->id,
                    'password' => $password,
                ]
            );

            $emails[] = $user->email;

            return $user;
        }

        return null;
    }

    private function createCompany(mixed $row): Company
    {
        if (! empty($row[10])) {
            if ($row[10] == 'Co--Ops') {
                $row[10] = 'co-op';
            }

            $companyType = CompanyType::where('name', 'like', '%'.Str::singular($row[10]).'%')->first();
            if (empty($companyType)) {
                dd($row[10]);
            }
        } else {
            $companyType = CompanyType::where('name', 'Other')->first();
        }

        return Company::firstOrCreate([
            'name' => $row[6] ?? '',
            'location' => $row[7] ?? '',
            'region' => $row[8] ?? '',
            'coordinates' => $row[9] ?? '',
            'company_type_id' => $companyType->id,
        ]);
    }

    private function createContact(mixed $row, Company $company, ?User $user): void
    {
        $contact = [
            'name' => $row[3] ?? '',
            'email' => $row[4] ?? '',
            'phone' => $row[5] ?? '',
            'company_id' => $company->id,
        ];

        if (! empty($user)) {
            $contact['user_id'] = $user->id;
        }

        Contact::firstOrCreate($contact);
    }

    private function sendPasswordResetEmails(array $emails): void
    {
        try {
            $emails = array_unique($emails);
            foreach ($emails as $email) {
                $user = User::where('email', $email)->first();
                if (! empty($user)) {
                    Password::sendResetLink(
                        $user->only('email')
                    );
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());
        }
    }
}
