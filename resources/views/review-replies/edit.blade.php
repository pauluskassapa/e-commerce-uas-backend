@extends('layouts.app')

@section('content')
    @include('reviews.partials.styles')

    <section class="review-page" aria-labelledby="reply-edit-title">
        <a class="review-back" href="{{ route('reviews.show', $reviewReply->review) }}">Kembali</a>

        <div class="review-heading">
            <div>
                <p class="review-kicker">Edit balasan seller</p>
                <h2 id="reply-edit-title">{{ $reviewReply->review?->product?->name ?? 'Produk' }}</h2>
            </div>
            <span class="review-seller-label">Seller</span>
        </div>

        @include('reviews.partials.feedback')

        <div class="review-text">{{ $reviewReply->review?->comment ?? 'Tidak ada komentar.' }}</div>

        <form class="review-form review-form-spaced" method="post" action="{{ route('review-replies.update', $reviewReply) }}">
            @csrf
            @method('put')

            <label>
                Balasan
                <textarea name="message" rows="5" maxlength="1000" required>{{ old('message', $reviewReply->message) }}</textarea>
            </label>

            <button class="review-action" type="submit">Update Balasan</button>
        </form>
    </section>
@endsection
