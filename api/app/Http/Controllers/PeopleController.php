<?php

namespace App\Http\Controllers;

use App\People;
use App\Address;
use Illuminate\Http\Request;

class PeopleController extends Controller
{

    public function showAllPeople()
    {
        return response()->json(People::all());
    }

    public function showAllWithAddress()
    {
        
        $result = People
                ::leftjoin('Addresses','People.id','=','Addresses.idPerson')
                ->select('People.id','People.name', 'People.lastName', 'People.birthDate', 'Addresses.id as id_Address','Addresses.postalCode', 'Addresses.address','Addresses.complement','Addresses.state', 'Addresses.country')
                ->getQuery()
                ->get();
        
        $arrayPerson = $this->convertToArray($result);
      
        return response()->json($arrayPerson);
    }

    public function showOnePeople($id)
    {
        return response()->json(People::find($id));
    }

    public function showOnePeopleWithAddress($id)
    {
        $id = (int) $id;

        $result = People
                ::leftjoin('Addresses','People.id','=','Addresses.idPerson')
                ->select('People.id','People.name', 'People.lastName', 'People.birthDate', 'Addresses.id as id_Address','Addresses.postalCode', 'Addresses.address','Addresses.complement','Addresses.state', 'Addresses.country')
                ->where('People.id',$id)
                ->getQuery()
                ->get();
           
        $arrayPerson = $this->convertToArray($result);
      
        return response()->json($arrayPerson);
    }



    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'lastName' => 'required',
            'birthDate' => 'required'
        ]);

        $people = People::create($request->all());

        return response()->json($people, 201);
    }

    public function update($id, Request $request)
    {
        $id = (int) $id;

        if(!Empty($request->name) || !Empty($request->lastName) || !Empty($request->birthDate))
        {

            $people = People::findOrFail($id);
            
            $people->update($request->all());

            return response()->json($people, 200);
        }
    }

    public function delete($id)
    {
        $id = (int) $id;

        //Verify if the person has Address
        $hasAddress = Address::where('idPerson',$id)->count();

        if(!$hasAddress){
            People::findOrFail($id)->delete();
        }else{
            return response()->json(['Error' => 'You have to delete the Address before!'], 200);
        }
    }

    protected function convertToArray($result)
    {
        $arrayPerson = null;
        $idPerson = null;       
        
        $i = 0;
        foreach ($result as $data){
            if($data->id != $idPerson){
                $arrayPerson[$data->id]['id']                        = $data->id;
                $arrayPerson[$data->id]['name']                      = $data->name;
                $arrayPerson[$data->id]['lastname']                  = $data->lastName;
                $arrayPerson[$data->id]['birthDate']                 = $data->birthDate;
                $arrayPerson[$data->id]['Address'][$i]['id']         = $data->id_Address;
                $arrayPerson[$data->id]['Address'][$i]['postalCode'] = $data->postalCode;
                $arrayPerson[$data->id]['Address'][$i]['address']    = $data->address;
                $arrayPerson[$data->id]['Address'][$i]['complement'] = $data->complement;
                $arrayPerson[$data->id]['Address'][$i]['state']      = $data->state;
                $arrayPerson[$data->id]['Address'][$i]['country']    = $data->country;
            }else{
                $arrayPerson[$data->id]['Address'][$i]['id']         = $data->id_Address;
                $arrayPerson[$data->id]['Address'][$i]['postalCode'] = $data->postalCode;
                $arrayPerson[$data->id]['Address'][$i]['address']    = $data->address;
                $arrayPerson[$data->id]['Address'][$i]['address']    = $data->address;
                $arrayPerson[$data->id]['Address'][$i]['complement'] = $data->complement;
                $arrayPerson[$data->id]['Address'][$i]['state']      = $data->state;
                $arrayPerson[$data->id]['Address'][$i]['country']    = $data->country;
            }

            $i++;
            $idPerson = $data->id;
        }
        return $arrayPerson;
    }
}