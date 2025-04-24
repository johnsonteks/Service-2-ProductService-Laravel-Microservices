<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    // ----- API -----
    public function index(Request $request) {
        if ($request->is('api/*')) {
            return response()->json(Product::all());
        }
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function show($id, Request $request) {
        $product = Product::findOrFail($id);
        if ($request->is('api/*')) {
            return response()->json($product);
        }
        return view('products.show', compact('product')); // optional jika punya view
    }

    public function store(Request $request) {
        $product = Product::create($request->all());

        if ($request->is('api/*')) {
            return response()->json($product, 201);
        }

        return redirect('/products');
    }

    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);
        $product->update($request->all());

        if ($request->is('api/*')) {
            return response()->json($product);
        }

        return redirect('/products');
    }

    public function destroy(Request $request, $id) {
        Product::destroy($id);

        if ($request->is('api/*')) {
            return response()->json(['message' => 'Product deleted']);
        }

        return redirect('/products');
    }

    // ----- Web only -----
    public function create() {
        return view('products.create');
    }

    public function edit($id) {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function showOrders($id) {
        $product = Product::findOrFail($id);
        $orders = Http::get("http://localhost:8003/api/orders/product/$id")->json();
        return view('products.orders', compact('product', 'orders'));
    }
}
