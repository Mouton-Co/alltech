<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\CompanyType;
use App\Models\Contact;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class MasterExcelImport implements ToCollection, WithChunkReading
{
    use Importable;

    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) {
            if ($key < 2) {
                continue;
            }

            $company = $this->createCompany($row);
            if (! empty($company)) {
                $this->createContact($row, $company);
            }
        }
    }

    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * Create a company from the row.
     */
    private function createCompany(mixed $row): ?Company
    {
        $companyType = CompanyType::where('name', $row[8] ?? '')->first();

        if (empty($companyType)) {
            $companyType = CompanyType::where('name', 'Other')->first();
        }

        if (! empty($row[4])) {
            return Company::firstOrCreate([
                'name' => $row[4] ?? '',
                'location' => $row[5] ?? '',
                'region' => $row[6] ?? '',
                'company_type_id' => $companyType->id,
            ]);
        }

        return null;
    }

    /**
     * Create a contact from the row.
     */
    private function createContact(mixed $row, Company $company): void
    {
        if (! empty($row[0])) {
            $contact = [
                'name' => $row[0] ?? '',
                'email' => $row[1] ?? '',
                'phone' => $row[2] ?? '',
                'company_id' => $company->id,
            ];

            Contact::firstOrCreate($contact);
        }
    }
}
