<?php

namespace App\Http\Controllers;

use App\Models\Property;
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
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'currency' => 'nullable|string|max:10',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'district' => 'nullable|string', // Added district
            'country' => 'nullable|string|',
            'zip_code' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'purpose' => 'nullable|in:sell,rent',
            'property_type' => 'nullable|in:dzivoklis,maja,birojs,zeme,studio,villa',
            'bedrooms' => 'nullable|integer|min:0',
            'bathrooms' => 'nullable|integer|min:0',
            'size' => 'nullable|integer|min:0',
            'floor' => 'nullable|integer|min:0',
            'building_type' => 'nullable|string',
            'year_built' => 'nullable|integer',
            'parking_spaces' => 'nullable|integer|min:0',
            'main_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'balcony' => 'nullable|boolean',
            'garage' => 'nullable|boolean',
            'swimming_pool' => 'nullable|boolean',
            'garden' => 'nullable|boolean',
            'furnished' => 'nullable|boolean',
            'status' => 'nullable|in:available,sold,rented',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
          // Handle default values
    $country = $request->input('country', 'Latvia'); // Set default value for country

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

        // Create the property record in the database
        $property = Property::create([
            'user_id' => auth()->id(), // Assuming user is authenticated
            'listing_type' => 'nullable|in:private,company',
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'currency' => $request->currency ?? 'EUR',
            'address' => $request->address,
            'city' => $request->city,
            'district' => $request->district,
            'country' => $country,
            'zip_code' => $request->zip_code,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'purpose' => $request->purpose ?? 'sell',
            'property_type' => $request->property_type,
            'bedrooms' => $request->bedrooms,
            'bathrooms' => $request->bathrooms,
            'size' => $request->size,
            'floor' => $request->floor,
            'building_type' => $request->building_type,
            'year_built' => $request->year_built,
            'parking_spaces' => $request->parking_spaces,
            'main_image' => $mainImagePath ? asset('storage/' . $mainImagePath) : null,
            'gallery' => $galleryPaths ? json_encode(array_map(fn($path) => asset('storage/' . $path), $galleryPaths)) : json_encode([]),
            'balcony' => $request->balcony,
            'garage' => $request->garage,
            'swimming_pool' => $request->swimming_pool,
            'garden' => $request->garden,
            'furnished' => $request->furnished,
            'status' => $request->status ?? 'available',
        ]);

        return response()->json([
            'message' => 'Property added successfully!',
            'property' => $property
        ], 201);
    }

    public function search(Request $request)
    {
        $query = $request->input('q');

        $properties = Property::where('title', 'like', "%{$query}%")
            ->orWhere('city', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->orWhere('property_type', 'like', "%{$query}%")
            ->orWhere('price', 'like', "%{$query}%")
            ->orWhere('bedrooms', 'like', "%{$query}%")
            ->get();

        return response()->json($properties);
    }

    public function show($id)
    {
        $property = Property::find($id);

        if (!$property) {
            return response()->json(['message' => 'Property not found'], 404);
        }

        return response()->json(['property' => $property], 200);
    }

    public function userProperties()
    {
        $user = auth()->user();
        $properties = $user->properties; // Assuming the User model has a `properties` relationship

        return response()->json($properties);
    }
}
