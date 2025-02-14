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
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'required|string|max:255',
        ] );

        if($validator->fails()){
            return response()->json(['errors'=> $validator->errors()], 422);
        }

        //create user in database   

        $user = User::create([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        //$response = ([
         //   'user' => $user,
         //   'token' => $token,
       // ]);

       $response = ([
        'user' => $user,
        'token' => $token,
       ]);
        
        return response($response, 201);
    }

    public function login(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //find user by email
        $user = User::where('email', $request->email)->first();

        //Check if user  exists and password is correct
        if(!$user || !Hash::check($request->password, $user->password)){
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        // $user = Auth::user();

        //generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        //$cookie = cookie('jwt', $token, 60*24); // 1 day
        // then add to the response a withCookie($cookie)

        return response()->json([
            'message' => 'Login  successful',
            'user' => $user,
            'token' => $token,
        ]);
    }
}
