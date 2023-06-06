<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Jackiedo\Cart\Facades\Cart;



class CartController extends Controller
{
    protected $cart;
    public function add(Request $request)
    {
        $product = Product::find($request->product_id);

        $shoppingCart = Cart::name('shopping');

        $shoppingCart->addItem([
            'id' => $product->id,
            'title' => $product->name,
            'quantity' => (int) $request->quantity,
            'price' => $product->price / 10,
        ]);
        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    public function show(Cart $cart)
    {
        $items = Cart::name('shopping')->getItems();
        // dd($items);
        return view(
            'cart',
            [
                'items' => $items,
            ]
        );
    }
}