<?php

namespace App\Http\Controllers;

use App\Models\CurativeExperience;
use App\Models\CurativeExperienceCategory;
use App\Models\CurativeExperienceMedia;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CurativeExperienceController extends Controller
{

    public function index(Request $request, $vendor_id)
    {
        $experiences = CurativeExperience::with('category')->paginate(10);
        $vendor = Vendor::find($vendor_id);
        return view('VendorDashboard.curative-experiences.index', compact('experiences', 'vendor'));
    }

    public function create(Request $request, $vendor_id)
    {
        $vendor = Vendor::find($vendor_id);
        $categories = CurativeExperienceCategory::orderBy('position', 'asc')->pluck('name', 'id');
        return view('VendorDashboard.curative-experiences.form', compact('categories', 'vendor'));
    }

    public function store(Request $request, $vendorid)
    {
        $request->validate([
            'category_id' => 'required|exists:curative_experience_categories,id',
            'name' => 'required|string|max:255',
            'admittance' => 'required',
            'is_free'  => 'nullable|boolean',
            'extension'  => 'required|string',
            'booking_url' => 'nullable|url',
            'inventory' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'description' => 'nullable|string',
            'medias.*' => 'nullable|file|mimes:jpg,png,jpeg,gif,mp4|max:2048'
        ], [
            'category_id.required' => 'The category field is required.',
            'category_id.exists' => 'The selected category is invalid.'
        ]);

        $data = $request->all();
        $data['vendor_id'] = $vendorid;

        // Create experience
        $experience = CurativeExperience::create($data);

        // Handle media uploads
        if ($request->hasFile('medias')) {
            foreach ($request->file('medias') as $file) {
                $path = $file->store('curative_experience_medias', 'public');
                CurativeExperienceMedia::create([
                    'experience_id' => $experience->id,
                    'file_path' => $path
                ]);
            }
        }

        return redirect()->route('curative-experiences.index')->with('success', 'Experience created successfully.');
    }

    public function edit(Request $request, $id, $vendor_id)
    {
        $categories = CurativeExperienceCategory::orderBy('position', 'asc')->pluck('name', 'id');
        $vendor = Vendor::find($vendor_id);
        $experience = CurativeExperience::findOrFail($id);
        // print_r($experience); die;
        return view('VendorDashboard.curative-experiences.form', compact('experience', 'categories', 'vendor'));
    }

    public function update(Request $request, $id, $vendorid)
    {
        $request->validate([
            'category_id' => 'required|exists:curative_experience_categories,id',
            'name' => 'required|string|max:255',
            'admittance' => 'required',
            'is_free'  => 'nullable|boolean',
            'extension'  => 'required|string',
            'booking_url' => 'nullable|url',
            'inventory' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'description' => 'nullable|string',
            'medias.*' => 'nullable|file|mimes:jpg,png,jpeg,gif,mp4|max:2048'
        ], [
            'category_id.required' => 'The category field is required.',
            'category_id.exists' => 'The selected category is invalid.'
        ]);
        // Find the existing record
        $curativeExperience = CurativeExperience::find($id);
        $data = $request->except('medias');
        $data['vendor_id'] = $vendorid;

        // If not found, return an error
        if (!$curativeExperience) {
            return redirect()->back()->with('error', 'Experience not found.');
        }

        // Update the record
        $curativeExperience->update($data); // Don't update medias here
        if ($request->hasFile('medias') && is_array($request->file('medias'))) {
            foreach ($request->file('medias') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('curative_experience_medias', 'public');
                    CurativeExperienceMedia::create([
                        'experience_id' => $curativeExperience->id,
                        'file_path' => $path
                    ]);
                }
            }
        }

        return redirect()->route('curative-experiences.index')->with('success', 'Experience updated successfully.');
    }

    public function destroy(CurativeExperience $curativeExperience)
    {
        $curativeExperience->delete();
        return redirect()->route('curative-experiences.index')->with('success', 'Experience deleted successfully.');
    }
}
