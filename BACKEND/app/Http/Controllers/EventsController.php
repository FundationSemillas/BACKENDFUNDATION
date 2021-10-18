<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Blogs;
use App\Models\User;
use Faker\Core\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventsController extends Controller
{
    public function index()
    {
        return response()->json(
            events::all()
        );
    }

    public function store(Request $request)
    {
        $data = $request->json()->all();

        $dataEvents = $data['data'];
        $dataBlog = $dataEvents['blog_id'];
        $dataUser = $dataEvents['user_id'];
        $blog = Blogs::find($dataBlog);
        $user = User::find($dataUser);

        $events = new Events();
        $events->name =  $dataEvents['name'];
        $events->description =  $dataEvents['description'];
        $events->place =  $dataEvents['place'];
        $events->date =  $dataEvents['date'];
        $events->hour =  $dataEvents['hour'];
        $events->delay =  $dataEvents['delay'];
        $events->blog()->associate($blog);
        $events->user()->associate($user);
        $events->save();

        return response()->json([
            'message' => 'Evento creado exitosamente',
            'res' => true
        ], 201);
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();
        //$dataEvents = $data['data'];
        $events = Events::findOrFail($data['id']);

        $events->name =  $data['name'];
        $events->description =  $data['description'];
        $events->place =  $data['place'];
        $events->date =  $data['date'];
        $events->hour =  $data['hour'];
        $events->delay =  $data['delay'];

        $events->save();
        return response()->json([
            'message' => 'Evento actualizado exitosamente',
            'res' => true
        ], 200);
    }

    public function destroy($id)
    {
        $events = Events::findOrFail($id);
        $events->delete();
        return response()->json([
            'message' => 'Evento eliminado',
            'Evento' => $events
        ], 200);
    }

    public function byBlog($id)
    {
        $events = DB::table('events')
            ->where('blog_id', '=', $id)
            ->get();
        return response()->json(
            $events
        , 200);
    }
}
