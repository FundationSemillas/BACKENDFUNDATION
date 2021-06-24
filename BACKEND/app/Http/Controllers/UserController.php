<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
public function user(Request $request){
    return $request->user();
}

  public function index(){      
    return User::all();
  }

  public function store(){
      //
  }
  public function update(){
      //
  }
  public function destroy(){
      //
  }
  

}
