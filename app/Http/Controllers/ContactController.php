<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:255',
            'message' => 'required|string',
            'subject' => 'required|string|max:255',
        ]);

        $contact = Contact::create($validated);

        return response()->json([
            'message' => 'Contact created successfully.',
            'contact_id' => $contact->id,
        ], 201);
    }
    
}
