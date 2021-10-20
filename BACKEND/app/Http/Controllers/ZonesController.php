<?php

namespace App\Http\Controllers;

use App\Models\Zones;
use Illuminate\Http\Request;

class ZonesController extends Controller
{
    public function index()
    {
        return response()->json([Zones::all()], 200);
    }

    public function store(Request $request)
    {
        $zones = new Zones();
        $zones->name = $request->input('name');
        $zones->save();
        return response()->json([
            'message' => 'Zona o sector guardado exitosamente',
            'res' => true
        ], 201);
    }

    public function show($id)
    {
        $zone = Zones::find($id);
        if (!$zone) {
            return response()->json(['Zona no encontrada'], 404);
        }
        return response()->json([$zone], 200);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $zone = Zones::find($id);
        if (!$zone) {
            return response()->json(['Zona no existente'], 404);
        }
        $zone->name = $request->input('name');
        $zone->save();
        return response()->json([
            'message' => 'Zona o sector actualizado exitosamente',
            'res' => true
        ], 200);
    }

    public function destroy($id)
    {
        $delete = Zones::find($id);
        if (!$delete) {
            return response()->json(['Zona no existente'], 404);
        }
        $delete->delete();
        return response()->json([
            'message' => 'Zona o sector eliminado exitosamente',
            'res' => true
        ], 200);
    }
}
