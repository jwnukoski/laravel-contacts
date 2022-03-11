<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return Position::create($request);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Address  $address
     * @return \Illuminate\Http\Response
     */
    public function update(Position $position)
    {
        if ($position) {
            return $position->update(['contact_id' => $position->contact_id,
                                        'department_id' => $position->department_id,
                                        'title' => $position->title,
                                        'is_liason' => $position->is_liason]); 
        }

        $position = new Position($position);
        return $position->save();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function updateContact(Request $request)
    {
        $newPositionReq = $request->position;
        if (!isset($newPositionReq['id'])) {
            return response('No position assigned to contact to update', 200);
        }
        
        $currentPosition = Position::where('contact_id', $request['id'])->first();
        if ($currentPosition && ($currentPosition['id'] != $newPositionReq['id'])) {
            $currentPosition->update(['contact_id' => null, 
            'is_liason' => false]);
        }
        
        //$validated = $this->validatePosition($newPositionReq);
        $newPosition = Position::where('id', $newPositionReq['id']);
        return $newPosition->update(['contact_id' => $request['id'], 
                                        'is_liason' => $newPositionReq['is_liason']]);
    }

    public function updateAll(Request $request)
    {
        foreach($request->all() as $newPosition) {
            $position = Position::where('id', $newPosition['id'])->first();

            if ($position) {
                if ($newPosition['department_id'] == null) {
                    $position->delete();
                } else {
                    $position->update(['contact_id' => $newPosition['contact_id'],
                                        'department_id' => $newPosition['department_id'],
                                        'title' => $newPosition['title'],
                                        'is_liason' => $newPosition['is_liason']]);
                }
            } else {
                $position = new Position($newPosition);
                $position->save();
            }
        }

        return response('Positions updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy(Position $position)
    {
        return $position->delete();
    }

    public function validatePosition(Request $request)
    {
        return $request->validate([
            'title' => 'required|min:2|max:64',
            'is_liason' => 'required',
            'contact_id' => 'exists:contacts,id',
            'department_id' => 'exists:departments,id'
        ]);
    }
}
