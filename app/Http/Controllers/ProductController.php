<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::all();
        $out = ProductResource::collection($data);
        return response($out);
    }

    public function show(Product $product)
    {
        $out = new ProductResource($product);
        return response($out);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $product = Product::create($data);
        return response(new ProductResource($product), 201);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric',
        ]);

        $product->update($data);
        return response(new ProductResource($product), 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response(null, 204);
    }
}
