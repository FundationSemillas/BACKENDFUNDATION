<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Sponsors;
use App\Models\SponsorsEvents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SponsorsEventsController extends Controller
{
    public function index()
    {
        return response()->json(
            SponsorsEvents::all()
        );
    }

    public function bySponsor($id)
    {
        $events = DB::table('events')
            ->join('sponsors_events', 'events.id', '=', 'sponsors_events.event_id')
            ->where('sponsors_events.sponsor_id', '=', $id)
            ->get();
        return $events;
    }

    public function byEvent($id)
    {
        $sponsors = DB::table('sponsors')
            ->join('sponsors_events', 'sponsors.id', '=', 'sponsors_events.sponsor_id')
            ->where('sponsors_events.event_id', '=', $id)
            ->get();
        return $sponsors;
    }

    public function store(Request $request)
    {

        $data = $request->json()->all();

        $dataSponsorEvents = $data['sponsorEvent'];
        $dataSponsors = $data['sponsor'];
        $dataEvents = $data['event'];
        $sponsors = Sponsors::findOrFail($dataSponsors['id']);
        $events = Events::findOrFail($dataEvents['id']);

        $sponsorEvents = new SponsorsEvents();
        $sponsorEvents->event()->associate($events);
        $sponsorEvents->sponsor()->associate($sponsors);
        $sponsorEvents->description = $dataSponsorEvents['description'];
        $sponsorEvents->save();

        return response()->json([
            'message' => 'Exito al guardar',
            'res' => true
        ], 201);
    }

    public function show(SponsorsEvents $sponsorEvents)
    {
        $id = $sponsorEvents->id;
        $sponsorEvents = SponsorsEvents::findOrFail($id);
        return response()->json(
            $sponsorEvents
        );
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();
        $dataSponsorEvents = $data['sponsorEvent'];
        $id = $dataSponsorEvents['id'];
        $sponsorEvents = SponsorsEvents::findOrFail($id);
        
        $dataSponsors = $data['sponsor'];
        $dataEvents = $data['event'];
        $sponsors = Sponsors::findOrFail($dataSponsors['id']);
        $events = Events::findOrFail($dataEvents['id']);

        $sponsorEvents->event()->associate($events);
        $sponsorEvents->sponsor()->associate($sponsors);
        $sponsorEvents->description =  $dataSponsorEvents['description'];
        $sponsorEvents->save();

        return response()->json(
            [
                'message' => 'Exito al actualizar',
                'res' => true
            ]
        );
    }

    public function destroy(SponsorsEvents $sponsorEvents, $id)
    {
        $sponsorEvents = SponsorsEvents::findOrFail($id);
        $sponsorEvents->delete();
        return response()->json([
            'message' => 'Registro eliminado',
            'sponsorEvents' => $sponsorEvents
        ], 200);
    }
}
