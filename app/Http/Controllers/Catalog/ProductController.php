<?php

namespace App\Http\Controllers\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        return view('products.index', [
            'products' => Product::with('category')->latest()->get(),
        ]);
    }

    public function show(Product $product): View
    {
        return view('products.show', compact('product'));
    }
}
