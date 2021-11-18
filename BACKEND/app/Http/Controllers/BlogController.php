<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BlogController extends Controller
{
    public function index()
    {
        return response()->json(
            blogs::all()
        );
    }

    public function store(Request $request)
    {
        $mensaje = 'Blog creado exitosamente';
        $blogdata = json_decode($request->data, true);
        //$request->validate(['image' => 'mimes:jpeg,png,jpg,mp4']);
        if ($request->hasFile('image')) {
            $file      = $request->file('image');
            $filename  = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $picture   = null;

            if ($extension == 'png' || $extension == 'jpg' || $extension == 'jpeg' || $extension == 'mp4') {
                $picture   = date('His') . '-' . $filename;
                $path = $file->move('public/', $picture);
            } else {
                $mensaje = 'El blog se creo pero el tipo de archivo no es aceptado por lo tanto no se guardo el archivo';
            }

            $blog = new Blogs();
            $blog->title = $blogdata['title'];
            $blog->description = $blogdata['description'];
            $blog->image = $picture;
            $blog->link = $blogdata['link']; 
            $blog->save();
            return response()->json([
                'message' => $mensaje,
                'res' => true,
            ], 201);
        } else {
            $blog = new Blogs();
            $blog->title = $blogdata['title'];
            $blog->description = $blogdata['description'];
            $blog->image = null;
            $blog->link = $blogdata['link'];
            $blog->save(); 
            return response()->json([
                'message' => $mensaje,
                'res' => true
            ], 201);
        }
    }

    public function show($id)
    {
        $blogs = Blogs::findOrFail($id);
        return response()->json(
            $blogs
        );
    }

    public function update(Request $request)
    {
        $data = $request->json()->all();
        $id = $request->input('id');
        $blogs = Blogs::findOrFail($id);

        $blogs->title =  $data['title'];
        $blogs->description =  $data['description'];
        $blogs->link = $data['link'];
        $blogs->save();
        return response()->json([
            'message' => 'Blog actualizado exitosamente',
            'res' => true
        ], 200);
    }

    public function destroy(blogs $blogs, $id)
    {
        $blogs = blogs::findOrFail($id);
        $blogs->delete();
        return response()->json([
            'message' => 'Blog eliminado',
            'res' => true
        ], 201);
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
