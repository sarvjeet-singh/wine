<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\CurativeExperience;
use App\Models\CurativeExperienceCategory;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CurativeExperienceController extends Controller
{
    public function index(Request $request)
    {
        $query = CurativeExperience::with('vendor')
            ->where('is_published', 1);
        if ($request->has('vendor')) {
            $query->whereHas('vendor', function ($q) use ($request) {
                $q->where('vendor_name', 'like', '%' . $request->vendor . '%');
            });
        }

        if ($request->has('experience')) {
            $query->where('name', 'like', '%' . $request->experience . '%');
        }
        $experiences = $query->orderBy('id', 'desc')->paginate(10);
        return view('admin.curative-experiences.index', compact('experiences'));
    }

    public function search(Request $request)
    {
        if ($request->has('vendor')) {
            $vendors = Vendor::where('vendor_name', 'like', '%' . $request->vendor . '%')
                ->pluck('vendor_name');
            return response()->json($vendors);
        }

        if ($request->has('experience')) {
            $experiences = CurativeExperience::where('name', 'like', '%' . $request->experience . '%')
                ->where('is_published', 1)
                ->pluck('name');
            return response()->json($experiences);
        }

        return response()->json([]);
    }

    public function show($id)
    {
        $categories = CurativeExperienceCategory::orderBy('position', 'asc')->pluck('name', 'id');
        $experience = CurativeExperience::findOrFail($id);
        return view('admin.curative-experiences.form', compact('experience', 'categories'));
    }

    public function edit() {}

    public function store() {}

    public function update() {}

    public function destroy() {}

    public function toggleStatus(Request $request)
    {
        $experience = CurativeExperience::findOrFail($request->id);

        // Toggle status
        $experience->status = $experience->status === 'active' ? 'inactive' : 'active';
        $experience->save();

        return response()->json([
            'success' => true,
            'status' => $experience->status
        ]);
    }

    public function toggleFeatured(Request $request)
    {
        $experience = CurativeExperience::findOrFail($request->id);

        // Toggle status
        $experience->is_featured = $experience->is_featured === 'active' ? 'inactive' : 'active';
        $experience->save();

        return response()->json([
            'success' => true,
            'status' => $experience->is_featured
        ]);
    }
    public function bulkStatusUpdate(Request $request)
    {
        $request->validate([
            'experiences' => 'required|array',
            'experiences.*' => 'exists:curative_experiences,id',
            'status' => 'required|in:active,inactive',
        ]);

        try {
            CurativeExperience::whereIn('id', $request->experiences)->update(['status' => $request->status]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }
}
