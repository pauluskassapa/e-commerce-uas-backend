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
            <div class="review-heading-actions">
                @auth
                    @if (auth()->id() === $review->user_id)
                        <a class="review-action review-action-secondary" href="{{ route('reviews.edit', $review) }}">Edit Review</a>
                    @endif
                @endauth

                <span class="review-rating" aria-label="Rating {{ $review->rating }} dari 5">
                    {{ $review->rating }}/5
                </span>
            </div>
        </div>

        @include('reviews.partials.feedback')

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
                    @auth
                        @if (auth()->id() === $reply->user_id)
                            <a class="review-action review-action-secondary review-inline-action" href="{{ route('review-replies.edit', $reply) }}">Edit Balasan</a>
                        @endif
                    @endauth
                </div>
            @empty
                <p class="review-comment-cell">Belum ada balasan seller.</p>
            @endforelse

            @auth
                @if (auth()->user()->role === 'seller')
                    <form class="review-form review-form-spaced" method="post" action="{{ route('review-replies.store') }}">
                        @csrf
                        <input type="hidden" name="review_id" value="{{ $review->id }}">

                        <label>
                            Balasan Seller
                            <textarea name="message" rows="4" maxlength="1000" required placeholder="Tulis balasan untuk review pembeli.">{{ old('message') }}</textarea>
                        </label>

                        <button class="review-action" type="submit">Kirim Balasan</button>
                    </form>
                @endif
            @endauth
        </section>
    </article>
@endsection
