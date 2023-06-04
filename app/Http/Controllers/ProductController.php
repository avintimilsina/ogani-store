<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::limit(20)->get();
        return view('products.list', ['products' => $products]);
    }

    public function show()
    {
        return view('products.show');
    }
}