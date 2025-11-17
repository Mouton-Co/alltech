<?php

namespace App\Http\Controllers;

use App\Exports\ContactsExport;
use App\Models\Company;
use App\Models\Contact;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\Contact\IndexRequest;
use App\Http\Requests\Contact\StoreRequest;

class ContactController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | RESOURCES
    |--------------------------------------------------------------------------
    */

    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request)
    {
        $contacts = Contact::with('company.companyType');

        if (! empty($request->get('order_by')) && $request->get('order_by') == 'company->name') {
            $contacts = $contacts->join('companies', 'contacts.company_id', '=', 'companies.id')
                ->orderBy('companies.name', $request->get('order_direction') ?? 'asc')
                ->select('contacts.*');
        } else {
            $contacts = $contacts->orderBy(
                $request->get('order_by') ?? 'contacts.name',
                $request->get('order_direction') ?? 'asc'
            );
        }

        if (! empty($request->get('search'))) {
            $contacts = $contacts->where('name', 'like', "%{$request->get('search')}%")
                ->orWhere('email', 'like', "%{$request->get('search')}%")
                ->orWhere('phone', 'like', "%{$request->get('search')}%")
                ->orWhereRelation('company', 'name', 'like', "%{$request->get('search')}%")
                ->orWhereRelation('company', 'location', 'like', "%{$request->get('search')}%")
                ->orWhereRelation('company', 'region', 'like', "%{$request->get('search')}%")
                ->orWhereRelation('company.companyType', 'name', 'like', "%{$request->get('search')}%");
        }

        return view('models.contact.index')->with([
            'contacts' => $contacts->paginate(10),
            'companies' => Company::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $contact = Contact::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'company_id' => $request->get('company_id'),
        ]);

        if ($contact) {
            return redirect()->route('contact.index')->with([
                'success' => "$contact->name successfully created",
            ]);
        }

        return redirect()->route('contact.index')->with([
            'error' => 'Contact creation failed',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, string $id)
    {
        $contact = Contact::find($id);

        if (empty($contact)) {
            return redirect()->route('contact.index')->with([
                'error' => 'Contact not found',
            ]);
        }

        $contact->name = $request->get('name');
        $contact->email = $request->get('email');
        $contact->phone = $request->get('phone');
        $contact->company_id = $request->get('company_id');
        $contact->save();

        return redirect()->route('contact.index', $contact->id)->with([
            'success' => 'Contact updated',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = Contact::find($id);

        if (empty($contact)) {
            return redirect()->route('contact.index')->with([
                'error' => 'Contact not found',
            ]);
        }

        $name = $contact->name;
        $contact->delete();

        return redirect()->route('contact.index')->with([
            'success' => "$name has been removed",
        ]);
    }

    /**
     * Export contacts to an Excel file.
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        return Excel::download(new ContactsExport, 'contacts.xlsx');
    }
}
