<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User; 

class AuthController extends Controller
{
    public function  register(Request $request){
        
        // validate incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ] );

        if($validator->fails()){
            return response()->json(['errors'=> $validator->errors()], 422);
        }

        //create user in database   

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response() ->json(['message' => 'User created successfully', 'user' => $user], 201);
    }
}
