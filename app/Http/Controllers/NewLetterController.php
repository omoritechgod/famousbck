<?php

namespace App\Http\Controllers;

use App\Models\NewLetter;
use Illuminate\Http\Request;

class NewLetterController extends Controller
{
    public function newletter(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255|unique:new_letters',
        ]);

        $newLetter = NewLetter::create($validated);

        return response()->json([
            'message' => 'Email sent successfully.',
            'new_letter_id' => $newLetter->id,
        ], 201);
    }

}
