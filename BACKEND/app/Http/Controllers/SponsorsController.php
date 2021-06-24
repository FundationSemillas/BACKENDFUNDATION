<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sponsors;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SponsorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json( sponsors::all()
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
     
        if ($request->hasFile('image')){
            $file      = $request->file('image');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = date('His').'-'.$filename;
            $path = $file->storeAs('public/posts', $picture);

            $sponsorData = json_decode($request->data,true);
            $sponsorData["image"] =  $picture;

            $sponsors = new Sponsors();
            $data=$sponsors->addSponsor($sponsorData);
            var_dump($data);
            return response()->json([
                'data' => [
                    'Guardado'=>'Exitoso'
                ]
            ], 201);    
        }

     
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sponsors  $sponsors
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sponsors = sponsors::findOrFail($id);
        return response()->json(
              $sponsors
       );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sponsors  $sponsors
     * @return \Illuminate\Http\Response
     */
    public function edit(sponsors $sponsors)
    {
      //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sponsors  $sponsors
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->json()->all();

        $sponsors = sponsors::findOrFail($id);
        // $dataSponsors = $data['sponsors'];
       
        $sponsors->name =  $data['name'];
        $sponsors->description =  $data['description'];
        $sponsors->image =  $data['image'];
        $sponsors->save();

        return response()->json(
               $sponsors
        );
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sponsors  $sponsors
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sponsors = sponsors::findOrFail($id);
        $sponsors->delete();
        return response()->json(['message'=>'sponsor quitado', 'sponsors'=>$sponsors],200);
    }
}
