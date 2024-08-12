@extends('app')

@section('content')
<div class="container">
    <h1 class="mb-4">Appointments</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Appointment No</th>
                <th>Appointment Date</th>
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
                <td>{{ $appointment->doctor->name }}</td>
                <td>{{ $appointment->patient_name }}</td>
                <td>{{ $appointment->patient_phone }}</td>
                <td>{{ $appointment->total_fee }}</td>
                <td>{{ $appointment->paid_amount }}</td>
          
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $appointments->links() }}
    </div>
</div>
@endsection
