<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; 
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function getUserInfo(Request $request){

      // Log the request headers
      //Log::info('Request Headers:', $request->headers->all());

      // Get the authenticated user
      $user = Auth::user();

      // Log the user information
      //Log::info('Authenticated User:', ['user' => $user]);

      if (!$user) {
          return response()->json([
              'error' => 'Unauthorized'
          ], 401);
      }

      return response()->json([
          'user' => $user
      ], 200);
    }

    

    public function getall(){
        $info = User::all();
        return $info;
    }
}
