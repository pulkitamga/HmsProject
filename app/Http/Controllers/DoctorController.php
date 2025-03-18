<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Employee;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    // List All Doctors
    public function index()
    {
        $doctors = User::with('userDetails')->where('role_id',2)->get(); 
        $roles = Role::where('status', 1)->get();
        return view('admin.doctors.index', compact('doctors','roles' ));
    }
    // Get Doctor Details
    public function show($id)
    {
        $doctor = User::with('role')->where('id',$id)->first();
        if (!$doctor) {
            return response()->json(['success' => false, 'message' => 'Doctor not found.'], 404);
        }
        return response()->json(['success' => true, 'data' => $doctor]);
    }

    public function edit($id)
    {
        $doctor = User::where('id', $id)->where('role_id', 1)->first();
        
        if (!$doctor) {
            return redirect()->route('admin.doctors.index')->with('error', 'Doctor not found.');
        }

        // Redirect to UserController edit function
        return redirect()->route('admin.users.update', ['id' => $doctor->id]);
    }

}
