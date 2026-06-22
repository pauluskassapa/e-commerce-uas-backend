@extends('layouts.app')

@section('content')
    @include('reviews.partials.styles')

    <article class="review-page" aria-labelledby="reply-detail-title">
        <a class="review-back" href="{{ route('review-replies.index') }}">Kembali</a>

        <div class="review-heading">
            <div>
                <p class="review-kicker">Tanggapan seller</p>
                <h2 id="reply-detail-title">Detail Balasan</h2>
            </div>
            <span class="review-seller-label">Seller</span>
        </div>

        <div class="review-detail-grid">
            <div class="review-detail-item">
                <span>Seller</span>
                <strong>{{ $reviewReply->user?->name ?? '-' }}</strong>
            </div>
            <div class="review-detail-item">
                <span>Review</span>
                <strong>#{{ $reviewReply->review_id }}</strong>
            </div>
            <div class="review-detail-item">
                <span>Dibuat</span>
                <strong>{{ $reviewReply->created_at?->format('d M Y H:i') ?? '-' }}</strong>
            </div>
        </div>

        <p class="review-text">{{ $reviewReply->message }}</p>
    </article>
@endsection
