<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Support\Facades\Session;

class AppointmentController extends Controller
{
  

    public function create(Request $request)
    {
        $departments = Department::all();
        $selectedDepartment = null;
        $doctors = [];

        if ($request->has('department_id')) {
            $selectedDepartment = Department::find($request->input('department_id'));
            $doctors = $selectedDepartment ? $selectedDepartment->doctors : [];
        }

        $selectedDoctors = Session::get('selected_doctors', []);
        $totalFee = array_sum(array_column($selectedDoctors, 'fee'));

        return view('appointments.create', compact('departments', 'selectedDepartment', 'doctors', 'selectedDoctors', 'totalFee'));
    }

    public function addDoctor(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'department_id' => 'required|exists:departments,id',
            'doctor_id' => 'required|exists:doctors,id',
        ]);

        $doctor = Doctor::find($request->input('doctor_id'));

        $appointmentCount = Appointment::where('doctor_id', $doctor->id)
            ->where('appointment_date', $request->input('appointment_date'))
            ->count();

        if ($appointmentCount >= 2) {
            return back()->withErrors(['doctor_id' => 'This doctor is not available for the selected date.']);
        }

        $selectedDoctors = Session::get('selected_doctors', []);

 
        foreach ($selectedDoctors as $selectedDoctor) {
            if ($selectedDoctor['id'] == $doctor->id) {
                return back()->withErrors(['doctor_id' => 'This doctor is already added to the list.']);
            }
        }

        $selectedDoctors[] = [
            'id' => $doctor->id,
            'name' => $doctor->name,
            'fee' => $doctor->fee,
        ];

        Session::put('selected_doctors', $selectedDoctors);

        return back()->withInput();
    }

    public function removeDoctor($doctorId)
    {
        $selectedDoctors = Session::get('selected_doctors', []);

        foreach ($selectedDoctors as $key => $selectedDoctor) {
            if ($selectedDoctor['id'] == $doctorId) {
                unset($selectedDoctors[$key]);
            }
        }

        Session::put('selected_doctors', array_values($selectedDoctors));

        return back()->withInput();
    }

    public function store(Request $request)
    {

        $request->validate([
            'appointment_date' => 'required|date',
            'patient_name' => 'required|string|max:255',
            'patient_phone' => 'required|string|max:15',
            'paid_amount' => 'required|numeric',
        ]);

        $selectedDoctors = Session::get('selected_doctors', []);
        if (empty($selectedDoctors)) {
            return back()->withErrors(['doctors' => 'Please add at least one doctor.']);
        }

        $totalFee = array_sum(array_column($selectedDoctors, 'fee'));

        if ($request->paid_amount != $totalFee) {
            return back()->withErrors(['paid_amount' => 'The paid amount must be equal to the total fee.']);
        }

        foreach ($selectedDoctors as $doctor) {
        
            $appointment = new Appointment([
                'appointment_no' => now()->format('YmdHis') . '-' . $doctor['id'],
                'appointment_date' => $request->appointment_date,
                'doctor_id' => $doctor['id'],  // Access 'id' using array key
                'patient_name' => $request->patient_name,
                'patient_phone' => $request->patient_phone,
                'total_fee' => $totalFee,
                'paid_amount' => $request->paid_amount,
            ]);

            $appointment->save();
        }

    
        Session::forget('selected_doctors');

        return redirect()->route('home')->with('success', 'Appointment created successfully.');
    }
}
