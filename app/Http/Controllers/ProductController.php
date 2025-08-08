<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // CREATE product
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'specifications' => 'nullable|array',
            'features' => 'nullable|array',
            'images' => 'nullable|array',
            'availability' => 'boolean',
            'featured' => 'boolean',
        ]);

        $product = Product::create($data);

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    // GET all products (admin)
    public function index()
    {
        return response()->json([
            'products' => Product::latest()->get()
        ]);
    }

    // GET one product
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    // UPDATE product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|string',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric',
            'category' => 'sometimes|string',
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'specifications' => 'nullable|array',
            'features' => 'nullable|array',
            'images' => 'nullable|array',
            'availability' => 'boolean',
            'featured' => 'boolean',
        ]);

        $product->update($data);

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ]);
    }

    // DELETE product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }

    // TOGGLE FEATURED
    public function toggleFeatured($id)
    {
        $product = Product::findOrFail($id);
        $product->featured = !$product->featured;
        $product->save();

        return response()->json([
            'message' => $product->featured ? 'Product marked as featured' : 'Product unmarked as featured',
            'product' => $product
        ]);
    }

    // PUBLIC: Get featured products (limit 3)
    public function featured()
    {
        return response()->json([
            'products' => Product::where('featured', true)
                ->where('availability', true)
                ->latest()
                ->take(3)
                ->get()
        ]);
    }

    // PUBLIC: Get all available products (with optional filters)
    public function publicIndex(Request $request)
    {
        $query = Product::query()->where('availability', true);

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%")
                  ->orWhere('brand', 'like', "%$search%");
            });
        }

        if ($category = $request->query('category')) {
            $query->where('category', $category);
        }

        if ($sortBy = $request->query('sort_by')) {
            $sortOrder = $request->query('sort_order', 'asc');
            $query->orderBy($sortBy, $sortOrder);
        }

        $perPage = $request->query('per_page', 12);
        $products = $query->paginate($perPage);

        return response()->json($products);
    }
}
