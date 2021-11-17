<?php

namespace App\Http\Controllers;

use App\Models\Albums;
use App\Models\Events;
use Illuminate\Http\Request;

class AlbumController extends Controller
{
    public function index()
    {
        return response()->json(
            albums::all()
        );
    }

    public function store(Request $request)
    {
        $request->validate(['image' => 'mimes:jpeg,png,jpg,mp4']);
        //$data = request()->json()->all();
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $filename  = $file->getClientOriginalName();
            //$extension = $file->getClientOriginalExtension();
            $picture   = null;

            $path = $file->move('public/', $picture);
            $picture   = date('His') . '-' . $filename;

            $albumdata = json_decode($request->data, true);
            $event = Events::findOrFail($albumdata['event_id']);
            $albums = new Albums();
            $albums->title = $albumdata['title'];
            $albums->description = $albumdata['description'];
            $albums->date = $albumdata['date'];
            $albums->image = $picture;
            $albums->event()->associate($event);
            $albums->save();
            return response()->json([
                'message' => 'Albun creado exitosamente',
                'res' => true,
            ], 201);
        } else {
            return response()->json(
                [
                    'message' => 'Error al crear el album',
                    'res' => false
                ],
                400
            );
        }
    }

    public function show($id)
    {
        $albums = albums::findOrFail($id);
        return response()->json(
            $albums
        );
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();

        $albums = albums::findOrFail($data['id']);
        // $dataAlbums = $data['albums'];
        $events = Events::findOrFail($data['event_id']);

        $albums->title =  $data['title'];
        $albums->description =  $data['description'];
        $albums->date =  $data['date'];
        $albums->events()->associate($events);
        $albums->save();

        return response()->json([
            'message' => 'Albun actualizado exitosamente',
            'res' => true
        ], 201);
    }

    public function destroy($id)
    {
        $albums = albums::findOrFail($id);
        $albums->delete();
        return response()->json(['message' => 'album quitado', 'albums' => $albums], 200);
    }
}
