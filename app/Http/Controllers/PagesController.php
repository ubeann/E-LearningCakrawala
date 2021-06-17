<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function index() {
        $admin = User::where('status','admin')->get();
        $employee = User::where('status','employee')->get();
        $student = User::where('status','student')->get();
        if (Auth::user()->status == 'admin') {
            return view('admin.dashboard', [
                'admin'     => $admin,
                'employee'  => $employee,
                'student'   => $student,
            ]);
        } else if (Auth::user()->status == 'employee') {
            return view('employee.dashboard', [
                'admin'     => $admin,
                'employee'  => $employee,
                'student'   => $student,
            ]);
        } else {
            return view('student.dashboard', [
                'admin'     => $admin,
                'employee'  => $employee,
                'student'   => $student,
            ]);
        }
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
