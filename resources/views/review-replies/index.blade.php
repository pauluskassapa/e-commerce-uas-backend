@extends('layouts.app')

@section('content')
    @include('reviews.partials.styles')

    <section class="review-page" aria-labelledby="reply-list-title">
        <div class="review-heading">
            <div>
                <p class="review-kicker">Tanggapan seller</p>
                <h2 id="reply-list-title">Balasan Review</h2>
            </div>
            <div class="review-count">
                <strong>{{ $replies->count() }}</strong>
                <span>balasan</span>
            </div>
        </div>

        <div class="review-table-shell">
            <table class="review-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Review</th>
                        <th>Seller</th>
                        <th>Pesan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($replies as $reply)
                        <tr>
                            <td>#{{ $reply->id }}</td>
                            <td>Review #{{ $reply->review_id }}</td>
                            <td>
                                {{ $reply->user?->name ?? '-' }}
                                <span class="review-seller-label">Seller</span>
                            </td>
                            <td class="review-comment-cell">{{ $reply->message }}</td>
                            <td>
                                <a class="review-action" href="{{ route('review-replies.show', $reply) }}">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="review-empty" colspan="5">Belum ada balasan review.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
