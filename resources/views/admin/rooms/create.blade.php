<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Room & Beds</title>
</head>
<body>
    <h2>Add New Room</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('rooms.store') }}" method="POST">
        @csrf
        <label>Room Number:</label>
        <input type="text" name="room_number" required>
        <br>
        
        <label>Room Type:</label>
        <select name="room_type" required>
            <option value="Private">Private</option>
            <option value="Semi-Private">Semi-Private</option>
            <option value="General">General</option>
        </select>
        <br>

        <label>Capacity:</label>
        <input type="number" name="capacity" min="1" required>
        <br>

        <label>Status:</label>
        <select name="status" required>
            <option value="Available">Available</option>
            <option value="Occupied">Occupied</option>
            <option value="Maintenance">Maintenance</option>
        </select>
        <br>

        <button type="submit">Add Room</button>
    </form>

    <hr>

    <h2>Add New Bed</h2>
    <form action="{{ route('beds.store') }}" method="POST">
        @csrf
        <label>Bed Number:</label>
        <input type="text" name="bed_number" required>
        <br>

        <label>Room:</label>
        <select name="room_id" required>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}">{{ $room->room_number }} ({{ $room->room_type }})</option>
            @endforeach
        </select>
        <br>

        <label>Status:</label>
        <select name="status" required>
            <option value="Available">Available</option>
            <option value="Occupied">Occupied</option>
        </select>
        <br>

        <button type="submit">Add Bed</button>
    </form>
</body>
</html>
