<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyReceipt extends Model
{
    protected $fillable = ['user_id', 'property_id', 'card_last_digits'];
    public $timestamps = false; // <-- Add this line
}
