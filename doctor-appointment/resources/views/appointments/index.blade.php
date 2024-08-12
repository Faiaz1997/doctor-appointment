@extends('app')

@section('content')
<div class="container">
    <h1>Appointments</h1>
    <a href="{{ route('appointments.create') }}" class="btn btn-primary mb-3">Add Appointment</a>


    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Appointment No</th>
                <th>Date</th>
                <th>Doctor</th>
                <th>Patient Name</th>
                <th>Patient Phone</th>
                <th>Total Fee</th>
                <th>Paid Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->appointment_no }}</td>
                    <td>{{ $appointment->appointment_date }}</td>
                    <td>{{ $appointment->doctor->name }} ({{ $appointment->doctor->department->name }})</td>
                    <td>{{ $appointment->patient_name }}</td>
                    <td>{{ $appointment->patient_phone }}</td>
                    <td>{{ $appointment->total_fee }}</td>
                    <td>{{ $appointment->paid_amount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $appointments->links() }}
</div>
@endsection
