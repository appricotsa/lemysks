<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function categories()
    {
        $categories = Category::where('parent_category_guid', '0')->with('children')->orderBy('order')->get();
        return response()->json(['categories' => $categories], 200);
    }
}
