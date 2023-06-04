<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAll()
    {
        $categories = Category::all();
        // dd($categories->toArray());
        return view('category', ['categories' => $categories]);
    }

}
