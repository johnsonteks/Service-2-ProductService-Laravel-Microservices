<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create() {
        return view('products.create');
    }

    public function store(Request $request) {
        Product::create($request->all());
        return redirect('/products');
    }

    public function edit($id) {
        $product = Product::findOrFail($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return redirect('/products');
    }

    public function destroy($id) {
        Product::destroy($id);
        return redirect('/products');
    }

    public function showOrders($id) {
        $product = Product::findOrFail($id);
        $orders = Http::get("http://localhost:8003/api/orders/product/$id")->json();
        return view('products.orders', compact('product', 'orders'));
    }

    public function getProduct($id) {
        return response()->json(Product::find($id));
    }
}
