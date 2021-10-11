<?php

namespace App\Http\Controllers;
use App\Models\Albums;
use App\Models\Images;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json( images::all()
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
        $id = $request->get('id');
    
        if($request->hasFile('image'))
        {
            $files = $request->file('image');

            foreach ($files as $file) {
                // $imagen      = $file->file('image');
                $filename  = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $picture   = date('His').'-'.$filename;
               
                $path = $file->move('public/', $picture);
                $description = "imagen insertada";

                // $id= 21;
                $images = new Images();
                    print_r($picture);
                    $images->image =  $picture;
                    $images->type =  $extension;
                    $images->description =  $description;
                    $images->albums_id = $id;
                    $images->save();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\images  $images
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      $data = DB::table('images')->where('albums_id', $id)->get();
        return response()->json(
              $data
       );
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\images  $images
     * @return \Illuminate\Http\Response
     */
    public function edit(images $images)
    {
      //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\images  $images
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\images  $images
     * @return \Illuminate\Http\Response
     */
    public function destroy(images $images,$id)
    {
        $images = images::findOrFail($id);
        $idfk = $images['albums_id'];
        DB::table('images')->where('albums_id', $idfk)->delete();
        return response()->json(['message'=>'images quitado', 'images'=>$images],200);
    }
}
