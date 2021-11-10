<?php

namespace App\Http\Controllers;
use App\Models\Albums;
use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class ImageController extends Controller
{

    public function index()
    {
        return response()->json( images::all()
       );
    }

    public function store(Request $request)
    {
        $id = $request->get('id');
        $album = Albums::findOrFail($id);
        //$request->validate(['image' => 'mimes:jpeg,png,jpg,mp4']);
        if($request->hasFile('image'))
        {
            $files = $request->file('image');

            foreach ($files as $file) {
                // $imagen      = $file->file('image');
                $filename  = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $picture   = null;
                if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'mp4') {
                    $picture   = date('His') . '-' . $filename;
                    $path = $file->move('public/', $picture);
                }
                $description = "imagen insertada";
                // $id= 21;
                $images = new Images();
                    print_r($picture);
                    $images->image =  $picture;
                    $images->type =  $extension;
                    $images->description =  $description;
                    $images->album()->associate($album);
                    $images->save();
            }
        }
    }

    public function show($id)
    {
      $data = DB::table('images')->where('albums_id', $id)->get();
        return response()->json(
              $data
       );
    }

    public function update(Request $request, $id)
    {
        $data = $request->json()->all();
        
        $images = images::findOrFail($id);
        $dataImages = $data['image'];
        $dataAlbums = $data['album'];
        $album = Albums::findOrFail($dataAlbums['id']);
        $images->image =  $dataImages['image'];
        $images->type =  $dataImages['type'];
        $images->description =  $dataImages['description'];
        $images->album()->associate($album);
        $images->save();

        return response()->json(
               $images
        );
        
    }

    public function destroy($id)
    {
        $images = images::findOrFail($id);
        $idfk = $images['albums_id'];
        DB::table('images')->where('albums_id', $idfk)->delete();
        return response()->json(['message'=>'images quitado', 'images'=>$images],200);
    }
}
