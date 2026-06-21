@extends('layouts.app')

@section('content')
    @include('reviews.partials.styles')

    <section class="review-page" aria-labelledby="review-list-title">
        <div class="review-heading">
            <div>
                <p class="review-kicker">Ulasan pembeli</p>
                <h2 id="review-list-title">Review Produk</h2>
            </div>
            <div class="review-count">
                <strong>{{ $reviews->count() }}</strong>
                <span>review</span>
            </div>
        </div>

        <div class="review-table-shell">
            <table class="review-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Produk</th>
                        <th>Rating</th>
                        <th>Komentar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reviews as $review)
                        <tr>
                            <td>#{{ $review->id }}</td>
                            <td>{{ $review->user?->name ?? '-' }}</td>
                            <td><strong>{{ $review->product?->name ?? '-' }}</strong></td>
                            <td>
                                <span class="review-rating" aria-label="Rating {{ $review->rating }} dari 5">
                                    {{ $review->rating }}/5
                                </span>
                            </td>
                            <td class="review-comment-cell">{{ $review->comment ?? '-' }}</td>
                            <td>
                                <a class="review-action" href="{{ route('reviews.show', $review) }}">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="review-empty" colspan="6">Belum ada data review.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
