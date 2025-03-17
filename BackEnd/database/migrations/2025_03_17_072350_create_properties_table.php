<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Links to users table
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('currency', 10)->default('EUR');
            $table->string('address');
            $table->string('city');
            $table->string('state')->nullable();
            $table->string('country');
            $table->string('zip_code')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('property_type', ['house', 'apartment', 'studio', 'villa', 'land']);
            $table->tinyInteger('bedrooms')->default(1);
            $table->tinyInteger('bathrooms')->default(1);
            $table->integer('size')->nullable(); // Square meters
            $table->year('year_built')->nullable();
            $table->tinyInteger('parking_spaces')->default(0);
            $table->string('main_image')->nullable(); // URL of main image
            $table->json('gallery')->nullable(); // Store multiple image URLs
            $table->boolean('balcony')->default(false);
            $table->boolean('garage')->default(false);
            $table->boolean('swimming_pool')->default(false);
            $table->boolean('garden')->default(false);
            $table->boolean('furnished')->default(false);
            $table->enum('status', ['available', 'sold', 'rented'])->default('available');
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
