<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            blogs::all()
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
        $dataBlog = $data['blogs'];
        $blogs = new Blogs();
        $blogs->title =  $dataBlog['title'];
        $blogs->description =  $dataBlog['description'];
        $blogs->image =  $dataBlog['image'];
        $blogs->link =  $dataBlog['link'];
        $blogs->save();
        return response()->json([
            'data' => [
                'Guardado' => 'Exitoso'
            ]
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blogs = Blogs::findOrFail($id);
        return response()->json(
            $blogs
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function edit(blogs $blogs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->json()->all();
        $blogs = Blogs::findOrFail($id);
        $dataBlog = $data['blogs'];
        $blogs->title =  $dataBlog['title'];
        $blogs->description =  $dataBlog['description'];
        $blogs->image =  $dataBlog['image'];
        $blogs->link =  $dataBlog['link'];
        $blogs->save();
        return response()->json([
            'data' => [
                'Actualizado' => 'Exitoso'
            ]
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\blogs  $blogs
     * @return \Illuminate\Http\Response
     */
    public function destroy(blogs $blogs, $id)
    {
        $blogs = blogs::findOrFail($id);
        $blogs->delete();
        return response()->json(['Message' => 'Eliminado'], 201);
    }

    public function imageStore(Request $request)
    {
        //falta probar
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . $file->getClientOriginalName();
            $file->move(public_path() . '/images/', $name);
        }
        $blogs = new blogs;
        $blogs->image = $name;
        $blogs->save();
    }
}