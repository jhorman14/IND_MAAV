<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 12);
        $products = Product::with('category')->paginate($perPage);
        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        $product->load('category');
        return new ProductResource($product);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $product = Product::create($data);
        $product->load('category');
        return (new ProductResource($product))->response()->setStatusCode(201);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        $product->load('category');
        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
