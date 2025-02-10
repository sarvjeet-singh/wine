<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('vendor', 'customer')->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function show($id)
    {
        $review = Review::with('vendor', 'customer')->find($id);
        return view('admin.reviews.show', compact('review'));
    }

    public function approveReview($id)
    {
        $review = Review::findOrFail($id);
        $review->review_status = 'approved';
        $review->save();

        return response()->json(['success' => true, 'message' => 'Review approved successfully.']);
    }

    public function declineReview($id)
    {
        $review = Review::findOrFail($id);
        $review->review_status = 'declined';
        $review->save();

        return response()->json(['success' => true, 'message' => 'Review declined successfully.']);
    }
}
