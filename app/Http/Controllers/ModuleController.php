<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Module;
use Str;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modules = Module::paginate(10);
        return view('admin.modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.modules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:modules',
            'slug' => 'nullable|string|unique:modules',
            'description' => 'nullable|string', 
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg',
            'url' => 'nullable|string',
            'status' => 'nullable|in:active,inactive',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }
        $data['slug'] = Str::slug($request->name);
        $data['type'] = 'admin';
        $data['status'] = $request->status ?? 'active';


        Module::create($data);

        return redirect()->route('admin.modules.index')->with('success', 'Module created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $module = Module::findOrFail($id);
        return view('admin.modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $module = Module::findOrFail($id);
        return view('admin.modules.edit', compact('module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:modules',
            'slug' => 'nullable|string|unique:modules',
            'description' => 'nullable|string', 
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg',
            'url' => 'nullable|string',
            'status' => 'nullable',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
            $data['image'] = $imageName;
        }

        $data['slug'] = Str::slug($request->name);
        $data['status'] = $request->status ?? 1;

        $module = Module::findOrFail($id);
        $module->update($data);

        return redirect()->route('admin.modules.index')->with('success', 'Module updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $module = Module::findOrFail($id);
        $module->delete();
        return redirect()->route('admin.modules.index')->with('success', 'Module deleted successfully.');
    }
}
