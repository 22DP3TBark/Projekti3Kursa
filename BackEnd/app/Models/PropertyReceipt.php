<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyReceipt extends Model
{
    public $timestamps = false;

    protected $fillable = ['user_id', 'property_id', 'card_last_digits'];
}
