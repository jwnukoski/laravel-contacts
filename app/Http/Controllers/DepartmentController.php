<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show($company_id)
    {
        return Department::where('company_id', $company_id)->get();
    }

    public function showAll($company_id)
    {
        return Department::where('company_id', $company_id)->get();
    }

    public function showAllPositions(Department $department)
    {
        return $department->positions;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $validated = $this->validateDepartment($request);
        return $department->update($validated);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAll(Request $request)
    {

        foreach($request->all() as $newDepartment) {
            $department = Department::where('id', $newDepartment['id'])->first();

            if ($department) {
                if ($newDepartment['company_id'] == null) {
                    $department->delete();
                } else {
                    $department->update(['company_id' => $newDepartment['company_id'],
                    'name' => $newDepartment['name']]);
                }
            } else {
                $department = new Department($newDepartment);
                $department->save();
            }
        }

        return response('Departments updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(department $department)
    {
        //
    }

    public function validateDepartment(Request $request)
    {
        return $request->validate([
            'name' => 'required|min:2|max:64',
            'company_id' => 'exists:companies,id'
        ]);
    }
}
