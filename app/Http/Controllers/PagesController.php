<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use App\Models\Student;
use App\Models\Employee;
use App\Models\Assignment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

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
            $admin = User::where('status','admin')->orderBy('username', 'asc')->get();
            $employee = Employee::orderBy('nip', 'asc')->get();
            $student = Student::orderBy('nis', 'asc')->get();
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
            // Tenaga Didik access
            if (Auth::user()->employee->status == 'Tenaga Didik') {
                // Serve data variable
                $room = Room::where('teacher_id', Auth::user()->employee->nip)->orderBy('name', 'asc')->get();
            // Honorer access
            } else {
                // Serve data variable
                $room = Room::orderBy('name', 'asc')->get();
            }
            $hasRoom = count($room) >= 1;
            // View
            return view('employee.dashboard', [
                'hasRoom'   => $hasRoom,
                'room'      => $room,
            ]);
        // Student access
        } else {
            // Get data from database
            $room = Room::where('id', Auth::user()->student->room_id)->get();
            $hasRoom = count($room) >= 1;
            $student = Student::where('room_id', $room->first()->id)->orderBy('nis', 'asc')->get();
            $assignment = Assignment::where('room_id', $room->first()->id)->orderBy('deadline', 'asc')->get();
            // View
            return view('student.dashboard', [
                'hasRoom'   => $hasRoom,
                'student'   => $student,
                'assignment'=> $assignment,
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
            return view('employee.setting');
        // Student access
        } else {
            // View
            return view('student.setting');
        }
    }

    public function update(Request $request) {
        // Employee access
        if (Auth::user()->status == 'employee') {
            // Check phone number
            $phone = str_replace(" ","",$request->input('phone'));
            $phone = str_replace("(","",$phone);
            $phone = str_replace(")","",$phone);
            $phone = str_replace(".","",$phone);
            $phone = str_replace("-","",$phone);
            if(!preg_match('/[^+0-9]/',trim($phone))){
                if(substr(trim($phone), 0, 3) == '+62'){
                    $phone = trim($phone);
                }
                elseif(substr(trim($phone), 0, 1) == '0'){
                    $phone = '+62'.substr(trim($phone), 1);
                }
            }
            // Merge request input
            $request->merge([
                'phone' => $phone,
            ]);
            // Validation input
            $request->validate([
                'name'      => 'required',
                'phone'     => 'required|unique:employees,phone,' . Auth::user()->employee->id,
                'address'   => 'required',
                'photo'     => 'mimes:jpg,png,jpeg|max:2048',
            ]);
            // Update data to database (Employee table)
            Employee::where('id', Auth::user()->employee->id)
                ->update([
                    'name'      => $request->input('name'),
                    'phone'     => $phone, 
                    'address'   => $request->input('address'), 
                ]);
            // Image proccessing
            if ($request->photo != null) {
                if (Auth::user()->employee->photo != null) {
                    File::delete(public_path('img/photo/' . Auth::user()->employee->photo));
                }
                $imageName = time() . '-' . $request->input('name') . '.' . $request->photo->extension();
                $imageName = Str::of($imageName)->replace(' ', '');
                $request->photo->move(public_path('img/photo'), $imageName);
                Employee::where('id', Auth::user()->employee->id)
                    ->update(['photo' => $imageName]);
            }
            // Change password
            if ($request->input('password') != null) {
                User::where('id', Auth::user()->employee->user_id)
                    ->update(['password' => Hash::make($request->input('password'))]);
            }
            // Return view
            Session::flash('success', 'Akun "' . $request->input('name') . '" berhasil diedit.');
            return redirect()->route('setting');

        // Student access
        } else if (Auth::user()->status == 'student') {
            // Validation input
            $request->validate([
                'name'      => 'required',
                'gender'    => 'required',
                'birthday'  => 'required',
                'address'   => 'required',
                'photo'     => 'mimes:jpg,png,jpeg|max:2048',
            ]);
            // Update data to database (Employee table)
            Student::where('id', Auth::user()->student->id)
                ->update([
                    'name'      => $request->input('name'),
                    'gender'    => $request->input('gender'), 
                    'birthday'  => $request->input('birthday'), 
                    'address'   => $request->input('address'), 
                ]);
            // Image proccessing
            if ($request->photo != null) {
                if (Auth::user()->student->photo != null) {
                    File::delete(public_path('img/photo/' . Auth::user()->student->photo));
                }
                $imageName = time() . '-' . $request->input('name') . '.' . $request->photo->extension();
                $imageName = Str::of($imageName)->replace(' ', '');
                $request->photo->move(public_path('img/photo'), $imageName);
                Student::where('id', Auth::user()->student->id)
                    ->update(['photo' => $imageName]);
            }
            // Change password
            if ($request->input('password') != null) {
                User::where('id', Auth::user()->student->user_id)
                    ->update(['password' => Hash::make($request->input('password'))]);
            }
            // Return view
            Session::flash('success', 'Akun "' . $request->input('name') . '" berhasil diedit.');
            return redirect()->route('setting');
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
