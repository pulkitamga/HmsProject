<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class UserRoleController extends Controller
{
    public function index()
    {
        $roles = Role::where('status', 1)->get();

        return view('admin.roles.index', compact('roles'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|unique:roles,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $role = Role::create(['name' => $request->name]);
        return response()->json(['message' => 'Role added successfully!', 'role' => $role]);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $role = Role::findOrFail($id);
        $role->update(['name' => $request->name]);
        return response()->json(['message' => 'Role updated successfully!']);
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        if ($role->status == 0) {
            return response()->json([
                'message' => 'Role already deleted!',
                'status' => 'error'
            ]);
        }

        $role->status = 0; // Soft delete Abc
        $role->save();

        return response()->json([
            'message' => 'Role deleted successfully!',
            'status' => 'success'
        ]);
    }

    public function getPermissionsByModel($model)
{
    // Fetch permissions where model_name matches the selected model
    $permissions = Permission::where('model_name', $model)->get(['id', 'name']);

    return response()->json([
        'permissions' => $permissions
    ]);
}


    public function assignpermissionsView()
    {
        // Retrieve active roles
        $roles = Role::where('status', 1)->get();

        // Retrieve models and their associated permissions from the permissions table
        $permissions = Permission::all();  // Get all permissions from the permissions table

        // Group permissions by model_name to easily display them per model
        $permissionsByModel = $permissions->groupBy('model_name');

        // Dynamically get all unique model names from the permissions table
        $models = $permissions->pluck('model_name')->unique();  // Extract unique model names

        return view('admin.roles.assignPermissions', compact('roles', 'models', 'permissionsByModel'));
    }

    public function assignPermissions(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permissions' => 'required|array'
        ]);
    
        $role = Role::find($request->role_id);
    
        // Attach selected permissions to the role
        $role->permissions()->sync($request->permissions);
    
        return response()->json(['message' => 'Permissions assigned successfully!']);
    }
    

}
