<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\IndexRequest;
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
    public function index(IndexRequest $request)
    {
        $companies = Company::select(['companies.*', 'company_types.name as company_types_name'])
            ->join('company_types', 'company_types.id', '=', 'companies.company_type_id');

        if (!empty($request->get('order_by')) && $request->get('order_by') == 'companyType->name') {
            $companies = $companies->orderBy(
                'company_types.name',
                $request->get('order_direction') ?? 'asc'
            );
        } else {
            $companies = $companies->orderBy(
                $request->get('order_by') ?? 'companies.name',
                $request->get('order_direction') ?? 'asc'
            );
        }

        if (!empty($request->get('search'))) {
            $companies = $companies->where('companies.name', 'like', '%' . $request->get('search') . '%')
                ->orWhere('location', 'like', '%' . $request->get('search') . '%')
                ->orWhere('company_types.name', 'like', '%' . $request->get('search') . '%');
        }

        return view('models.company.index')->with([
            'companies'    => $companies->paginate(10),
            'companyTypes' => CompanyType::all(),
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

        return redirect()->route('company.index', $company->id)->with([
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
