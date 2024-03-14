<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyType\IndexRequest;
use App\Http\Requests\CompanyType\StoreRequest;
use App\Http\Requests\CompanyType\UpdateRequest;
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
    public function index(IndexRequest $request)
    {
        $companyTypes = CompanyType::orderBy(
            $request->get('order_by') ?? 'name',
            $request->get('order_direction') ?? 'asc'
        );

        if (! empty($request->get('search'))) {
            $companyTypes = $companyTypes->where('name', 'like', '%'.$request->get('search').'%');
        }

        return view('models.company-type.index')->with([
            'companyTypes' => $companyTypes->paginate(10),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $companyType = CompanyType::create($request->all());

        if ($companyType) {
            return redirect()->route('company-type.index')->with([
                'success' => "$companyType->name successfully created",
            ]);
        }

        return redirect()->route('company-type.index')->with([
            'error' => 'Company type creation failed',
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $companyType = CompanyType::find($id);

        if (empty($companyType)) {
            return redirect()->route('company-type.index')->with([
                'error' => 'Company type not found',
            ]);
        }
        
        $companyType->update($request->all());

        return redirect()->route('company-type.index', $companyType->id)->with([
            'success' => 'Company type updated',
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
                'error' => 'Company type not found',
            ]);
        }

        $name = $companyType->name;
        $companyType->delete();

        return redirect()->route('company-type.index')->with([
            'success' => "$name has been removed",
        ]);
    }
}
