<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorController extends Controller
{
    // List All Doctors
    public function index()
    {
        $doctors = User::with('userDetails')->where('role_id',1)->get(); 
        return view('admin.doctors.index', compact('doctors' ));
    }
    // Store New Doctor using AJAX
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        $doctor = Doctor::create([
            'employee_id' => $request->employee_id,
        ]);

        return response()->json(['success' => true, 'message' => 'Doctor added successfully.', 'doctor' => $doctor]);
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

    // Update Doctor using AJAX
    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        $doctor->update([
            'employee_id' => $request->employee_id,
        ]);

        return response()->json(['success' => true, 'message' => 'Doctor updated successfully.', 'doctor' => $doctor]);
    }

    // Delete Doctor using AJAX
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return response()->json(['success' => true, 'message' => 'Doctor deleted successfully.']);
    }
}
