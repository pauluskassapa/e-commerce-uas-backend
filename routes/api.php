<?php

use App\Http\Controllers\Reviews\ReviewController;
use App\Http\Controllers\Reviews\ReviewReplyController;
use Illuminate\Support\Facades\Route;

Route::prefix('review')->name('api.review.')->controller(ReviewController::class)->group(function (): void {
    Route::get('/', 'apiIndex')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('/{review}', 'apiShow')->name('show');
    Route::put('/{review}', 'update')->name('update');
    Route::patch('/{review}', 'update')->name('patch');
    Route::delete('/{review}', 'destroy')->name('destroy');
});

Route::prefix('review-replies')->name('api.review-replies.')->controller(ReviewReplyController::class)->group(function (): void {
    Route::get('/', 'apiIndex')->name('index');
    Route::post('/', 'store')->name('store');
    Route::get('/{reviewReply}', 'apiShow')->name('show');
    Route::put('/{reviewReply}', 'update')->name('update');
    Route::patch('/{reviewReply}', 'update')->name('patch');
    Route::delete('/{reviewReply}', 'destroy')->name('destroy');
});
