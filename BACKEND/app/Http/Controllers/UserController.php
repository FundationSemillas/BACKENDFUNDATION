<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
  public function user(Request $request)
  {
    return $request->user();
  }

  public function index()
  {
    return User::all();
  }

  public function store(Request $request)
  {
    $user = new User();
    $user->name = $request->input('name');
    $user->last_name = $request->input('lastName');
    $user->email = $request->input('email');
    $user->password = Hash::make($request->input('password'));
    $user->permission = $request->input('permission');
    $user->rol_id = $request->input('rolId');
    $user->save();
    return response()->json(['Usuario creado exitosamente'], 201);
  }

  public function show($id)
  {
    $user = user::findOrFail($id);
    return response()->json(
      $user
    );
  }

  public function update(Request $request, $id)
  {
    $data = $request->json()->all();
    $user = user::findOrFail($id);
    $user->name =  $data['name'];
    $user->last_name =  $data['last_name'];
    //$user->email =  $data['email'];
    $user->password =  Hash::make($data['password']);
    $user->save();
    return response()->json([
      'data' => [
        'Actualizado' => 'Exitoso'
      ]
    ], 201);
  }

  public function destroy($id)
  {
    $user = user::findOrFail($id);
    $user->delete();
    return response()->json(['message' => 'Usuario Eliminado', 'usuarios' => $user], 200);
  }
}
