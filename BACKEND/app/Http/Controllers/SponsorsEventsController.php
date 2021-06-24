<?php

namespace App\Http\Controllers;
use App\Models\Events;
use App\Models\Sponsors;
use Illuminate\Http\Request;

class SponsorsEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json( sponsorEvents::all()
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
        
        $dataSponsorEvents = $data['sponsorsEvents'];
        $dataSponsors = $data['sponsors'];
        $dataEvents = $data['events'];
        $sponsors = Sponsors::findOrFail($dataEvents['id']);
        $events = Events::findOrFail($dataEvents['id']);
        
        $sponsorEvents = new SponsorsEvents();
        $sponsorEvents->event()->associate($events);
        $sponsorEvents->sponsor()->associate($sponsors);
        $sponsorEvents->description =  $dataSponsorEvents['description'];
        $sponsorEvents->save();

        return response()->json([
        'data' => [
            'Guardado'=>'Exitoso'
        ]
    ], 201);        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\sponsorEvents  $sponsorEvents
     * @return \Illuminate\Http\Response
     */
    public function show(sponsorEvents $sponsorEvents)
    {
        $sponsorEvents = sponsorEvents::findOrFail($id);
        return response()->json(
              $sponsorEvents
       );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\sponsorEvents  $sponsorEvents
     * @return \Illuminate\Http\Response
     */
    public function edit(sponsorEvents $sponsorEvents)
    {
      //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\sponsorEvents  $sponsorEvents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->json()->all();
        
        $sponsorEvents = sponsorEvents::findOrFail($id);
        $dataSponsorEvents = $data['sponsorsEvents'];
        $dataSponsors = $data['sponsors'];
        $dataEvents = $data['events'];
        $sponsors = Sponsors::findOrFail($dataEvents['id']);
        $events = Events::findOrFail($dataEvents['id']);
        

        $sponsorEvents->event()->associate($events);
        $sponsorEvents->sponsor()->associate($sponsors);
        $sponsorEvents->description =  $dataSponsorEvents['description'];
        $sponsorEvents->save();

        return response()->json(
               $sponsorEvents
        );
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\sponsorEvents  $sponsorEvents
     * @return \Illuminate\Http\Response
     */
    public function destroy(sponsorEvents $sponsorEvents,$id)
    {
        $sponsorEvents = sponsorEvents::findOrFail($id);
        $sponsorEvents->delete();
        return response()->json(['message'=>'sponsorEvents quitado', 'sponsorEvents'=>$sponsorEvents],200);
    }
}
