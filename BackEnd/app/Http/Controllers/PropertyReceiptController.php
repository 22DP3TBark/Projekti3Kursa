<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyReceipt; // <-- Add this import

class PropertyReceiptController extends Controller
{
    public function store(Request $request)
{
    $validated = $request->validate([
        'property_id' => 'required|exists:properties,id',
        'card_number' => 'required|min:4',
    ]);

    $user = auth()->user();

    $receipt = PropertyReceipt::create([
        'user_id' => $user->id,
        'property_id' => $validated['property_id'],
        'card_last_digits' => substr($validated['card_number'], -4),
    ]);

    return response()->json(['message' => 'Receipt created', 'receipt' => $receipt]);
}
}
