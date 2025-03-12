<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class PermissionController extends Controller
{
    public function create()
    {
        $modelFiles = File::files(app_path('Models'));
        
        // Extract class names from the file names (without the .php extension)
        $models = collect($modelFiles)
            ->map(function ($file) {
                return basename($file, '.php');
            })
            ->toArray();
            $permissionsByModel = Permission::all()->groupBy('model_name');    
    
        return view('admin.permission.create', compact('models','permissionsByModel'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'model_name' => 'required|string',
            'permissions' => 'required|array'
        ]);

        foreach ($request->permissions as $perm) {
            Permission::create([
                'model_name' => $request->model_name,
                'name' => "{$perm}_{$request->model_name}"
            ]);
        }

        return redirect()->back()->with('success', 'Permissions added successfully.');
    }
}
