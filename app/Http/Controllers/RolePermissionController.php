<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionController extends Controller
{
    public function assignPermission(Request $request, Role $role)
    {
        $request->validate(['permissions' => 'required|array']);
        $role->syncPermissions($request->permissions); // Assign multiple permissions
        return back()->with('success', 'Permissions assigned successfully.');
    }

    public function unassignPermission(Role $role, Permission $permission)
    {
        $role->revokePermissionTo($permission);
        return back()->with('success', 'Permission unassigned successfully.');
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate(['roles' => 'required|array']);
        $user->syncRoles($request->roles); // Assign multiple roles
        return back()->with('success', 'Roles assigned successfully.');
    }

    public function unassignRole(User $user, Role $role)
    {
        $user->removeRole($role);
        return back()->with('success', 'Role unassigned successfully.');
    }
}
