<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Bed;

class RoomBedController extends Controller
{
    // Show Room & Bed Form
    public function create()
    {
        $rooms = Room::all();
        return view('admin.rooms.create', compact('rooms'));
    }

    // Store Room
    public function storeRoom(Request $request)
    {
        $request->validate([
            'room_number' => 'required|unique:rooms,room_number',
            'room_type' => 'required',
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:Available,Occupied,Maintenance'
        ]);

        Room::create($request->all());

        return redirect()->back()->with('success', 'Room Added Successfully!');
    }

    // Store Bed
    public function storeBed(Request $request)
    {
        $request->validate([
            'bed_number' => 'required|unique:beds,bed_number',
            'room_id' => 'required|exists:rooms,id',
            'status' => 'required|in:Available,Occupied'
        ]);

        Bed::create($request->all());

        return redirect()->back()->with('success', 'Bed Added Successfully!');
    }
}
