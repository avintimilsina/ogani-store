<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function getAction()
    {
        $categories = Category::where('id', 1)->get();
        dd($categories[0]->toArray());
    }
}