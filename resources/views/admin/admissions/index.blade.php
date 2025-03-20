@extends('admin.layouts.master')

@section('main_section')
<div class="container">
    <h2>Admit Patient</h2>
    <form action="{{ route('admissions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="patient_id" class="form-label">Patient</label>
            <select name="patient_id" class="form-control">
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="doctor_id" class="form-label">Doctor</label>
            <select name="doctor_id" class="form-control">
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="department_id" class="form-label">Department</label>
            <select name="department_id" class="form-control">
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="room_type" class="form-label">Room Type</label>
            <select name="room_type" id="room_type" class="form-control">
                <option value="">Select Room Type</option>
                @foreach($roomTypes as $roomType)
                    <option value="{{ $roomType }}">{{ $roomType }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="room_id" class="form-label">Room</label>
            <select name="room_id" id="room_id" class="form-control">
                <option value="">Select Room</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="bed_id" class="form-label">Bed</label>
            <select name="bed_id" id="bed_id" class="form-control">
                <option value="">Select Bed</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="admission_date" class="form-label">Admission Date</label>
            <input type="datetime-local" name="admission_date" class="form-control">
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="Admitted">Admitted</option>
                <option value="Discharged">Discharged</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Admit Patient</button>
    </form>
</div>

<script>
    document.getElementById('room_type').addEventListener('change', function () {
        var roomType = this.value;
        fetch(`/admin/get-available-rooms/${roomType}`)
            .then(response => response.json())
            .then(data => {
                let roomSelect = document.getElementById('room_id');
                roomSelect.innerHTML = '<option value="">Select Room</option>';
                data.forEach(room => {
                    roomSelect.innerHTML += `<option value="${room.id}">${room.room_number}</option>`;
                });
            });
    });

    document.getElementById('room_id').addEventListener('change', function () {
        var roomId = this.value;
        fetch(`/admin/get-available-beds/${roomId}`)
            .then(response => response.json())
            .then(data => {
                let bedSelect = document.getElementById('bed_id');
                bedSelect.innerHTML = '<option value="">Select Bed</option>';
                data.forEach(bed => {
                    bedSelect.innerHTML += `<option value="${bed.id}">${bed.bed_number}</option>`;
                });
            });
    });
</script>
@endsection
