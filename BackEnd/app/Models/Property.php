<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Property extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'user_id', 'title', 'description', 'price', 'currency', 'address', 'city',
        'state', 'country', 'zip_code', 'latitude', 'longitude', 'property_type',
        'bedrooms', 'bathrooms', 'size', 'year_built', 'parking_spaces', 'main_image',
        'gallery', 'balcony', 'garage', 'swimming_pool', 'garden', 'furnished', 'status',
    ];

    protected $casts = [
        'gallery' => 'array', // Ensure gallery is stored as JSON
        'balcony' => 'boolean',
        'garage' => 'boolean',
        'swimming_pool' => 'boolean',
        'garden' => 'boolean',
        'furnished' => 'boolean',
    ];
    //
}
