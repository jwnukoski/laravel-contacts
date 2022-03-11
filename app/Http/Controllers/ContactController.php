<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validated = $this->validateContact($request);
        Contact::create($validated);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $validated = $this->validateContact($request);
        Contact::create($validated);
    }

    /**
     * Display all info for a specific contact
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return $contact->with('phones', 'emails', 'addresses', 'position', 'position.department', 'position.department.company')->firstOrFail();
    }

    /**
     * Display all contacts
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        return Contact::with('phones', 'emails', 'addresses', 'position', 'position.department', 'position.department.company')->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $validated = $this->validateContact($request);

        if ($request->id == null) {
            $contact = new Contact($validated);
            return $contact->save();
        }

        return $contact->update($validated); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Contact::destroy($id);
    }

    protected function validateContact(Request $request) 
    {
        return $request->validate([
            'first_name' => 'required|min:2|max:64',
            'last_name' => 'required|min:2|max:64',
            'suffix' => 'nullable|max:5'
        ]);
    }
}
