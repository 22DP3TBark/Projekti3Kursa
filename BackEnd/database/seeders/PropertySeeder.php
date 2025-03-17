<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Property::create([
                'user_id' => 36, // Change based on actual user IDs
                'title' => "Property $i",
                'description' => "Description for Property $i",
                'price' => rand(50000, 500000),
                'currency' => 'EUR',
                'address' => "$i Example Street",
                'city' => 'Riga',
                'state' => 'Riga',
                'country' => 'Latvia',
                'zip_code' => 'LV-1050',
                'latitude' => 56.9496 + (rand(-10, 10) / 100),
                'longitude' => 24.1052 + (rand(-10, 10) / 100),
                'property_type' => ['house', 'apartment', 'studio', 'villa', 'land'][rand(0, 4)],
                'bedrooms' => rand(1, 5),
                'bathrooms' => rand(1, 3),
                'size' => rand(50, 400),
                'year_built' => rand(1990, 2023),
                'parking_spaces' => rand(0, 3),
                'main_image' => "properties/sample$i.jpg",
                'gallery' => json_encode(["properties/sample${i}a.jpg", "properties/sample${i}b.jpg"]),
                'balcony' => rand(0, 1),
                'garage' => rand(0, 1),
                'swimming_pool' => rand(0, 1),
                'garden' => rand(0, 1),
                'furnished' => rand(0, 1),
                'status' => ['available', 'sold', 'rented'][rand(0, 2)],
            ]);
        }
    }
}
