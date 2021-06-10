<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function index() {
        if (Auth::user()->status == 'admin') {
            return view('admin.dashboard');
        } else if (Auth::user()->status == 'employee') {
            return view('employee.dashboard');
        } else {
            return view('student.dashboard');
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
