<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){
        try{
        if(Auth::attempt($request->only('email', 'password'))){
            /** @var user $user */
            $user = Auth::user();
            $token = $user->createToken('app')->accessToken;

            return response([
                'message'=> 'success',
                'token'=> $token,
                'user'=> $user
            ], 201);
        }
       
        
    }catch (\Exception $exception){
        return response([
            'message'=> $exception->getMessage(),
            
        ], 400);
    }
    return response([
        'message'=> 'invalid username/password',  
    ], 401);
    }

    public function user(){
        return Auth::user();
    }

    public function register(Request $request){
        $register = new User();
        $register->name = $request->input('name');
        $register->last_name = $request->input('last_name');
        $register->email = $request->input('email');
        $register->password = Hash::make($request->input('password'));
        $register->save();
        return $register;
      }
}
