<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Models\ReviewReply;
use App\Models\User;
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

    public function apiIndex(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'review_id' => ['sometimes', 'integer', 'exists:reviews,id'],
        ]);

        $replies = ReviewReply::with(['review.product', 'user'])
            ->when(
                $validated['review_id'] ?? null,
                fn ($query, $reviewId) => $query->where('review_id', $reviewId)
            )
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Data balasan review berhasil ditampilkan.',
            'data' => $replies,
        ]);
    }

    public function apiShow(ReviewReply $reviewReply): JsonResponse
    {
        $reviewReply->load(['review.product', 'user']);

        return response()->json([
            'message' => 'Detail balasan review berhasil ditampilkan.',
            'data' => $reviewReply,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'review_id' => ['required', 'integer', 'exists:reviews,id'],
            'user_id' => $this->userIdRules($request),
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $user = $this->resolveUser($request, $validated['user_id'] ?? null);

        if ($user->role !== 'seller') {
            return response()->json([
                'message' => 'Hanya seller yang bisa membalas review.',
            ], 403);
        }

        $reply = ReviewReply::create([
            'review_id' => $validated['review_id'],
            'user_id' => $user->id,
            'message' => $validated['message'],
        ]);

        return response()->json([
            'message' => 'Balasan review berhasil ditambahkan.',
            'data' => $reply->load(['review', 'user']),
        ], 201);
    }

    public function update(Request $request, ReviewReply $reviewReply): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => $this->userIdRules($request),
            'message' => ['sometimes', 'required', 'string', 'max:1000'],
        ]);

        $user = $this->resolveUser($request, $validated['user_id'] ?? null);

        if ($user->role !== 'seller') {
            return response()->json([
                'message' => 'Hanya seller yang bisa mengatur balasan review.',
            ], 403);
        }

        if ($user->id !== $reviewReply->user_id) {
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
            'user_id' => $this->userIdRules($request),
        ]);

        $user = $this->resolveUser($request, $validated['user_id'] ?? null);

        if ($user->role !== 'seller') {
            return response()->json([
                'message' => 'Hanya seller yang bisa mengatur balasan review.',
            ], 403);
        }

        if ($user->id !== $reviewReply->user_id) {
            return response()->json([
                'message' => 'User hanya bisa menghapus balasan review miliknya sendiri.',
            ], 403);
        }

        $reviewReply->delete();

        return response()->json([
            'message' => 'Balasan review berhasil dihapus.',
        ]);
    }

    private function userIdRules(Request $request): array
    {
        return $request->user()
            ? ['nullable']
            : ['required', 'integer', 'exists:users,id'];
    }

    private function resolveUser(Request $request, mixed $userId): User
    {
        $user = $request->user();

        if ($user instanceof User) {
            return $user;
        }

        return User::findOrFail($userId);
    }
}
