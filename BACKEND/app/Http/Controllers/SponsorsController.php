<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sponsors;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Util\Json;

class SponsorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            sponsors::all()
        );
    }

    public function store(Request $request)
    {
        $request->validate(['image' => 'mimes:jpeg,png,jpg,svg']);
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $filename  = $file->getClientOriginalName();
            //$extension = $file->getClientOriginalExtension();
            $picture   = date('His') . '-' . $filename;
            $path = $file->move('public/', $picture);

            $sponsorData = json_decode($request->data, true);

            $sponsor = new Sponsors();
            $sponsor->name = $sponsorData['name'];
            $sponsor->description = $sponsorData['description'];
            $sponsor->image = $picture;
            $sponsor->save();
            return response()->json([
                'message' => 'Patrocinador creado exitosamente',
                'res' => true
            ], 201);
        }
    }

    public function show($id)
    {
        $sponsors = sponsors::findOrFail($id);
        return response()->json(
            $sponsors
        );
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();
        $id = $data['id'];
        $sponsors = sponsors::findOrFail($id);

        $sponsors->name =  $data['name'];
        $sponsors->description =  $data['description'];
        
        $sponsors->save();

        return response()->json(
            [
                'message' => 'Patrocinador actualizado exitosamente',
                'res' => true
            ]
        );
    }

    public function destroy($id)
    {
        $sponsors = sponsors::findOrFail($id);
        $sponsors->delete();
        return response()->json([
            'message' => 'Patrocinador eliminado',
            'sponsors' => $sponsors
        ], 200);
    }
}
