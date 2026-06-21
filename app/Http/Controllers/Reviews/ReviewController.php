<?php

namespace App\Http\Controllers\Reviews;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
        $review->load(['user', 'product', 'replies.user']);

        return view('reviews.show', compact('review'));
    }

    public function apiIndex(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['sometimes', 'integer', 'exists:products,id'],
        ]);

        $product = isset($validated['product_id'])
            ? Product::findOrFail($validated['product_id'])
            : null;

        $reviews = Review::with(['user', 'product', 'replies.user'])
            ->when($product, fn ($query) => $query->where('product_id', $product->id))
            ->latest()
            ->get();

        return response()->json([
            'message' => 'Data review berhasil ditampilkan.',
            'data' => $reviews,
            'summary' => $product ? [
                'average_rating' => $product->averageRating(),
                'review_count' => $product->reviewCount(),
            ] : null,
        ]);
    }

    public function apiShow(Review $review): JsonResponse
    {
        $review->load(['user', 'product', 'replies.user']);

        return response()->json([
            'message' => 'Detail review berhasil ditampilkan.',
            'data' => $review,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => $this->userIdRules($request),
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = $this->resolveUser($request, $validated['user_id'] ?? null);

        if ($user->role !== 'buyer') {
            return response()->json([
                'message' => 'Hanya buyer yang bisa membuat review.',
            ], 403);
        }

        if (! $this->hasPaidForProduct($user, $validated['product_id'])) {
            return response()->json([
                'message' => 'Review hanya dapat dibuat setelah produk dibayar.',
            ], 403);
        }

        if (Review::where('user_id', $user->id)
            ->where('product_id', $validated['product_id'])
            ->exists()) {
            throw ValidationException::withMessages([
                'product_id' => 'User sudah memberikan review untuk produk ini.',
            ]);
        }

        $review = Review::create([
            'user_id' => $user->id,
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
        ]);

        return response()->json([
            'message' => 'Review berhasil ditambahkan.',
            'data' => $review->load(['user', 'product']),
        ], 201);
    }

    public function update(Request $request, Review $review): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => $this->userIdRules($request),
            'rating' => ['sometimes', 'required', 'integer', 'min:1', 'max:5'],
            'comment' => ['sometimes', 'nullable', 'string', 'max:1000'],
        ]);

        $user = $this->resolveUser($request, $validated['user_id'] ?? null);

        if ($user->role !== 'buyer') {
            return response()->json([
                'message' => 'Hanya buyer yang bisa mengatur review.',
            ], 403);
        }

        if ($user->id !== $review->user_id) {
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
            'user_id' => $this->userIdRules($request),
        ]);

        $user = $this->resolveUser($request, $validated['user_id'] ?? null);

        if ($user->role !== 'buyer') {
            return response()->json([
                'message' => 'Hanya buyer yang bisa mengatur review.',
            ], 403);
        }

        if ($user->id !== $review->user_id) {
            return response()->json([
                'message' => 'User hanya bisa menghapus review miliknya sendiri.',
            ], 403);
        }

        $review->delete();

        return response()->json([
            'message' => 'Review berhasil dihapus.',
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

    private function hasPaidForProduct(User $user, int $productId): bool
    {
        return Payment::where('user_id', $user->id)
            ->where('status', 'paid')
            ->whereHas('cart.items', fn ($query) => $query->where('product_id', $productId))
            ->exists();
    }
}
