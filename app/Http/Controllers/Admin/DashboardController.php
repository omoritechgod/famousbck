<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\QuoteRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function summary()
    {
        // Count of all products
        $totalProducts = Product::count();

        // Count of all quote requests
        $totalQuoteRequests = QuoteRequest::count();

        // Count of pending quote requests (assuming you have a `status` column)
        $pendingQuoteRequests = QuoteRequest::where('status', 'pending')->count();

        // Latest 5 quote requests
        $recentQuoteRequests = QuoteRequest::with('items')->latest()->take(5)->get();

        return response()->json([
            'total_products' => $totalProducts,
            'total_quote_requests' => $totalQuoteRequests,
            'pending_quote_requests' => $pendingQuoteRequests,
            'recent_quote_requests' => $recentQuoteRequests,
        ]);
    }
}
