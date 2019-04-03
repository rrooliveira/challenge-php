<?php

namespace App\Http\Controllers;

use App\Address;
use App\People;
use Illuminate\Http\Request;

class AddressController extends Controller
{

    public function showAllAddress()
    {
        return response()->json(Address::all());
    }

    public function showOneAddress($id)
    {
        return response()->json(Address::find($id));
    }

    public function create(Request $request)
    {        
        $this->validate($request, [
            'idPerson'   => 'required',
            'postalCode' => 'required',
            'address'    => 'required',
            'number'     => 'required',
            'complement' => 'required',
            'state'      => 'required',
            'country'    => 'required'
        ]);


        $idPerson = (int)$request->idPerson;

        //Verify if the person exists on People table
        $truePerson = People::where('id',$idPerson)->count();

        if($truePerson){

            $data = [
                'idPerson'   => $idPerson,
                'postalCode' => $request->postalCode,
                'address'    => $request->address,
                'number'     => (int) $request->number,
                'complement' => $request->complement,
                'state'      => $request->state,
                'country'    => $request->country
            ];

            $address = Address::create($data);
            return response()->json($address, 201);
        }
    }

    public function update($id, Request $request)
    {
        $id = (int) $id;

        $address = Address::findOrFail($id);
        
        $address->update($request->all());

        return response()->json($address, 200);
    }

    public function delete($id)
    {
        $id = (int) $id;

        Address::findOrFail($id)->delete();
        
        //return response('Deleted Successfully', 200);
    }
}