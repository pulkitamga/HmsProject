<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Admission;
use App\Models\User;
use App\Models\Department;
use App\Models\Bed;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the admissions.
     */
    public function index()
    {
        $admissions = Admission::with(['patient', 'doctor', 'department', 'bed'])->get();
        return view('admin.admissions.index', compact('admissions'));
    }

    /**
     * Show the form for creating a new admission.
     */
    public function create()
    {
        $patients = Patient::all();
        $doctors = User::where('role', 'Doctor')->get();
        $departments = Department::all();
        $beds = Bed::whereNull('occupied_by')->get();

        return view('admissions.create', compact('patients', 'doctors', 'departments', 'beds'));
    }

    /**
     * Store a newly created admission in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,patient_id',
            'doctor_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'bed_id' => 'nullable|exists:beds,id',
            'admission_date' => 'required|date',
            'status' => 'required|in:Admitted,Discharged',
        ]);

        $admission = Admission::create($request->all());
        
        if ($request->bed_id) {
            $bed = Bed::find($request->bed_id);
            $bed->occupied_by = $admission->id;
            $bed->save();
        }
        
        return redirect()->route('admissions.index')->with('success', 'Patient admitted successfully.');
    }

    /**
     * Show the form for editing an admission.
     */
    public function edit(Admission $admission)
    {
        $patients = Patient::all();
        $doctors = User::where('role', 'Doctor')->get();
        $departments = Department::all();
        $beds = Bed::whereNull('occupied_by')->orWhere('id', $admission->bed_id)->get();

        return view('admissions.edit', compact('admission', 'patients', 'doctors', 'departments', 'beds'));
    }

    /**
     * Update an existing admission.
     */
    public function update(Request $request, Admission $admission)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,patient_id',
            'doctor_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'bed_id' => 'nullable|exists:beds,id',
            'admission_date' => 'required|date',
            'status' => 'required|in:Admitted,Discharged',
        ]);

        if ($admission->bed_id && $admission->bed_id !== $request->bed_id) {
            Bed::where('id', $admission->bed_id)->update(['occupied_by' => null]);
        }
        
        if ($request->bed_id) {
            Bed::where('id', $request->bed_id)->update(['occupied_by' => $admission->id]);
        }
        
        $admission->update($request->all());

        return redirect()->route('admissions.index')->with('success', 'Admission updated successfully.');
    }

    /**
     * Remove an admission.
     */
    public function destroy(Admission $admission)
    {
        if ($admission->bed_id) {
            Bed::where('id', $admission->bed_id)->update(['occupied_by' => null]);
        }
        
        $admission->delete();

        return redirect()->route('admissions.index')->with('success', 'Admission deleted successfully.');
    }
}