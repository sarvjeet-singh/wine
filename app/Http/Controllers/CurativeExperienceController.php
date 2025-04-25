<?php

namespace App\Http\Controllers;

use App\Models\CurativeExperience;
use App\Models\CurativeExperienceCategory;
use App\Models\CurativeExperienceGenre;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminEventSubmissionMail;
use Illuminate\Support\Collection;

class CurativeExperienceController extends Controller
{

    public function index(Request $request, $vendor_id)
    {
        $experiences = CurativeExperience::with('category')
            ->where('vendor_id', $vendor_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $vendor = Vendor::find($vendor_id);
        return view('VendorDashboard.curative-experiences.index', compact('experiences', 'vendor'));
    }

    public function create(Request $request, $vendor_id)
    {
        $vendor = Vendor::find($vendor_id);
        $categories = CurativeExperienceCategory::where('status', 'active')->orderBy('position', 'asc')->pluck('name', 'id');
        $genres = CurativeExperienceGenre::where('status', 'active')->orderBy('position', 'asc')->pluck('name', 'id');
        return view('VendorDashboard.curative-experiences.form', compact('categories', 'vendor', 'genres'));
    }

    public function store(Request $request, $vendorid)
    {
        $baseRules = [
            'is_published' => 'required|boolean',
            'category_id' => 'exists:curative_experience_categories,id',
            'name' => 'string|max:255',
            'genre_id' => 'exists:curative_experience_genres,id',
            'admittance' => 'nullable|numeric', // not required unless both conditions are met
            'media_type' => 'nullable|string|in:image,youtube',
            'youtube_url' => 'nullable|url',
            'is_free'  => 'nullable|boolean',
            'extension'  => 'nullable|string',
            'booking_url' => 'nullable|url',
            'inventory' => 'nullable|integer',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'booking_time' => 'nullable|date_format:H:i',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer|min:1|max:1440',
            'image' => 'nullable|file|mimes:jpg,png,jpeg,gif,webp|max:5120',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zipcode' => 'nullable|string',
            'venue_name' => 'nullable|string|max:255',
            'venue_phone' => 'nullable|string|max:255',
            'event_rating' => 'nullable|string|max:255',
        ];

        if ($request->is_published == 1) {
            // When published, enforce required rules
            $rules = array_merge($baseRules, [
                'category_id' => 'required|exists:curative_experience_categories,id',
                'genre_id' => 'required|exists:curative_experience_genres,id',
                'name' => 'required|string|max:255',
                'admittance' => 'required_if:is_free,0',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'address' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'state' => 'required|string|max:255',
                'zipcode' => 'nullable|string|max:255',
                'media_type' => 'required|string|in:image,youtube',
                'image' => 'nullable|file|mimes:jpg,png,jpeg,gif,webp|max:5120',
                'youtube_url' => 'nullable|url',
                'venue_name' => 'required|string|max:255',
                'venue_phone' => 'required|string|max:255',
                'event_rating' => 'required|string|max:255',
                'description' => 'required|string',
            ]);
        } else {
            // When not published, only a few fields are required
            $rules = array_merge($baseRules, [
                'category_id' => 'required|exists:curative_experience_categories,id',
                'name' => 'required|string|max:255',
                'genre_id' => 'required|exists:curative_experience_genres,id',
            ]);
        }
        $request->validate($rules, [
            'category_id.required' => 'The category field is required.',
            'category_id.exists' => 'The selected category is invalid.'
        ]);
        $image = '';
        $thumbnails = [];
        if ($request->media_type == 'youtube') {
            $image = $request->youtube_url;
            $thumbnails['small'] = '';
            $thumbnails['medium'] = '';
            $thumbnails['large'] = '';
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('curative_experience_medias', $filename, 'public');

            if ($path) {
                // Create thumbnails with aspect ratio
                $sizes = [
                    'small'  => [100, 63],   // 2:1 Aspect Ratio
                    'medium' => [600, 375],  // 2:1 Aspect Ratio (Main)
                    'large'  => [1000, 625],  // 2:1 Aspect Ratio
                ];

                foreach ($sizes as $sizeName => [$width, $height]) {
                    $thumbnailFilename = pathinfo($filename, PATHINFO_FILENAME) . "_{$sizeName}." . pathinfo($filename, PATHINFO_EXTENSION);
                    $thumbnailPath = "curative_experience_medias/{$thumbnailFilename}";

                    // Resize image
                    $imageResize = Image::make($file)->fit($width, $height);
                    Storage::disk('public')->put($thumbnailPath, (string) $imageResize->encode());

                    // Store generated thumbnail path
                    $thumbnails[$sizeName] = "{$thumbnailPath}";
                }

                // Save the original image path
                $image = "{$path}";
            }
        }

        $data = $request->all();
        $data['vendor_id'] = $vendorid;
        $data['image'] = $image;
        $data['thumbnail_small'] = $thumbnails['small'] ?? null;
        $data['thumbnail_medium'] = $thumbnails['medium'] ?? null;
        $data['thumbnail_large'] = $thumbnails['large'] ?? null;

        if (!isset($request->is_free)) {
            $data['is_free'] = 0;
        }
        $data['status'] = 'inactive';
        // Create experience
        $curativeExperience = CurativeExperience::create($data);
        // if(isset($request->is_published) && $request->is_published == 1) {
        //     return redirect()->route('curative-experiences.index', $vendorid)->with('success', 'Your event will appear once system admin approves it.');
        // }
        if ($curativeExperience->is_published == 1 && $curativeExperience->status == 'inactive') {
            // Send email to admin
            $curativeExperience->load('vendor');
            $curativeExperience->load('category');
            Mail::to(env('ADMIN_EMAIL'))->send(new AdminEventSubmissionMail($curativeExperience));
            return redirect()->route('curative-experiences.index', $vendorid)->with('success', 'Your event will appear once system admin approves it.');
        }
        return redirect()->route('curative-experiences.index', $vendorid)->with('success', 'Event draft has been saved successfully.');
    }

    public function edit(Request $request, $id, $vendor_id)
    {
        $categories = CurativeExperienceCategory::where('status', 'active')->orderBy('position', 'asc')->pluck('name', 'id');
        $genres = CurativeExperienceGenre::where('status', 'active')->orderBy('position', 'asc')->pluck('name', 'id');
        $vendor = Vendor::find($vendor_id);
        $experience = CurativeExperience::findOrFail($id);
        if (isset($experience->image) && (str_contains($experience->image, 'youtube') || str_contains($experience->image, 'youtu.be'))) {
            $experience->media_type = 'youtube';
            $experience->youtube_url = $experience->image;
            $experience->image = null;
        }
        // print_r($experience); die;
        return view('VendorDashboard.curative-experiences.form', compact('experience', 'categories', 'vendor', 'genres'));
    }

    public function update(Request $request, $id, $vendorid)
    {
        $curativeExperience = CurativeExperience::find($id);
        if (!$curativeExperience) {
            return redirect()->back()->with('error', 'Experience not found.');
        }
        if ($curativeExperience->is_published == 1) {
            unset($request['is_published']);
            $request->validate([
                'name' => 'required|string|max:255',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'admittance' => 'required_if:is_free,0',
                'duration' => 'nullable|integer|min:1|max:1440',
                'media_type' => 'required|string|in:image,youtube',
                'image' => 'nullable|file|mimes:jpg,png,jpeg,gif,webp|max:5120',
                'youtube_url' => 'nullable|url',
                'extension' => 'nullable|string',
                'inventory' => 'nullable|integer',
                'quantity' => 'nullable|integer',
                'description' => 'required|string',
            ]);
        } else {
            $baseRules = [
                'is_published' => 'required|boolean',
                'category_id' => 'exists:curative_experience_categories,id',
                'name' => 'string|max:255',
                'genre_id' => 'exists:curative_experience_genres,id',
                'admittance' => 'nullable|numeric', // not required unless both conditions are met
                'media_type' => 'required|string|in:image,youtube',
                'image' => 'nullable|file|mimes:jpg,png,jpeg,gif,webp|max:5120',
                'youtube_url' => 'nullable|url',
                'is_free'  => 'nullable|boolean',
                'extension'  => 'nullable|string',
                'booking_url' => 'nullable|url',
                'inventory' => 'nullable|integer',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'booking_time' => 'nullable|date_format:H:i',
                'description' => 'nullable|string',
                'duration' => 'nullable|integer|min:1|max:1440',
                'address' => 'nullable|string',
                'city' => 'nullable|string',
                'state' => 'nullable|string',
                'zipcode' => 'nullable|string',
                'venue_name' => 'nullable|string|max:255',
                'venue_phone' => 'nullable|string|max:255',
                'event_rating' => 'nullable|string|max:255',
            ];

            if ($request->is_published == 1) {
                // When published, enforce required rules
                $rules = array_merge($baseRules, [
                    'category_id' => 'required|exists:curative_experience_categories,id',
                    'genre_id' => 'required|exists:curative_experience_genres,id',
                    'name' => 'required|string|max:255',
                    'admittance' => 'required_if:is_free,0',
                    'start_date' => 'required|date',
                    'end_date' => 'nullable|date|after_or_equal:start_date',
                    'address' => 'required|string|max:255',
                    'city' => 'required|string|max:255',
                    'state' => 'required|string|max:255',
                    'zipcode' => 'nullable|string|max:255',
                    'media_type' => 'required|string|in:image,youtube',
                    'image' => 'nullable|file|mimes:jpg,png,jpeg,gif,webp|max:5120',
                    'youtube_url' => 'nullable|url',
                    'venue_name' => 'required|string|max:255',
                    'venue_phone' => 'required|string|max:255',
                    'event_rating' => 'required|string|max:255',
                    'description' => 'required|string',
                ]);
            } else {
                // When not published, only a few fields are required
                $rules = array_merge($baseRules, [
                    'category_id' => 'required|exists:curative_experience_categories,id',
                    'name' => 'required|string|max:255',
                    'genre_id' => 'required|exists:curative_experience_genres,id',
                ]);
            }
            $request->validate($rules, [
                'category_id.required' => 'The category field is required.',
                'category_id.exists' => 'The selected category is invalid.'
            ]);
        }
        $image = '';
        $thumbnails = [];
        if ($request->media_type == 'youtube') {
            $image = $request->youtube_url;
            $thumbnails['small'] = '';
            $thumbnails['medium'] = '';
            $thumbnails['large'] = '';
            if (!empty($curativeExperience->image) && !(
                str_contains($curativeExperience->image, 'youtube') ||
                str_contains($curativeExperience->image, 'youtu.be')
            )) {
                $oldImagePath = str_replace('/storage/', '', $curativeExperience->image);

                if (Storage::disk('public')->exists($oldImagePath)) {
                    Storage::disk('public')->delete($oldImagePath);
                }

                // Get filename and extension dynamically
                $fileInfo = pathinfo($oldImagePath);
                $basename = $fileInfo['filename']; // Filename without extension
                $extension = $fileInfo['extension']; // File extension

                // Delete old thumbnails dynamically
                foreach (['small', 'medium', 'large'] as $size) {
                    $oldThumbPath = "{$fileInfo['dirname']}/{$basename}_{$size}.{$extension}";

                    if (Storage::disk('public')->exists($oldThumbPath)) {
                        Storage::disk('public')->delete($oldThumbPath);
                    }
                }
            }
        }
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('curative_experience_medias', $filename, 'public');

            if ($path) {
                if (!empty($curativeExperience->image) && !(
                    str_contains($curativeExperience->image, 'youtube') ||
                    str_contains($curativeExperience->image, 'youtu.be')
                )) {
                    $oldImagePath = str_replace('/storage/', '', $curativeExperience->image);

                    if (Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }

                    // Get filename and extension dynamically
                    $fileInfo = pathinfo($oldImagePath);
                    $basename = $fileInfo['filename']; // Filename without extension
                    $extension = $fileInfo['extension']; // File extension

                    // Delete old thumbnails dynamically
                    foreach (['small', 'medium', 'large'] as $size) {
                        $oldThumbPath = "{$fileInfo['dirname']}/{$basename}_{$size}.{$extension}";

                        if (Storage::disk('public')->exists($oldThumbPath)) {
                            Storage::disk('public')->delete($oldThumbPath);
                        }
                    }
                }

                // Create thumbnails
                $sizes = [
                    'small'  => [100, 63],   // 2:1 Aspect Ratio
                    'medium' => [600, 375],  // 2:1 Aspect Ratio (Main)
                    'large'  => [1000, 625],  // 2:1 Aspect Ratio
                ];

                foreach ($sizes as $sizeName => [$width, $height]) {
                    $thumbnailFilename = pathinfo($filename, PATHINFO_FILENAME) . "_{$sizeName}." . pathinfo($filename, PATHINFO_EXTENSION);
                    $thumbnailPath = "curative_experience_medias/{$thumbnailFilename}";

                    // Resize image
                    $imageResize = Image::make($file)
                        ->fit($width, $height);

                    Storage::disk('public')->put($thumbnailPath, (string) $imageResize->encode());

                    // Store generated thumbnail path
                    $thumbnails[$sizeName] = "{$thumbnailPath}";
                }

                // Save the original image path
                $image = "{$path}";
            }
        }
        $data = $request->all();
        // Find the existing record
        $data['vendor_id'] = $vendorid;
        if (!empty($image)) {
            $data['image'] = $image;
            $data['thumbnail_small'] = $thumbnails['small'] ?? null;
            $data['thumbnail_medium'] = $thumbnails['medium'] ?? null;
            $data['thumbnail_large'] = $thumbnails['large'] ?? null;
        }

        if (!isset($request->is_free)) {
            $data['is_free'] = 0;
        }

        // If not found, return an error
        if (!$curativeExperience) {
            return redirect()->back()->with('error', 'Experience not found.');
        }

        // Update the record
        $curativeExperience->update($data); // Don't update medias here
        if ($curativeExperience->is_published == 1 && $curativeExperience->status == 'inactive') {
            // Send email to admin
            $curativeExperience->load('vendor');
            $curativeExperience->load('category');
            Mail::to(env('ADMIN_EMAIL'))->send(new AdminEventSubmissionMail($curativeExperience));
            return redirect()->route('curative-experiences.index', $vendorid)->with('success', 'Your event will appear once system admin approves it.');
        }
        return redirect()->route('curative-experiences.index', $vendorid)->with('success', 'Experience updated successfully.');
    }

    public function destroy($id, $vendorid)
    {
        $curativeExperience = CurativeExperience::find($id);
        $curativeExperience->delete();
        return redirect()->route('curative-experiences.index', $vendorid)->with('success', 'Experience deleted successfully.');
    }

    public function preview(Request $request, $id, $vendorid)
    {
        $event = CurativeExperience::with('category')
            ->where('id', $id)
            ->first();
        $vendor = $event->vendor()->first();
        if (!$event) {
            abort(404);
        }
        $relatedEvents = collect();
        $preview = 1;
        return view('FrontEnd.events.event-details', compact('event', 'vendor', 'relatedEvents', 'preview'));
    }
}
