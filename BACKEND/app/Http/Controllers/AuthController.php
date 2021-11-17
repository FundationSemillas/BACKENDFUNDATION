<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ServiceSemillas;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            $user = User::whereEmail($request->input('email'))->first();
            
            if (!is_null($user) && Hash::check($request->input('password'), $user->password)) {

                if ($user->email_verified_at) {
                    $token = $user->createToken('app')->accessToken;
                    $user->api_token = $token;
                    $user->save();
                    return response([
                    'message' => 'Inicio de sesión exitoso',
                    'token' => $user->api_token
                    ], 201);
                   }else {
                    return response([
                        'message' => 'Correo no validado',
                    ], 200);
                } 

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

        Mail::to($user->email)->send(new ServiceSemillas($user->id));


        return response()->json(['Usuario creado'], 201);
    }
}
