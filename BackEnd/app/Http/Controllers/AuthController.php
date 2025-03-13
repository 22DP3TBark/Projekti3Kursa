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

       return response()->json([
            'user' => $user,
            'token' => $token,
        ], 201);
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
        
        //generate token
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role, // Ensure this field is returned
            ]
        ]);
    }

    public function logout(Request $request){
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
