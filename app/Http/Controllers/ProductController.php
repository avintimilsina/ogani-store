<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $filterCategorySlug = $request->get('category');

        $categories = Category::take(11)->get();

        $category = Category::where('slug', $filterCategorySlug)->first();

        if (@$category) {
            //defining realtion between category and product from the products() funvtion in the Category Controller
            $products = $category->products()->get();
        } else {

            $products = Product::all();
        }


        return view('products.list', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();
        // dd($product->categories->toArray());
        $products = Product::limit(4)->get();
        $categories = Category::limit(11)->get();
        return view('products.show', [
            'products' => $products,
            'product' => $product,
            'categories' => $categories,
        ]);
    }
}