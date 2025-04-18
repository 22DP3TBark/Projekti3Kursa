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
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('listing_type', ['private', 'company'])->default('private');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->string('currency', 10)->default('EUR');
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('country')->default('Latvia');
            $table->string('zip_code')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->enum('purpose', ['sell', 'rent'])->default('sell');
            $table->enum('property_type', [
                'dzivoklis',
                'maja',
                'birojs',
                'zeme',
                'studio',
                'villa'
            ])->nullable();
            $table->tinyInteger('bedrooms')->nullable();
            $table->tinyInteger('bathrooms')->nullable();
            $table->integer('size')->nullable();
            $table->integer('floor')->nullable();
            $table->string('building_type')->nullable();
            $table->year('year_built')->nullable();
            $table->tinyInteger('parking_spaces')->nullable();
            $table->string('main_image')->nullable();
            $table->json('gallery')->nullable();
            $table->boolean('balcony')->nullable();
            $table->boolean('garage')->nullable();
            $table->boolean('swimming_pool')->nullable();
            $table->boolean('garden')->nullable();
            $table->boolean('furnished')->nullable();
            $table->enum('status', ['available', 'sold', 'rented'])->default('available');
            $table->timestamps();
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
