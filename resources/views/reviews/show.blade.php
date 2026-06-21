@extends('layouts.app')

@section('content')
    @include('reviews.partials.styles')

    <article class="review-page" aria-labelledby="review-detail-title">
        <a class="review-back" href="{{ route('reviews.index') }}">Kembali</a>

        <div class="review-heading">
            <div>
                <p class="review-kicker">Detail review</p>
                <h2 id="review-detail-title">{{ $review->product?->name ?? 'Produk' }}</h2>
            </div>
            <span class="review-rating" aria-label="Rating {{ $review->rating }} dari 5">
                {{ $review->rating }}/5
            </span>
        </div>

        <div class="review-detail-grid">
            <div class="review-detail-item">
                <span>Pembeli</span>
                <strong>{{ $review->user?->name ?? '-' }}</strong>
            </div>
            <div class="review-detail-item">
                <span>Produk</span>
                <strong>{{ $review->product?->name ?? '-' }}</strong>
            </div>
            <div class="review-detail-item">
                <span>Dibuat</span>
                <strong>{{ $review->created_at?->format('d M Y H:i') ?? '-' }}</strong>
            </div>
        </div>

        <p class="review-text">{{ $review->comment ?? 'Tidak ada komentar.' }}</p>

        <section class="review-replies" aria-labelledby="review-replies-title">
            <h3 id="review-replies-title">Balasan Seller</h3>

            @forelse ($review->replies as $reply)
                <div class="review-reply-row">
                    <span class="review-reply-meta">
                        {{ $reply->user?->name ?? 'Seller' }}
                        <span class="review-seller-label">Seller</span>
                    </span>
                    <p>{{ $reply->message }}</p>
                </div>
            @empty
                <p class="review-comment-cell">Belum ada balasan seller.</p>
            @endforelse
        </section>
    </article>
@endsection
