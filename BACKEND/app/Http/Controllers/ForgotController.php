<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class ForgotController extends Controller
{
 public function forgot(Request $request){
     $email = new User();
     $email =  $request->input('email');
     if(User::where('email', $email)->doesntExist()){
         return response([
             'message'=> 'Usuario no existente'
         ],404);
        }
     $token = Str::random(10);
     try{
     DB::table('password_resets')->insert([
         'email'=> $email,
         'token'=> $token
     ]);

     //send email
     
     Mail::send('forgot' ,['token' => $token], function ( $message) use ($email) {
         $message->to($email);
         $message->subject('Reset your password');
     });

     return response([
         'message'=> 'Check your email!'
     ]);

        }catch (\Exception $exception){
     return response([
         'message'=> $exception->getMessage()
     ],400);
        }

    }
    public function reset(Request $request){

        $token = $request->input('token');
        if(!$passwordResets = DB::table('password_resets')->where('token', $token)->first()){
            return response([
                'message' => 'Invalid Token!'
            ],400);
        }
        /**@var User $user */
       if(!$user = User ::where('email',$passwordResets->email)->first()){
            return response([
                'message' => 'User no existe'
            ],404);
        }
       
        $user->password = Hash::make($request->input('password'));
        $user->save();
        return response([
            'message' => 'Success'
        ],201);
    }

}
