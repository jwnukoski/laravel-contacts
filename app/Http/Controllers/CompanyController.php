<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function show(Request $request, Company $company)
    {
        return $company->firstOrFail();
    }

    public function store(Request $request)
    {   
        $validated = $this->validateCompany($request);
        Company::create($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        return Company::all();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        if ($company['name'] == null) {
            $company->delete();
        } else {
            $company->update(['name' => $request['name']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        return $company->delete();
    }

    protected function validateCompany(Request $request) 
    {
        return $request->validate([
            'name' => 'required|min:2|max:64'
        ]);
    }
}
