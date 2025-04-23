<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
// routes/api.php
use App\Models\Product;

Route::get('/product/{id}', [ProductController::class, 'getProduct']);


Route::get('/product-list', fn() => response()->json(Product::all()));
