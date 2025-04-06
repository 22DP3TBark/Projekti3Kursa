<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property; // Import the Property model
use Illuminate\Support\Facades\Hash; // Import Hash facade if needed
use Illuminate\Support\Facades\Validator; // Import Validator facade

class PropertyCrudController extends Controller
{
    public function index() {
        $properties = Property::all();
        return response()->json($properties);
    }

    public function show($id){
        $property = Property::findOrFail($id);
        return response()->json($property);
    }

    public function update(Request $request, $id) {

        $property = Property::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|in:available,sold,rented',
            'address' => 'sometimes|string',
            'city' => 'sometimes|string',
        ]);

            if( $validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $property->update($request->all());
            return response()->json([
                'message' => 'Property updated successfully!',
                'property' => $property,
                200
            ]);
    }

    public function delete($id) {
        $property = Property::findOrFail($id);
        $property->delete();
        return response()->json([
            'message' => 'Property deleted successfully!',
            200
        ]);
    }

}
