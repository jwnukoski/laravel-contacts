<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        return Address::find($address);
    }

    public function showAllByContactId($contact_id)
    {
        return Address::where($contact_id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Address $address)
    {
        return $address->update($this->validateAddress(request())); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAll(Request $request)
    {
        foreach($request->all() as $newAddress) {
            $address = Address::where('id', $newAddress['id'])->first();

            if ($address) {
                if ($newAddress['contact_id'] == null) {
                    $address->delete();
                } else {
                    $address->update(['contact_id' => $newAddress['contact_id'],
                                        'line_1' => $newAddress['line_1'],
                                        'line_2' => $newAddress['line_2'],
                                        'city' => $newAddress['city'],
                                        'state' => $newAddress['state'],
                                        'zip' => $newAddress['zip'],
                                        'is_business' => $newAddress['is_business']]);
                }
            } else {
                $address = new Address($newAddress);
                $address->save();
            }
        }

        return response('Addresses updated', 200);
    }

    public function zipLookup($zip)
    {
        $zip = intval($zip);

        $smartyStreetsAuthId = $_ENV['SMARTYSTREETS_AUTH_ID'] ?? '';
        $smartyStreetsTokenId = $_ENV['SMARTYSTREETS_AUTH_TOKEN'] ?? '';
        $url = 'https://us-zipcode.api.smartystreets.com/lookup?auth-id='.$smartyStreetsAuthId.'&auth-token='.$smartyStreetsTokenId.'&zipcode='.$zip;

        $smartyStreetsResponse = file_get_contents($url);

        if($smartyStreetsResponse !== false) {
            return response($smartyStreetsResponse, 200);
        } else {
            return response('Error validating zipcode', 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        return $address->delete();
    }

    public function validateAddress(Request $request)
    {
        return $request->validate([
            'line_1' => 'required|min:2|max:64',
            'line_2' => 'nullable|min:2|max:64',
            'city' => 'required|min:2|max:64',
            'state' => 'required|min:2|max:64',
            'zip' => 'required|min:5'
        ]);
    }
}
