<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Models\ReviewReply;
use Illuminate\View\View;

class ReviewReplyController extends Controller
{
    public function index(): View
    {
        return view('review-replies.index', [
            'replies' => ReviewReply::with(['review', 'user'])->latest()->get(),
        ]);
    }

    public function show(ReviewReply $reviewReply): View
    {
        return view('review-replies.show', compact('reviewReply'));
    }
}
