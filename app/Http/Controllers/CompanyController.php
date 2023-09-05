<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreRequest;
use App\Models\Company;
use App\Models\CompanyType;

class CompanyController extends Controller
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
        $companies = Company::all();

        return view('models.company.index')->with([
            'companies' => $companies,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companyTypes = CompanyType::all();

        return view('models.company.create')->with([
            'companyTypes' => $companyTypes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $company = Company::create([
            'name'            => $request->get('name'),
            'location'        => $request->get('location'),
            'coordinates'     => $request->get('coordinates'),
            'company_type_id' => $request->get('company_type_id'),
        ]);

        if ($company) {
            return redirect()->route('company.index')->with([
                'success' => "$company->name successfully created"
            ]);
        }

        return redirect()->route('company.index')->with([
            'error' => "Company creation failed"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::find($id);

        if (empty($company)) {
            return redirect()->route('company.index')->with([
                'error' => "Company not found"
            ]);
        }

        $companyTypes = CompanyType::all();

        return view('models.company.edit')->with([
            'company'      => $company,
            'companyTypes' => $companyTypes,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, string $id)
    {
        $company = Company::find($id);

        if (empty($company)) {
            return redirect()->route('company.index')->with([
                'error' => "Company not found"
            ]);
        }

        $company->name            = $request->get('name');
        $company->location        = $request->get('location');
        $company->coordinates     = $request->get('coordinates');
        $company->company_type_id = $request->get('company_type_id');
        $company->save();

        return redirect()->route('company.edit', $company->id)->with([
            'success' => "Company updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::find($id);

        if (empty($company)) {
            return redirect()->route('company.index')->with([
                'error' => "Company not found"
            ]);
        }

        $name = $company->name;
        $company->delete();

        return redirect()->route('company.index')->with([
            'success' => "$name has been removed"
        ]);
    }
}
