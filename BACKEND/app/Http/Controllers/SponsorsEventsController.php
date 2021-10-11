<?php

namespace App\Http\Controllers;
use App\Models\Events;
use App\Models\Sponsors;
use App\Models\SponsorsEvents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SponsorsEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json( SponsorsEvents::all()
       );
    }

    public function bySponsor($id){
        $events = DB::table('events')
            ->join('sponsorsEvents', 'events.id', '=', 'sponsorsEvents.events_id')
            ->where('sponsorsEvents.sponsors_id', '=', $id)
            ->get();
        return $events;
    }

    public function byEvent($id){
        $sponsors = DB::table('sponsors')
        ->join('sponsorsEvents', 'sponsors.id', '=', 'sponsorsEvents.sponsors_id')
        ->where('sponsorsEvents.events_id', '=', $id)
        ->get();
        return $sponsors;
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
    public function show(SponsorsEvents $sponsorEvents)
    {
        $id = $sponsorEvents->id;
        $sponsorEvents = SponsorsEvents::findOrFail($id);
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
    public function edit(SponsorsEvents $sponsorEvents)
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
        
        $sponsorEvents = SponsorsEvents::findOrFail($id);
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
    public function destroy(SponsorsEvents $sponsorEvents,$id)
    {
        $sponsorEvents = SponsorsEvents::findOrFail($id);
        $sponsorEvents->delete();
        return response()->json(['message'=>'sponsorEvents quitado', 'sponsorEvents'=>$sponsorEvents],200);
    }
}
