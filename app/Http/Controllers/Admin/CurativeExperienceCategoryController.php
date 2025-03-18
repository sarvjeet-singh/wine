<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\CurativeExperienceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CurativeExperienceCategoryController extends Controller
{
    public function index()
    {
        $categories = CurativeExperienceCategory::orderBy('position', 'asc')->paginate(10);
        return view('admin.curative-experience-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.curative-experience-categories.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:curative_experience_categories,name',
            'status' => 'nullable|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);
        $data = $request->all();
        $data['status'] = $request->status ?? 'inactive';
        $category = new CurativeExperienceCategory($data);
        if ($request->hasFile('image')) {
            $category->image = $request->file('image')->store('categories', 'public');
        }
        $category->save();

        return redirect()->route('admin.curative-experience-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(CurativeExperienceCategory $curative_experience_category)
    {
        $category = $curative_experience_category;
        return view('admin.curative-experience-categories.form', compact('category'));
    }

    public function update(Request $request, CurativeExperienceCategory $curative_experience_category)
    {
        $request->validate([
            'name' => 'required|unique:curative_experience_categories,name,' . $curative_experience_category->id,
            'status' => 'nullable|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);
        $data = $request->all();
        $data['status'] = $request->status ?? 'inactive';
        $curative_experience_category->update($data);

        if ($request->hasFile('image')) {
            $curative_experience_category->image = $request->file('image')->store('categories', 'public');
            $curative_experience_category->save();
        }

        return redirect()->route('admin.curative-experience-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(CurativeExperienceCategory $curative_experience_category)
    {
        // Check if any curative experiences exist under this category
        if ($curative_experience_category->curativeExperiences()->exists()) {
            return redirect()->route('admin.curative-experience-categories.index')
                ->with('error', 'Category cannot be deleted because it has associated experiences.');
        }

        $curative_experience_category->delete();

        return redirect()->route('admin.curative-experience-categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->positions as $index => $id) {
            CurativeExperienceCategory::where('id', $id)->update(['position' => $index + 1]);
        }
        return response()->json(['status' => 'success']);
    }
}
