<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;

class PatientController extends Controller
{
    // Show all patients
    public function index()
    {
        $patients = Patient::all();
        return view('patients.index', compact('patients'));
    }

    // Show create patient form
    public function create()
    {
        return view('patients.create');
    }

    // Store new patient
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:patients',
            'phone' => 'required|string|max:20',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'address' => 'required|string',
            'blood_group' => 'required|string|max:5',
            'emergency_contact' => 'required|string|max:20',
        ]);

        // Generate a unique patient ID (e.g., PAT101, PAT102...)
        $latestPatient = Patient::latest()->first();
        $patientNumber = $latestPatient ? ((int) substr($latestPatient->patient_id, 3) + 1) : 101;
        $patient_id = 'PAT' . $patientNumber;

        // Save the patient
        Patient::create([
            'patient_id' => $patient_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'address' => $request->address,
            'blood_group' => $request->blood_group,
            'emergency_contact' => $request->emergency_contact,
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient added successfully.');
    }
}
