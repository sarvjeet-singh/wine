<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::paginate(10);
        return view('admin.permissions.index', compact('permissions')); // Create `permissions/index.blade.php`
    }

    public function create()
    {
        return view('admin.permissions.create'); // Create `permissions/create.blade.php`
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:permissions',
            'module' => 'required|exists:modules,slug',
        ]);

        $data['type'] = 'admin';

        Permission::create($data);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created successfully.');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission')); // Create `permissions/edit.blade.php`
    }

    public function update(Request $request, Permission $permission)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update($data);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted successfully.');
    }
}
