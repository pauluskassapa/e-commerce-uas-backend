@extends('layouts.app')

@section('content')
    @include('reviews.partials.styles')

    <section class="review-page" aria-labelledby="review-edit-title">
        <a class="review-back" href="{{ route('reviews.show', $review) }}">Kembali</a>

        <div class="review-heading">
            <div>
                <p class="review-kicker">Edit review</p>
                <h2 id="review-edit-title">{{ $review->product?->name ?? 'Produk' }}</h2>
            </div>
            <span class="review-rating">{{ $review->rating }}/5</span>
        </div>

        @include('reviews.partials.feedback')

        <form class="review-form" method="post" action="{{ route('reviews.update', $review) }}">
            @csrf
            @method('put')

            <label>
                Rating
                <select name="rating" required>
                    @for ($rating = 5; $rating >= 1; $rating--)
                        <option value="{{ $rating }}" @selected((int) old('rating', $review->rating) === $rating)>
                            {{ $rating }}/5
                        </option>
                    @endfor
                </select>
            </label>

            <label>
                Komentar
                <textarea name="comment" rows="5" maxlength="1000">{{ old('comment', $review->comment) }}</textarea>
            </label>

            <button class="review-action" type="submit">Update Review</button>
        </form>
    </section>
@endsection
