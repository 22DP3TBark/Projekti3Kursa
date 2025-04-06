<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PropertyController extends Controller
{
    public function index()
    {
        $properties = Property::all();

        return response()->json([
            'properties' => $properties
    ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|max:10',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'nullable|string',
            'country' => 'required|string',
            'zip_code' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'property_type' => 'required|in:house,apartment,studio,villa,land',
            'bedrooms' => 'required|integer|min:0',
            'bathrooms' => 'required|integer|min:0',
            'size' => 'nullable|integer|min:0',
            'year_built' => 'nullable|integer',
            'parking_spaces' => 'nullable|integer|min:0',
            'main_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'balcony' => 'required|in:true,false,1,0',
            'garage' => 'required|in:true,false,1,0',
            'swimming_pool' => 'required|in:true,false,1,0',
            'garden' => 'required|in:true,false,1,0',
            'furnished' => 'required|in:true,false,1,0',
            'status' => 'required|in:available,sold,rented',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Handle main image upload
    $mainImagePath = null;
    if ($request->hasFile('main_image')) {
        $mainImagePath = $request->file('main_image')->store('properties', 'public');
    }

       // Handle gallery images
    $galleryPaths = [];
    if ($request->hasFile('gallery')) {
        foreach ($request->file('gallery') as $image) {
            $galleryPaths[] = $image->store('properties/gallery', 'public');
        }
    }

        // Create the property
        $property = Property::create([
            'user_id' => auth()->id(), // Assuming authentication is used
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'currency' => $request->currency,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zip_code' => $request->zip_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'property_type' => $request->property_type,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'size' => $request->size,
            'year_built' => $request->year_built,
            'parking_spaces' => $request->parking_spaces,
            'main_image' => $mainImagePath ? asset('storage/' . $mainImagePath) : null,
            'gallery' => $galleryPaths ? array_map(fn($path) => asset('storage/' . $path), $galleryPaths) : [],
            'balcony' => filter_var($request->balcony, FILTER_VALIDATE_BOOLEAN),
            'garage' => filter_var($request->garage, FILTER_VALIDATE_BOOLEAN),
            'swimming_pool' => filter_var($request->swimming_pool, FILTER_VALIDATE_BOOLEAN),
            'garden' => filter_var($request->garden, FILTER_VALIDATE_BOOLEAN),
            'furnished' => filter_var($request->furnished, FILTER_VALIDATE_BOOLEAN),
            'status' => $request->status,   
        ]);

        $properties = Property::all();

        return response()->json([
            'message' => 'Property added successfully!',
            'properties' => $properties,
            'property' => [
                'id' => $property->id,
                'title' => $property->title,
                'main_image' => asset('storage/' . $property->main_image),
                'gallery' => $galleryPaths ? json_encode(array_map(fn($path) => asset('storage/' . $path), $galleryPaths)) : json_encode([]),

            ]
        ], 201);
    }
    public function search(Request $request){
        $query = $request->input('q');

        $properties = Property::where('title', 'like', "%{$query}")
            ->orWhere('city', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhere('property_type', 'like', "%{$query}%")
            ->orWhere('price', 'like', "%{$query}%")
            ->orWhere('bedrooms', 'like', "%{$query}%")
            ->get();

            return response()->json($properties);
    }
};
