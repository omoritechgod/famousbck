<?php

namespace App\Http\Controllers;

use App\Mail\QuoteRequestMail;
use App\Models\Quote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QuoteController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'additional_requirements' => 'nullable|string',

            //validation for products
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|string',
            'products.*.code' => 'required|string',
            'products.*.description' => 'required|string',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.current_price' => 'required|numeric|min:0',

            'urgency' => 'nullable|string|max:255',
        ]);


        // Create the quote
        $quote = Quote::create($validated);

        Mail::to('info@famousitsolutionltd.com')->send(new QuoteRequestMail($quote));
        
        return response()->json([
            'message' => 'Quote created successfully.',
            'data' => $quote->id
        ], 201);
    }

    public function index()
    {
        $quote = Quote::latest()->get();
        if ($quote->isEmpty()) {
            return response()->json(['message' => 'No quotes found.'], 404);
        }
        return response()->json(['quotes' => $quote]);
    }

    public function show($id)
    {
        $quote = Quote::findOrFail($id);
        if ($quote->isEmpty()) {
            return response()->json(['message' => 'Quote not found.'], 404);
        }
        return response()->json(['quote' => $quote]);
    }

    // Admin: Delete
    public function destroy(Request $request)
    {
        $id = $request->query('id');

        if (!$id) {
            return response()->json(['message' => 'ID is required'], 400);
        }
        $quote = Quote::find($id);

        if (!$quote) {
            return response()->json(['message' => 'No quote to delete.'], 404);
        }

        $quote->delete();

        return response()->json(['message' => 'Quote deleted successfully.']);
    }


    // Admin: Update status
    public function updatestatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,quoted,completed,cancelled',
        ]);

        $quote = Quote::findOrFail($id);
        $quote->status = $validated['status'];
        $quote->save();

        return response()->json(['message' => 'Quote status updated successfully.']);
    }
}
