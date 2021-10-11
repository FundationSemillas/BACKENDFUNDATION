<?php

namespace App\Http\Controllers;

use App\Models\Rols;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\BinaryOp\Concat;

class RolsController extends Controller
{

    public function index()
    {
        return response()->json([Rols::all()], 200);
    }

    public function store(Request $request)
    {
        $rol = new Rols();
        $rol->name = $request->input('name');
        $rol->description = $request->input('description');
        $rol->save();
        return response()->json(['Rol guardado ', $rol], 201);
    }

    public function show($id)
    {
        $rol = Rols::find($id);
        if(!$rol){
            return response()->json(['Rol no existente'], 404);
        }
        return response()->json([$rol], 200);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $rol = Rols::find($id);
        if(!$rol){
            return response()->json(['Rol no existente'], 404);
        }
        $rol->name = $request->input('name');
        $rol->description = $request->input('description');
        $rol->save();
        return response()->json(['Rol actualizado ', $rol], 200);
    }

    public function destroy($id)
    {
        $rol = Rols::find($id);
        if(!$rol){
            return response()->json(['Rol no existente'], 404);
        }
        $rol->delete();
        return response()->json(['Rol eliminado ' , $rol], 200);
    }
}
