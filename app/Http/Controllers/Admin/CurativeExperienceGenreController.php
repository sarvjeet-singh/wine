<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\CurativeExperienceGenre;
use Illuminate\Http\Request;

class CurativeExperienceGenreController extends Controller
{
    public function index()
    {
        $genres = CurativeExperienceGenre::orderBy('position', 'asc')->paginate(10);
        return view('admin.curative-experience-genres.index', compact('genres'));
    }

    public function create()
    {
        return view('admin.curative-experience-genres.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:curative_experience_genres,name',
            'status' => 'nullable|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);
        $data = $request->all();
        $data['status'] = $request->status ?? 'inactive';
        $genre = new CurativeExperienceGenre($data);
        if ($request->hasFile('image')) {
            $genre->image = $request->file('image')->store('genres', 'public');
        }
        $genre->save();

        return redirect()->route('admin.curative-experience-genres.index')->with('success', 'Genre created successfully.');
    }

    public function edit(CurativeExperienceGenre $curative_experience_genre)
    {
        $genre = $curative_experience_genre;
        return view('admin.curative-experience-genres.form', compact('genre'));
    }

    public function update(Request $request, CurativeExperienceGenre $curative_experience_genre)
    {
        $request->validate([
            'name' => 'required|unique:curative_experience_genres,name,' . $curative_experience_genre->id,
            'status' => 'nullable|in:active,inactive',
            'image' => 'nullable|image|max:2048',
        ]);
        $data = $request->all();
        $data['status'] = $request->status ?? 'inactive';
        $curative_experience_genre->update($data);

        if ($request->hasFile('image')) {
            $curative_experience_genre->image = $request->file('image')->store('categories', 'public');
            $curative_experience_genre->save();
        }

        return redirect()->route('admin.curative-experience-genres.index')->with('success', 'Genre updated successfully.');
    }

    public function destroy(CurativeExperienceGenre $curative_experience_genre)
    {
        // Check if any curative experiences exist under this category
        if ($curative_experience_genre->curativeExperiences()->exists()) {
            return redirect()->route('admin.curative-experience-genres.index')
                ->with('error', 'Genre cannot be deleted because it has associated experiences.');
        }

        $curative_experience_genre->delete();

        return redirect()->route('admin.curative-experience-genres.index')
            ->with('success', 'Genre deleted successfully.');
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->positions as $index => $id) {
            CurativeExperienceGenre::where('id', $id)->update(['position' => $index + 1]);
        }
        return response()->json(['status' => 'success']);
    }
}
