<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Employee;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function index() {
        // Admin access
        if (Auth::user()->status == 'admin') {
            // Check installation
            $hasEmployee = count(Employee::where('status', 'Tenaga Didik')->get()) >= 1;
            $hasStudent = count(Student::all()) >= 1;
            $hasRoom = count(Room::all()) >= 1;
            // Serve data variable
            $admin = User::where('status','admin')->get();
            $employee = User::where('status','employee')->get();
            $student = User::where('status','student')->get();
            $room = Room::all();
            // View
            return view('admin.dashboard', [
                'hasEmployee'=> $hasEmployee,
                'hasStudent' => $hasStudent,
                'hasRoom'    => $hasRoom,
                'admin'      => $admin,
                'employee'   => $employee,
                'student'    => $student,
                'room'       => $room,
            ]);
        // Employee access
        } else if (Auth::user()->status == 'employee') {
            // View
            return view('employee.dashboard', [
            ]);
        // Student access
        } else {
            // View
            return view('student.dashboard', [
            ]);
        }
    }

    public function setting() {
        // Admin access
        if (Auth::user()->status == 'admin') {
            // View
            return view('admin.setting');
        // Employee access
        } else if (Auth::user()->status == 'employee') {
            // View
            return view('employee.dashboard');
        // Student access
        } else {
            // View
            return view('student.dashboard');
        }
    }

    public function helpdesk() {
        return view('helpdesk');
    }

    public function settings() {
        return view('settings');
    }
    public function kelas() {
        return view('admin.kelas.create');
    }
    public function tugas() {
        return view('employee.tasks.create');
    }
    public function mapel() {
        return view('admin.mapel.create');
    }
    public function nilai() {
        return view('employee.nilai.create');
    }
}
