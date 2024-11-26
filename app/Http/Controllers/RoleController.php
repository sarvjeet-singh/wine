<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::paginate(10);
        return view('admin.roles.index', compact('roles')); // Create `roles/index.blade.php`
    }

    public function create()
    {
        return view('admin.roles.create'); // Create `roles/create.blade.php`
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles',
        ]);

        $data['type'] = 'admin';
        $data['vendor_id'] = null;
        $data['guard_name'] = 'web';

        Role::create($data);

        return redirect()->route('admin.roles.index')->with('success', 'Role created successfully.');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role')); // Create `roles/edit.blade.php`
    }

    public function update(Request $request, Role $role)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name,' . $role->id,
        ]);

        $role->update($data);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted successfully.');
    }
}
