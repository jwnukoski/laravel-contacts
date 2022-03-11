<?php

namespace App\Http\Controllers;

use App\Models\Email;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Email::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function update(Email $email)
    {
        return $email->update(['contact_id' => $email->contact_id,
                                'address' => $email->address,
                                'is_business' => $email->is_business]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAll(Request $request)
    {
        foreach($request->all() as $newEmail) {
            $email = Email::where('id', $newEmail['id'])->first();

            if ($email) {
                if ($newEmail['contact_id'] == null) {
                    $email->delete();
                } else {
                    $email->update(['contact_id' => $newEmail['contact_id'],
                                    'address' => $newEmail['address'],
                                    'is_business' => $newEmail['is_business']]);
                }
            } else {
                $email = new Email($newEmail);
                $email->save();
            }
        }

        return response('Emails updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Email  $email
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email $email)
    {
        return $email->delete();
    }

    public function validateEmail(Request $request)
    {
        return $request->validate([
            'address' => 'required|email',
            'is_business' => 'required',
            'contact_id' => 'exists:contacts,id'
        ]);
    }
}
