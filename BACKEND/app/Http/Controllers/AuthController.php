<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = User::whereEmail($request->input('email'))->first();
            
            if (!is_null($user) && Hash::check($request->input('password'), $user->password)) {

                $token = $user->createToken('app')->accessToken;
                $user->api_token = $token;
                $user->save();
                return response([
                    'message' => 'Inicio de sesión exitoso',
                    'token' => $user->api_token
                ], 201);
            }
        } catch (\Exception $exception) {
            return response([
                'message' => 'Error al iniciar sesión',

            ], 400);
        }
        return response([
            'message' => 'Error al iniciar sesión',
        ], 401);
    }

    public function user()
    {
        return Auth::user();
    }

    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->last_name = $request->input('lastName');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->permission = $request->input('permission');
        $user->rol_id = $request->input('rol_id');
        $user->save();
        return response()->json(['Usuario creado exitosamente'], 201);
    }

    public function logout(Request $request){
        $user = $request->user();
        $id = $user->id;
        $userDb = User::find($id);
        if(!$userDb){
            return response()->json(['Usuario no encontrado'], 404);
        }
        $userDb->api_token = null;
        $userDb->save();
        return response()->json(['Cierre de sesión exitoso'], 200);
    }
}
