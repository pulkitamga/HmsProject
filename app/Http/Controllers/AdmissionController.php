<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\Admission;
use App\Models\User;
use App\Models\Department;
use App\Models\Bed;
use App\Models\Room;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    /**
     * Display a listing of the admissions.
     */
    public function index()
    {
        $patients = Patient::all();
        $doctors = User::where('role_id', '4')->get(); // Assuming doctors have role_id 4
        $departments = Department::get();
        $rooms = Room::where('status', 'Available')->get(); // Fetch available rooms
        $roomTypes = ['Private', 'Semi-Private', 'General', 'ICU']; // Define available room types
        return view('admin.admissions.index', compact('patients', 'doctors', 'departments', 'rooms', 'roomTypes'));
    }
    
    /**
     * Store a newly created admission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'room_type' => 'required|in:Private,Semi-Private,General,ICU',
            'admission_date' => 'required|date',
            'status' => 'required|in:Admitted,Discharged',
        ]);

        // Find an available room of the selected type
        $room = Room::where('room_type', $request->room_type)
            ->where('status', 'Available')
            ->first();

        if (!$room) {
            return redirect()->back()->with('error', 'No available rooms of the selected type.');
        }

        // Find an available bed in the selected room
        $bed = Bed::where('room_id', $room->id)
            ->where('status', 'Available')
            ->first();

        if (!$bed) {
            return redirect()->back()->with('error', 'No available beds in the selected room.');
        }

        // Create Admission with assigned room and bed
        $admission = Admission::create([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'department_id' => $request->department_id,
            'room_id' => $room->id,  // Store room ID
            'bed_id' => $bed->id,    // Store assigned bed ID
            'admission_date' => $request->admission_date,
            'status' => $request->status,
        ]);

        // Mark Room and Bed as Occupied
        $room->update(['status' => 'Occupied']);
        $bed->update(['status' => 'Occupied']);

        return redirect()->route('admissions.index')->with('success', 'Patient admitted successfully.');
    }

    /**
     * Show the form for editing the admission.
     */
    public function edit(Admission $admission)
    {
        $patients = Patient::all();
        $doctors = User::where('role_id', '4')->get();
        $departments = Department::all();
        $rooms = Room::where('status', 'Available')->orWhere('id', $admission->room_no)->get();
        $beds = Bed::where('room_id', $admission->room_no)
            ->where('status', 'Available')
            ->orWhere('id', $admission->bed_id)
            ->get();

        return view('admin.admissions.edit', compact('admission', 'patients', 'doctors', 'departments', 'rooms', 'beds'));
    }

    /**
     * Update an existing admission.
     */
    public function update(Request $request, Admission $admission)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'department_id' => 'required|exists:departments,id',
            'room_type' => 'required|in:Private,Semi-Private,General,ICU',
            'admission_date' => 'required|date',
            'status' => 'required|in:Admitted,Discharged',
        ]);

        // Free the old room and bed if changed
        if ($admission->room_no) {
            Room::where('id', $admission->room_no)->update(['status' => 'Available']);
        }
        if ($admission->bed_id) {
            Bed::where('id', $admission->bed_id)->update(['status' => 'Available']);
        }

        // Find a new available room
        $room = Room::where('room_type', $request->room_type)
            ->where('status', 'Available')
            ->first();

        if (!$room) {
            return redirect()->back()->with('error', 'No available rooms of the selected type.');
        }

        // Find an available bed in the selected room
        $bed = Bed::where('room_id', $room->id)
            ->where('status', 'Available')
            ->first();

        if (!$bed) {
            return redirect()->back()->with('error', 'No available beds in the selected room.');
        }

        // Update Admission
        $admission->update([
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'department_id' => $request->department_id,
            'room_no' => $room->id,
            'bed_id' => $bed->id,
            'admission_date' => $request->admission_date,
            'status' => $request->status,
        ]);

        // Mark new room and bed as occupied
        $room->update(['status' => 'Occupied']);
        $bed->update(['status' => 'Occupied']);

        return redirect()->route('admissions.index')->with('success', 'Admission updated successfully.');
    }

    /**
     * Remove an admission.
     */
    public function destroy(Admission $admission)
    {
        // Free up the room and bed
        if ($admission->room_no) {
            Room::where('id', $admission->room_no)->update(['status' => 'Available']);
        }
        if ($admission->bed_id) {
            Bed::where('id', $admission->bed_id)->update(['status' => 'Available']);
        }

        $admission->delete();

        return redirect()->route('admissions.index')->with('success', 'Admission deleted successfully.');
    }

    public function getAvailableRooms($roomType)
    {
        $rooms = Room::where('room_type', $roomType)
            ->where('status', 'Available')
            ->get(['id', 'room_number']);

        return response()->json($rooms);
    }
    public function getAvailableBeds($roomId)
    {
        $beds = Bed::where('room_id', $roomId)
            ->where('status', 'Available')
            ->get(['id', 'bed_number']);

        return response()->json($beds);
    }

}
