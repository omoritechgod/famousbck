<?php

use App\Http\Controllers\NewLetterController;
use App\Http\Controllers\QuoteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\SubscriptionController;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AuthController;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ContactController;

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/dashboard-summary', [App\Http\Controllers\Admin\DashboardController::class, 'summary']);
});


// Admin (authenticated)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/admin/quotes', [QuoteController::class, 'index']);
    Route::get('/admin/quotes/{id}', [QuoteController::class, 'show']);
    Route::delete('/admin/quotes', [QuoteController::class, 'destroy']);
    Route::put('/admin/quotes/{id}/status', [QuoteController::class, 'updateStatus']);
});

// ADMIN (auth required)
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::put('/products/{id}/feature', [ProductController::class, 'toggleFeatured']);
});

// PUBLIC
Route::get('/products', [ProductController::class, 'publicIndex']);
Route::get('/products/featured', [ProductController::class, 'featured']);


Route::post('/admin/login', [AuthController::class, 'login'])->name('login');

Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/quote-requests', [QuoteController::class, 'store']);
    Route::post('/new-email', [NewLetterController::class, 'newletter']);
    Route::post('/contact-us', [ContactController::class, 'store']);
});

Route::post('/log-error', function (Request $request) {
    Log::error('Frontend Error', [
        'message' => $request->input('message'),
        'stack'   => $request->input('stack'),
        'context' => $request->input('context'),
        'url'     => $request->input('url'),
        'user_id' => auth('sanctum')->id() ?? null, // Optional if using auth
    ]);

    return response()->json(['status' => 'logged'], 200);
});