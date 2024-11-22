<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(Request $request) {
        $permissions = Permission::latest()->paginate(2);
        $edit = false;
        $permissionRoles = [];
        if ($request->edit) {
            $edit = Permission::find($request->edit);
            $permissionRoles = $edit->roles->pluck('name')->toArray();
        }
        $roles = Role::latest()->get();
        return view('admin.authorize.permissions.indexPermissions', compact('permissions', 'roles', 'edit', 'permissionRoles'));
    }

    public function store(Request $request) {
        $request->validate([
            'permission' => 'required|min:3'
        ]);

        $permission = Permission::create([
            'name' => $request->permission,
            'guard_name' => 'web'
        ]);

        $permission->syncRoles($request->roles);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully');
    }

    public function update(Request $request, Permission $permission) {
        $request->validate([
            'permission' => 'required|min:3'
        ]);

        $permission->update([
            'name' => $request->permission,
        ]);

        $permission->syncRoles($request->roles);

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully');
    }


    public function destroy(Permission $permission) {

        $permission->delete();


        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully');
    }
}
