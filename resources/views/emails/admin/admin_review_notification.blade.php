@extends('emails.admin.adminLayouts.app')

@section('title', 'New Review Submitted')

@section('content')
    <div class="email-body">
        <p>Hello Admin,</p>

        <p>A new review has been submitted by <strong>{{ $review->customer->firstname }} {{ $review->customer->lastname }}</strong>.</p>

        <p><strong>Review Summary:</strong><br>
            {{ Str::limit($review->review_description, 100) }}</p>

        <p>
            <a href="{{ route('admin.reviews.show', $review->id) }}"
                style="background-color:#3490dc;color:white;padding:10px 15px;text-decoration:none;border-radius:5px;">View
                Review</a>
        </p>
    </div>
@endsection
