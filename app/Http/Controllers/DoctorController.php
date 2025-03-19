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
        $doctors = Doctor::with(['user', 'user.userDetails'])->get();
        $roles = Role::where('status', 1)->get();
        return view('admin.doctors.index', compact('doctors','roles' ));
    }
    // Get Doctor Details
    public function show($id)
    {
        // Fetch doctor with related user, role, and userDetails
        $doctor = Doctor::with(['user.role', 'user.userDetails'])->where('id', $id)->first();
    
        if (!$doctor) {
            return response()->json(['success' => false, 'message' => 'Doctor not found.'], 404);
        }
    
        if (!empty($doctor->user->userDetails->specialization)) {
            $doctor->user->userDetails->specialization = explode(',', $doctor->user->userDetails->specialization);
        }
    
        return response()->json(['success' => true, 'data' => $doctor]);
    }
    

}
