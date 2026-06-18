<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $review->load(['user', 'product']);

        return view('reviews.show', compact('review'));
    }

    public function apiIndex(): JsonResponse
    {
        $reviews = Review::with(['user', 'product'])
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Data review berhasil ditampilkan.',
            'data' => $reviews,
        ]);
    }

    public function apiShow(Review $review): JsonResponse
    {
        $review->load(['user', 'product']);

        return response()->json([
            'message' => 'Detail review berhasil ditampilkan.',
            'data' => $review,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $review = Review::create($validated);

        return response()->json([
            'message' => 'Review berhasil ditambahkan.',
            'data' => $review->load(['user', 'product']),
        ], 201);
    }

    public function update(Request $request, Review $review): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'rating' => ['sometimes', 'required', 'integer', 'min:1', 'max:5'],
            'comment' => ['sometimes', 'nullable', 'string', 'max:1000'],
        ]);

        if ((int) $validated['user_id'] !== $review->user_id) {
            return response()->json([
                'message' => 'User hanya bisa mengubah review miliknya sendiri.',
            ], 403);
        }

        $review->update([
            'rating' => $validated['rating'] ?? $review->rating,
            'comment' => array_key_exists('comment', $validated) ? $validated['comment'] : $review->comment,
        ]);

        return response()->json([
            'message' => 'Review berhasil diperbarui.',
            'data' => $review->refresh()->load(['user', 'product']),
        ]);
    }

    public function destroy(Request $request, Review $review): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        if ((int) $validated['user_id'] !== $review->user_id) {
            return response()->json([
                'message' => 'User hanya bisa menghapus review miliknya sendiri.',
            ], 403);
        }

        $review->delete();

        return response()->json([
            'message' => 'Review berhasil dihapus.',
        ]);
    }
}
