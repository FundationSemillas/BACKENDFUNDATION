<?php

namespace App\Http\Controllers;

use App\Models\Zones;
use Illuminate\Http\Request;

class ZonesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([Zones::all()], 200);
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
        $zones = new Zones();
        $zones->name = $request->input('name');
        $zones->save();
        return response()->json(['Guardado exitoso ', $zones], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zones  $zones
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $zone = Zones::find($id);
        if(!$zone){
            return response()->json(['Zona no encontrada'], 404);
        }
        return response()->json([$zone], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zones  $zones
     * @return \Illuminate\Http\Response
     */
    public function edit(Zones $zones)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Zones  $zones
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = $request->input('id');
        $zone = Zones::find($id);
        if(!$zone){
            return response()->json(['Zona no existente'], 404);
        }
        $zone->name = $request->input('name');
        $zone->save();
        return response()->json(['Zona actualizada ', $zone], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zones  $zones
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = Zones::find($id);
        if(!$delete){
            return response()->json(['Zona no existente'], 404);
        }
        $delete->delete();
        return response()->json(['Zona eliminada ', $delete], 200);
    }
}
