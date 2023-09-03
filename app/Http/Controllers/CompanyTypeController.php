<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyType\StoreRequest;
use App\Models\CompanyType;

class CompanyTypeController extends Controller
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
        $companyTypes = CompanyType::all();

        return view('models.company-type.index')->with([
            'companyTypes' => $companyTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('models.company-type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $companyType = CompanyType::create([
            'name'             => $request->get('name'),
            'minimum_required' => $request->get('minimum_required'),
        ]);

        if ($companyType) {
            return redirect()->route('company-type.index')->with([
                'success' => "$companyType->name successfully created"
            ]);
        }

        return redirect()->route('company-type.index')->with([
            'error' => "Company type creation failed"
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $companyType = CompanyType::find($id);

        if (empty($companyType)) {
            return redirect()->route('company-type.index')->with([
                'error' => "Company type not found"
            ]);
        }

        return view('models.company-type.edit')->with([
            'companyType'   => $companyType,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, string $id)
    {
        $companyType = CompanyType::find($id);

        if (empty($companyType)) {
            return redirect()->route('company-type.index')->with([
                'error' => "Company type not found"
            ]);
        }

        $companyType->name             = $request->get('name');
        $companyType->minimum_required = $request->get('minimum_required');
        $companyType->save();

        return redirect()->route('company-type.edit', $companyType->id)->with([
            'success' => "Company type updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $companyType = CompanyType::find($id);

        if (empty($companyType)) {
            return redirect()->route('company-type.index')->with([
                'error' => "Company type not found"
            ]);
        }

        $name = $companyType->name;
        $companyType->delete();

        return redirect()->route('company-type.index')->with([
            'success' => "$name has been removed"
        ]);
    }
}
