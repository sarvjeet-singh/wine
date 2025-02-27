<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\CmsPage;

class CmsPageController extends Controller
{
    public function __construct() {}

    public function index()
    {
        return view('cms.index');
    }

    public function refundPolicy()
    {
        $refundPolicy = CmsPage::where('slug', 'refund-policy')->first();
        return view('admin.cms.refund-policy.edit', compact('refundPolicy'));
    }

    public function updateRefundPolicy(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|array', // Ensure it's an array before serializing
        ]);

        

        // Find the existing refund policy page or create a new instance
        $cmsPage = CmsPage::firstOrNew(['slug' => 'refund-policy']);

        // Update values
        $cmsPage->title = $request->title;
        $cmsPage->description = $request->description; // Auto-serialized via model accessor
        $cmsPage->status = 1;
        $cmsPage->slug = 'refund-policy';

        // Save to DB (handles both insert and update)
        $cmsPage->save();

        return redirect()->route('admin.cms.refund-policy')->with('success', 'Refund Policy updated successfully!');
    }
}
