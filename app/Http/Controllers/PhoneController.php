<?php

namespace App\Http\Controllers;

use App\Models\Phone;
use Illuminate\Http\Request;

class PhoneController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Phone  $Phone
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Phone::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Phone  $Phone
     * @return \Illuminate\Http\Response
     */
    public function update(Phone $phone)
    {
        return $phone->update(['contact_id' => $phone->contact_id,
                                'number' => $phone->number,
                                'is_business' => $phone->is_business]); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAll(Request $request)
    {
        foreach($request->all() as $newPhone) {
            $phone = Phone::where('id', $newPhone['id'])->first();

            if ($phone) {
                if ($newPhone['contact_id'] == null) {
                    $phone->delete();
                } else {
                    $phone->update(['contact_id' => $newPhone['contact_id'],
                                    'number' => $newPhone['number'],
                                    'is_business' => $newPhone['is_business']]);
                }
            } else {
                $phone = new Phone($newPhone);
                $phone->save();
            }
        }

        return response('Phone numbers updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Phone  $Phone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Phone $phone)
    {
        return $phone->delete();
    }

    public function validatePhone(Request $request)
    {
        return $request->validate([
            'number' => 'required|min:12|max:12',
            'is_business' => 'required',
            'contact_id' => 'exists:contacts,id'
        ]);
    }
}
