<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WineReview;
use Auth;

class WineReviewController extends Controller
{
    public function store(Request $request, $vendorid)
    {
        $request->validate([
            'product_id' => 'required|exists:vendor_wines,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:500',

        ]);

        WineReview::create([
            'user_id' => Auth::id(),
            'vendor_wine_id' => $request->product_id,
            'rating' => $request->rating,
            'review_description' => $request->review,
            'vendor_id' => $vendorid,
            'review_status' => 'approved'
        ]);

        return redirect()->back()->with('success', 'Thank you for your review!');
    }
}
