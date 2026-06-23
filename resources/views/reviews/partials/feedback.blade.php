@if (session('success'))
    <div class="review-alert review-alert-success">{{ session('success') }}</div>
@endif

@if ($errors->any())
    <div class="review-alert review-alert-error">
        {{ $errors->first() }}
    </div>
@endif
