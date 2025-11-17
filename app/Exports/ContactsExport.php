<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactsExport implements FromArray, WithHeadings
{
    /**
     * Define the headings for the export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Contact Name',
            'Contact Email',
            'Contact Phone',
            'Company Name',
            'Company Location',
            'Company Region',
            'Company Type',
        ];
    }

    /**
     * Prepare the data for export.
     *
     * @return array
     */
    public function array(): array
    {
        $contacts = Contact::query()
            ->with('company.companyType')
            ->get();

        return $contacts->map(function (Contact $contact) {
            return [
                'Contact Name' => $contact?->name ?? '',
                'Contact Email' => $contact?->email ?? '',
                'Contact Phone' => $contact?->phone ?? '',
                'Company Name' => $contact?->company?->name ?? '',
                'Company Location' => $contact?->company?->location ?? '',
                'Company Region' => $contact?->company?->region ?? '',
                'Company Type' => $contact?->company?->companyType?->name ?? '',
            ];
        })->toArray();
    }
}
