@extends('app')

@section('content')
<div class="container">
    <h1>Create Appointment</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('appointments.create') }}" method="GET">
        @csrf
        <div class="mb-3">
            <label for="appointment_date" class="form-label">Appointment Date</label>
            <input type="date" name="appointment_date" class="form-control" id="appointment_date" value="{{ old('appointment_date', request('appointment_date')) }}">
        </div>

        <div class="mb-3">
            <label for="department_id" class="form-label">Department</label>
            <select name="department_id" id="department_id" class="form-control" onchange="this.form.submit()">
                <option value="">Select Department</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}" {{ old('department_id', request('department_id')) == $department->id ? 'selected' : '' }}>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </form>

    @if($selectedDepartment)
    <form action="{{ route('appointments.addDoctor') }}" method="POST">
        @csrf
        <input type="hidden" name="appointment_date" value="{{ request('appointment_date') }}">
        <input type="hidden" name="department_id" value="{{ request('department_id') }}">

        <div class="mb-3">
            <label for="doctor_id" class="form-label">Doctor</label>
            <select name="doctor_id" id="doctor_id" class="form-control">
                <option value="">Select Doctor</option>
                @foreach($doctors as $doctor)
                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                        {{ $doctor->name }} - Fee: {{ $doctor->fee }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Add Doctor</button>
    </form>
    @endif

    <h2 class="mt-4">Selected Doctors</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Doctor Name</th>
                <th>Appointment Date</th> 
                <th>Fee</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($selectedDoctors as $doctor)
                <tr>
                    <td>{{ $doctor['name'] }}</td>
                    <td>{{ request('appointment_date') }}</td> 
                    <td>{{ $doctor['fee'] }}</td>
                    <td>
                        <a href="{{ route('appointments.removeDoctor', $doctor['id']) }}" class="btn btn-danger btn-sm">Remove</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('appointments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="appointment_date" value="{{ request('appointment_date') }}">
        <input type="hidden" name="department_id" value="{{ request('department_id') }}">

        <div class="mb-3">
            <label for="patient_name" class="form-label">Patient Name</label>
            <input type="text" name="patient_name" class="form-control" id="patient_name" value="{{ old('patient_name') }}">
        </div>

        <div class="mb-3">
            <label for="patient_phone" class="form-label">Patient Phone</label>
            <input type="text" name="patient_phone" class="form-control" id="patient_phone" value="{{ old('patient_phone') }}">
        </div>

        <div class="mb-3">
            <label for="total_fee" class="form-label">Total Fee</label>
            <input type="text" class="form-control" id="total_fee" value="{{ $totalFee }}" readonly>
        </div>

        <div class="mb-3">
            <label for="paid_amount" class="form-label">Paid Amount</label>
            <input type="number" name="paid_amount" class="form-control" id="paid_amount" value="{{ old('paid_amount') }}">
        </div>

        

        <button type="submit" class="btn btn-primary">Create Appointment</button>
    </form>
</div>
@endsection
