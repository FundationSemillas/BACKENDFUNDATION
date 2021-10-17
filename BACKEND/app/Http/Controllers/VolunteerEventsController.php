<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Sponsors;
use App\Models\Volunteers;
use App\Models\VolunteersEvents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VolunteerEventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            VolunteersEvents::all()
        );
    }

    public function byVolunteer($id)
    {
        $events = DB::table('events')
            ->join('volunteers_events', 'events.id', '=', 'volunteers_events.event_id')
            ->where('volunteers_events.volunteer_id', '=', $id)
            ->get();
        return $events;
    }

    public function byEvent($id)
    {
        $volunteers = DB::table('volunteers')
            ->join('volunteers_events', 'volunteers.id', '=', 'volunteers_events.volunteer_id')
            ->where('volunteers_events.event_id', '=', $id)
            ->get();
        return $volunteers;
    }

    public function store(Request $request)
    {

        $data = $request->json()->all();

        $dataVolunteersEvents = $data['volunteerEvent'];
        $dataVolunteers = $data['volunteer'];
        $dataEvents = $data['event'];
        $volunteers = Volunteers::findOrFail($dataVolunteers['id']);
        $events = Events::findOrFail($dataEvents['id']);

        $volunteersEvents = new VolunteersEvents();
        $volunteersEvents->event()->associate($events);
        $volunteersEvents->volunteer()->associate($volunteers);
        $volunteersEvents->description =  $dataVolunteersEvents['description'];
        $volunteersEvents->save();

        return response()->json([
            'message' => 'Registro guardado exitosamente',
            'res' => true
        ], 201);
    }

    public function show(volunteersEvents $volunteersEvents)
    {
        $id = $volunteersEvents->id;
        $volunteersEvents = volunteersEvents::findOrFail($id);
        return response()->json(
            $volunteersEvents
        );
    }

    public function update(Request $request, $id)
    {
        $data = $request->json()->all();
        $dataVolunteersEvents = $data['sponsorEvent'];
        $id = $dataVolunteersEvents['id'];
        $volunteersEvents = volunteersEvents::findOrFail($id);
        $dataSponsors = $data['sponsor'];
        $dataEvents = $data['event'];
        $sponsors = Sponsors::findOrFail($dataSponsors['id']);
        $events = Events::findOrFail($dataEvents['id']);


        $volunteersEvents->event()->associate($events);
        $volunteersEvents->sponsor()->associate($sponsors);
        $volunteersEvents->description =  $dataVolunteersEvents['description'];
        $volunteersEvents->save();

        return response()->json(
            [
                'message' => 'Exito actualizando el registro',
                'res' => true
            ],
            200
        );
    }

    public function destroy(volunteersEvents $volunteersEvents, $id)
    {
        $volunteersEvents = volunteersEvents::findOrFail($id);
        $volunteersEvents->delete();
        return response()->json(['message' => 'volunteersEvents quitado', 'volunteersEvents' => $volunteersEvents], 200);
    }
}
