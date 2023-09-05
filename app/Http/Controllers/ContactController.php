<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreRequest;
use App\Models\Company;
use App\Models\Contact;

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
    public function index()
    {
        $contacts = Contact::all();

        return view('models.contact.index')->with([
            'contacts' => $contacts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::all();

        return view('models.contact.create')->with([
            'companies' => $companies,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $contact = Contact::create([
            'name'       => $request->get('name'),
            'email'      => $request->get('email'),
            'phone'      => $request->get('phone'),
            'company_id' => $request->get('company_id'),
        ]);

        if ($contact) {
            return redirect()->route('contact.index')->with([
                'success' => "$contact->name successfully created"
            ]);
        }

        return redirect()->route('contact.index')->with([
            'error' => "Contact creation failed"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contact = Contact::find($id);

        if (empty($contact)) {
            return redirect()->route('contact.index')->with([
                'error' => "Contact not found"
            ]);
        }

        $companies = Company::all();

        return view('models.contact.edit')->with([
            'contact'   => $contact,
            'companies' => $companies,
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
                'error' => "Contact not found"
            ]);
        }

        $contact->name       = $request->get('name');
        $contact->email      = $request->get('email');
        $contact->phone      = $request->get('phone');
        $contact->company_id = $request->get('company_id');
        $contact->save();

        return redirect()->route('contact.edit', $contact->id)->with([
            'success' => "Contact updated"
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
                'error' => "Contact not found"
            ]);
        }

        $name = $contact->name;
        $contact->delete();

        return redirect()->route('contact.index')->with([
            'success' => "$name has been removed"
        ]);
    }
}
