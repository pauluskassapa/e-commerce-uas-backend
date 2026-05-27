<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        return view('categories.index', [
            'categories' => Category::withCount('products')->latest()->get(),
        ]);
    }

    public function show(Category $category): View
    {
        return view('categories.show', compact('category'));
    }
}
