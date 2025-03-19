<?php

namespace App\Http\Controllers;
use App\Models\Role;
use App\Models\User;
use App\Models\Nurse;
use Illuminate\Http\Request;

class NurseController extends Controller
{
    public function index()
    {
        $nurses = Nurse::with(['user', 'user.userDetails'])->get();
        $roles = Role::where('status', 1)->get();
        return view('admin.nurse.index', compact('nurses','roles'));
    }

    public function show($id)
    {
        $nurse = User::with('role')->where('id', $id)->first();
        if (!$nurse) {
            return response()->json([
                'success' => false,
                'message' => 'Nurse not found.'
            ], 404);
        }
        return response()->json(['success' => true, 'data' => $nurse]);
    }
}
