<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Department;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with('department')->orderBy('id', 'desc')->paginate(10);
        return view('doctors.index', compact('doctors'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('doctors.create', compact('departments'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'fee' => 'required|numeric|min:0',
        ]);

        Doctor::create($request->all());

        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
    }

    public function storeDepartment(Request $request)
    {
        $request->validate([
            'newValue' => 'required|string|max:255',
        ]);
    
        $department = Department::create(['name' => $request->newValue]);
    
        return response()->json([
            'id' => $department->id,
            'name' => $department->name,
        ]);
    }

    public function review(Request $request)
    {
        // Handle reviewing the doctor's information
        // You can do further processing or validation here

        return redirect()->back()->with('success', 'Doctor information reviewed successfully!');
    }

    public function edit(Doctor $doctor)
    {
        $departments = Department::all();
        return view('doctors.edit', compact('doctor', 'departments'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'fee' => 'required|numeric|min:0',
        ]);

        $doctor->update($request->all());

        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
