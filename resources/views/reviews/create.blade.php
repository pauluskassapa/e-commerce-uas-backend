@extends('layouts.app')

@section('content')
    @include('reviews.partials.styles')

    <section class="review-page" aria-labelledby="review-create-title">
        <a class="review-back" href="{{ route('reviews.index') }}">Kembali</a>

        <div class="review-heading">
            <div>
                <p class="review-kicker">Review buyer</p>
                <h2 id="review-create-title">Tulis Review Produk</h2>
            </div>
        </div>

        @include('reviews.partials.feedback')

        @if ($products->isEmpty())
            <div class="review-empty-panel">
                Belum ada produk yang bisa direview. Review baru bisa dibuat setelah payment berstatus paid.
            </div>
        @else
            <form class="review-form" method="post" action="{{ route('reviews.store') }}">
                @csrf

                <label>
                    Produk
                    <select name="product_id" required>
                        <option value="">Pilih produk yang sudah dibayar</option>
                        @foreach ($products as $product)
                            <option value="{{ $product->id }}" @selected((int) old('product_id', $selectedProductId) === $product->id)>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label>
                    Rating
                    <select name="rating" required>
                        @for ($rating = 5; $rating >= 1; $rating--)
                            <option value="{{ $rating }}" @selected((int) old('rating', 5) === $rating)>
                                {{ $rating }}/5
                            </option>
                        @endfor
                    </select>
                </label>

                <label>
                    Komentar
                    <textarea name="comment" rows="5" maxlength="1000" placeholder="Tulis pengalaman kamu dengan produk ini.">{{ old('comment') }}</textarea>
                </label>

                <button class="review-action" type="submit">Simpan Review</button>
            </form>
        @endif
    </section>
@endsection
