<?php

namespace App\Http\Controllers;

use App\Models\Rols;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\BinaryOp\Concat;

class RolsController extends Controller
{

    public function index(Request $request)
    {
        return response()->json([Rols::all()], 200);
    }

    public function store(Request $request)
    {
        if (Auth::user() &&  Auth::user()->rol_id == 1) {
            $rol = new Rols();
            $rol->name = $request->input('name');
            $rol->description = $request->input('description');
            $rol->save();
            return response()->json([
                'message' => 'Rol creado exitosamente',
                'res' => true
            ], 201);
        }
    }

    public function show($id)
    {
        $rol = Rols::find($id);
        if (!$rol) {
            return response()->json(['Rol no existente'], 404);
        }
        return response()->json([$rol], 200);
    }

    public function update(Request $request)
    {
        if (Auth::user() &&  Auth::user()->rol_id == 1) {
            $id = $request->input('id');
            $rol = Rols::find($id);
            if (!$rol) {
                return response()->json(['Rol no existente'], 404);
            }
            $rol->name = $request->input('name');
            $rol->description = $request->input('description');
            $rol->save();
            return response()->json([
                'message' => 'Rol actualizado exitosamente',
                'res' => true
            ], 200);
        }
    }

    public function destroy($id)
    {
        if (Auth::user() &&  Auth::user()->rol_id == 1) {
            $rol = Rols::find($id);
            if (!$rol) {
                return response()->json(['Rol no existente'], 404);
            }
            $rol->delete();
            return response()->json([
                'message' => 'Rol eliminado',
                $rol
            ], 200);
        }
    }
}
