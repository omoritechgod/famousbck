<?php

namespace App\Http\Controllers;

use App\Models\QuoteRequest;
use Illuminate\Http\Request;

class QuoteRequestController extends Controller
{
    // Public: Submit quote
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'company' => 'nullable|string|max:255',
            'products' => 'required|array|min:1',
            'products.*.code' => 'required|string',
            'products.*.description' => 'required|string',
            'products.*.quantity' => 'required|integer|min:1',
            'products.*.currentPrice' => 'required|string', // or numeric
            'additional_requirements' => 'nullable|string',
            'urgency' => 'nullable|in:standard,urgent,emergency',
        ]);

        $validated['status'] = 'pending';

        $quote = QuoteRequest::create($validated);

        return response()->json([
            'message' => 'Quote request submitted successfully.',
            'quote_id' => $quote->id
        ]);
    }

    // Admin: Get all
    public function index()
    {
        $quotes = QuoteRequest::latest()->get();

        return response()->json(['quotes' => $quotes]);
    }

    // Admin: Show one
    public function show($id)
    {
        $quote = QuoteRequest::findOrFail($id);
        return response()->json(['quote' => $quote]);
    }

    // Admin: Delete
    public function destroy($id)
    {
        $quote = QuoteRequest::findOrFail($id);
        $quote->delete();
        return response()->json(['message' => 'Quote request deleted.']);
    }

    // Admin: Update status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,quoted,completed',
        ]);

        $quote = QuoteRequest::findOrFail($id);
        $quote->status = $request->status;
        $quote->save();

        return response()->json(['message' => 'Quote status updated successfully.']);
    }
}
