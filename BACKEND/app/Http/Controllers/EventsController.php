<?php

namespace App\Http\Controllers;
use App\Models\Events;
use App\Models\Blogs;
use Illuminate\Http\Request;


class EventsController extends Controller
{
     public function index(){
        return response()->json(events::all()
     );
    }

    public function show(){
        //
    }

    public function store(Request $request){
        $data = $request->json()->all();
        
        $dataEvents = $data['events'];
        $dataBlogs = $data['blogs'];
        $blogs = Blogs::findOrFail($dataBlogs['id']);
       

        $events = new Events();
        $events->name =  $dataEvents['name'];
        $events->description =  $dataEvents['description'];
        $events->place =  $dataEvents['place'];
        $events->date =  $dataEvents['date'];
        $events->hour =  $dataEvents['hour'];
        $events->delay =  $dataEvents['delay'];
        $events->blog()->associate($blogs);
       

        $events->save();
        return response()->json([
            'data' => [
                'Guardado'=>'Exitoso'
            ]
        ], 201);  
    }

    public function update(Resquest $request, $id){
        $data = $request->json()->all();
        $events = blog::findOrFail($id);
        $dataEvents = $data['events'];
       
        $events->name =  $dataEvents['name'];
        $events->description =  $dataEvents['description'];
        $events->place =  $dataEvents['place'];
        $events->date =  $dataEvents['date'];
        $events->hour =  $dataEvents['hour'];
        $events->delay =  $dataEvents['delay'];
       

        $events->save();
        return response()->json([
            'data' => [
                'Actualizado'=>'Exitoso'
            ]
        ], 201);  
    }

    public function destroy(){
        $events = Events::findOrFail($id);
        $events->delete();
        return response()->json(['Eliminado'=>'Exitoso'],201);
    }

    public function edit(){
        //
    }


}
