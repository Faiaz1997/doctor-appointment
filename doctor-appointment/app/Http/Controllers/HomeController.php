<?php

namespace App\Http\Controllers;
use App\Models\Appointment;

class HomeController extends Controller
{

    public function index()
    {

        $appointments = Appointment::orderBy('created_at', 'desc')->paginate(10);
        return view('home.index', compact('appointments'));
    }
}
