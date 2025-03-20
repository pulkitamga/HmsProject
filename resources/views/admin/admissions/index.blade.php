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
                    <option value="{{ $patient->patient_id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
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
            <label for="bed_id" class="form-label">Bed</label>
            <select name="bed_id" class="form-control">
                <option value="">Select Bed</option>
                @foreach($beds as $bed)
                    <option value="{{ $bed->id }}">{{ $bed->bed_number }}</option>
                @endforeach
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
@endsection
