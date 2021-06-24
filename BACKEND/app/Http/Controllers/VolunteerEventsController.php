<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VolunteerEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json( volunteersEvents::all()
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
        
        $dataVolunteersEvents = $data['volunteersEvents'];
        $dataVolunteers = $data['volunteers'];
        $dataEvents = $data['events'];
        $volunteers = Volunteers::findOrFail($dataVolunteers['id']);
        $events = Events::findOrFail($dataEvents['id']);
        
        $volunteersEvents = new VolunteersEvents();
        $volunteersEvents->event()->associate($events);
        $volunteersEvents->volunteer()->associate($volunteers);
        $volunteersEvents->description =  $dataVolunteersEvents['description'];
        $volunteersEvents->save();

        return response()->json([
        'data' => [
            'Guardado'=>'Exitoso'
        ]
    ], 201);        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\volunteersEvents  $volunteersEvents
     * @return \Illuminate\Http\Response
     */
    public function show(volunteersEvents $volunteersEvents)
    {
        $volunteersEvents = volunteersEvents::findOrFail($id);
        return response()->json(
              $volunteersEvents
       );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\volunteersEvents  $volunteersEvents
     * @return \Illuminate\Http\Response
     */
    public function edit(volunteersEvents $volunteersEvents)
    {
      //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\volunteersEvents  $volunteersEvents
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->json()->all();
        
        $volunteersEvents = volunteersEvents::findOrFail($id);
        $dataVolunteersEvents = $data['sponsorsEvents'];
        $dataSponsors = $data['sponsors'];
        $dataEvents = $data['events'];
        $sponsors = Sponsors::findOrFail($dataEvents['id']);
        $events = Events::findOrFail($dataEvents['id']);
        

        $volunteersEvents->event()->associate($events);
        $volunteersEvents->sponsor()->associate($sponsors);
        $volunteersEvents->description =  $dataVolunteersEvents['description'];
        $volunteersEvents->save();

        return response()->json(
               $volunteersEvents
        );
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\volunteersEvents  $volunteersEvents
     * @return \Illuminate\Http\Response
     */
    public function destroy(volunteersEvents $volunteersEvents,$id)
    {
        $volunteersEvents = volunteersEvents::findOrFail($id);
        $volunteersEvents->delete();
        return response()->json(['message'=>'volunteersEvents quitado', 'volunteersEvents'=>$volunteersEvents],200);
    }
}
