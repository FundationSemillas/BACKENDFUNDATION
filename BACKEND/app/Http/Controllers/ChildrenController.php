<?php

namespace App\Http\Controllers;

use App\Models\Children;
use Illuminate\Http\Request;

class ChildrenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json( children::all()
       );
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
     
        $data = $request->json()->all();
        
        $dataPerson = $data['children'];

        $children = new Children();
        $children->name =  $dataPerson['name'];
        $children->surname =  $dataPerson['surname'];
        $children->dateBirth =  $dataPerson['dateBirth'];
        $children->age =  $dataPerson['age'];
        $children->CI =  $dataPerson['CI'];
        $children->mothersName =  $dataPerson['mothersName'];
        $children->fathersName =  $dataPerson['fathersName'];
        $children->study =  $dataPerson['study'];
        $children->houseAddress =  $dataPerson['houseAddress'];
        $children->schoolName = $dataPerson['schoolName'];
        $children->image =  $dataPerson['image'];
        $children->save();

        return response()->json([
        'data' => [
            'Guardado'=>'Exitoso'
        ]
    ], 201);        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\children  $children
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $children = children::findOrFail($id);
        return response()->json(
              $children
       );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\children  $children
     * @return \Illuminate\Http\Response
     */
    public function edit(children $children)
    {
      //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\children  $children
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $children = children::findOrFail($id);
        $children->name = $request->input('name');
        $children->surname = $request->input('surname');
        $children->dateBirth = $request->input('dateBirth');
        $children->age = $request->input('age');
        $children->CI = $request->input('CI');
        $children->mothersName = $request->input('mothersName');
        $children->fathersName = $request->input('fathersName');
        $children->study = $request->input('study');
        $children->houseAddress = $request->input('houseAddress');
        $children->schoolName = $request->input('schoolName');
        $children->image = $request->input('image');

        $children->save();
        return response()->json(
               $children
        );
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\children  $children
     * @return \Illuminate\Http\Response
     */
    public function destroy(children $children,$id)
    {
        $children = children::findOrFail($id);
        $children->delete();
        return response()->json(['message'=>'Persona quitada', 'Persona'=>$children],200);
    }
}
