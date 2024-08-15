<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Doctor Routes
Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create');
Route::post('/doctors/add', [DoctorController::class, 'store'])->name('doctors.store');
Route::post('/departments/add', [DoctorController::class, 'storeDepartment'])->name('departments.store');
Route::get('/doctors/edit/{doctor}', [DoctorController::class, 'edit'])->name('doctors.edit');
Route::post('/doctors/update/{doctor}', [DoctorController::class, 'update'])->name('doctors.update');
Route::post('/doctors/{doctor}', [DoctorController::class, 'destroy'])->name('doctors.destroy');

// Appointment Routes
Route::get('appointments/index', [AppointmentController::class, 'index'])->name('appointments.index');
Route::get('appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('appointments/add-doctor', [AppointmentController::class, 'addDoctor'])->name('appointments.addDoctor');
Route::get('appointments/remove-doctor/{doctorId}', [AppointmentController::class, 'removeDoctor'])->name('appointments.removeDoctor');
Route::post('appointments/store', [AppointmentController::class, 'store'])->name('appointments.store');
