@extends('admin.layouts.master')

@section('main_section')

<div class="container">
    <h2>Patients List</h2>
    
    <!-- Add Patient Button -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPatientModal">
        Add New Patient
    </button>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Patients Table -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Patient ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>DOB</th>
                <th>Gender</th>
                <th>Blood Group</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($patients as $patient)
                <tr>
                    <td>{{ $patient->patient_id }}</td>
                    <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                    <td>{{ $patient->email }}</td>
                    <td>{{ $patient->phone }}</td>
                    <td>{{ $patient->dob }}</td>
                    <td>{{ $patient->gender }}</td>
                    <td>{{ $patient->blood_group }}</td>
                    <td>
                        <a href="{{ route('admissions.create', ['patient_id' => $patient->id]) }}" class="btn btn-success btn-sm">Admit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No patients found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Bootstrap Modal for Adding Patient -->
<div class="modal fade" id="addPatientModal" tabindex="-1" aria-labelledby="addPatientModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPatientModalLabel">Add New Patient</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addPatientForm" action="{{ route('patients.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" required>
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" required>
                    </div>
                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="blood_group" class="form-label">Blood Group</label>
                        <select class="form-select" id="blood_group" name="blood_group" required>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="emergency_contact" class="form-label">Emergency Contact</label>
                        <input type="text" class="form-control" id="emergency_contact" name="emergency_contact" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Patient</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
