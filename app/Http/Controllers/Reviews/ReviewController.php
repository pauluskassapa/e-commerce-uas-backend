<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function index(): View
    {
        return view('reviews.index', [
            'reviews' => Review::with(['user', 'product'])->latest()->get(),
        ]);
    }

    public function show(Review $review): View
    {
        return view('reviews.show', compact('review'));
    }
}
