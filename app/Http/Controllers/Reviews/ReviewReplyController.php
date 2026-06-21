<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Models\ReviewReply;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
        $reviewReply->load(['review', 'user']);

        return view('review-replies.show', compact('reviewReply'));
    }

    public function apiIndex(): JsonResponse
    {
        $replies = ReviewReply::with(['review', 'user'])
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Data balasan review berhasil ditampilkan.',
            'data' => $replies,
        ]);
    }

    public function apiShow(ReviewReply $reviewReply): JsonResponse
    {
        $reviewReply->load(['review', 'user']);

        return response()->json([
            'message' => 'Detail balasan review berhasil ditampilkan.',
            'data' => $reviewReply,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'review_id' => ['required', 'integer', 'exists:reviews,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $reply = ReviewReply::create($validated);

        return response()->json([
            'message' => 'Balasan review berhasil ditambahkan.',
            'data' => $reply->load(['review', 'user']),
        ], 201);
    }

    public function update(Request $request, ReviewReply $reviewReply): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'message' => ['sometimes', 'required', 'string', 'max:1000'],
        ]);

        if ((int) $validated['user_id'] !== $reviewReply->user_id) {
            return response()->json([
                'message' => 'User hanya bisa mengubah balasan review miliknya sendiri.',
            ], 403);
        }

        $reviewReply->update([
            'message' => $validated['message'] ?? $reviewReply->message,
        ]);

        return response()->json([
            'message' => 'Balasan review berhasil diperbarui.',
            'data' => $reviewReply->refresh()->load(['review', 'user']),
        ]);
    }

    public function destroy(Request $request, ReviewReply $reviewReply): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        if ((int) $validated['user_id'] !== $reviewReply->user_id) {
            return response()->json([
                'message' => 'User hanya bisa menghapus balasan review miliknya sendiri.',
            ], 403);
        }

        $reviewReply->delete();

        return response()->json([
            'message' => 'Balasan review berhasil dihapus.',
        ]);
    }
}
