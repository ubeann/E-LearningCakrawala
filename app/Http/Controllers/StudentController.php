<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Room;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller
{
    public function form() {
        // Check has Room or not
        if (!(count(Room::all()) >= 1)) {
            Session::flash('error', 'Belum ada kelas yang terdaftar pada sistem! Silahkan buat ruang kelas terlebih dahulu.');
            return redirect()->route('dashboard');
        }
        // Get data from database
        $room = Room::all();
        // View
        return view('admin.account.student.create', compact('room'));
    }

    public function create(Request $request) {
        // Check has Room or not
        if (!(count(Room::all()) >= 1)) {
            Session::flash('error', 'Belum ada kelas yang terdaftar pada sistem! Silahkan buat ruang kelas terlebih dahulu.');
            return redirect()->route('dashboard');
        }
        // Validation input
        $request->validate([
            'username'  => 'required|unique:users,username',
            'fname'     => 'required',
            'room'      => 'required',
            'gender'    => 'required',
            'birthday'  => 'required',
            'address'   => 'required',
            'password'  => 'required',
            'photo'     => 'mimes:jpg,png,jpeg|max:2048',
        ]);
        // Store to database part 1 (Users table)
        User::create([
            'status'   => 'student',
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ]);
        // Image proccessing
        if ($request->photo != null) {
            $imageName = time() . '-' . $request->input('fname') . $request->input('lname') . '.' . $request->photo->extension();
            $imageName = Str::of($imageName)->replace(' ', '');
            $request->photo->move(public_path('img/photo'), $imageName);
        }
        // Store to database part 2 (Employee table)
        Student::create([
            'user_id'   => User::max('id'),
            'nis'       => User::find(User::max('id'))->username,
            'name'      => $request->input('lname') == null ? $request->input('fname') : $request->input('fname') . ' ' . $request->input('lname'),
            'room_id'   => $request->input('room'), 
            'gender'    => $request->input('gender'), 
            'birthday'  => $request->input('birthday'), 
            'address'   => $request->input('address'), 
            'photo'     => isset($imageName) ? $imageName : null, 
        ]);
        // Return view
        Session::flash('success', 'Akun student dengan nama "' . ($request->input('lname') == null ? $request->input('fname') : $request->input('fname') . ' ' . $request->input('lname')) . '" telah dibuat.');
        return redirect()->route('dashboard');
    }

    public function edit(Student $student) {
        // Process Name
        $name = Str::of($student->name)->explode(' ');
        $fname = [];
        $lname = [];
        $index = 0;
        foreach ($name as $key) {
            if ($index < count($name)/2) {
                $fname = Arr::add($fname, $index, $key);
            } else {
                $lname = Arr::add($lname, $index, $key);
            }
            $index += 1 ;
        }
        $firstName  = '';
        $lastName   = '';
        $index = 0;
        foreach ($fname as $key) {
            if ($index == count($fname) - 1) {
                $firstName .= $key;
            } else {
                $firstName .= $key . ' ';
            }
            $index += 1 ;
        }
        $index = 0;
        foreach ($lname as $key) {
            if ($index == count($fname) - 1) {
                $lastName .= $key;
            } else {
                $lastName .= $key . ' ';
            }
            $index += 1 ;
        }
        // Get data from database
        $room = Room::all();
        // Return view
        return view('admin.account.student.edit', compact('student', 'firstName', 'lastName', 'room'));
    }
    
    public function update(Request $request, Student $student) {
        // Validation input
        $request->validate([
            'username'  => 'required|unique:users,username,' . $student->user_id,
            'fname'     => 'required',
            'room'      => 'required',
            'gender'    => 'required',
            'birthday'  => 'required',
            'address'   => 'required',
            'photo'     => 'mimes:jpg,png,jpeg|max:2048',
        ]);
        // Update data to database (Employee table)
        Student::where('id', $student->id)
            ->update([
                'name'      => $request->input('lname') == null ? $request->input('fname') : $request->input('fname') . ' ' . $request->input('lname'),
                'room_id'   => $request->input('room'), 
                'gender'    => $request->input('gender'), 
                'birthday'  => $request->input('birthday'), 
                'address'   => $request->input('address'), 
            ]);
        // Image proccessing
        if ($request->photo != null) {
            if ($student->photo != null) {
                File::delete(public_path('img/photo/' . $student->photo));
            }
            $imageName = time() . '-' . $request->input('fname') . $request->input('lname') . '.' . $request->photo->extension();
            $imageName = Str::of($imageName)->replace(' ', '');
            $request->photo->move(public_path('img/photo'), $imageName);
            Student::where('id', $student->id)
                ->update(['photo' => $imageName]);
        }
        // Change foreign
        if ($request->input('username') != $student->nis) {
            User::where('id', $student->user_id)
                ->update(['username' => $request->input('username')]);
        }
        // Change password
        if ($request->input('password') != null) {
            User::where('id', $student->user_id)
                ->update(['password' => Hash::make($request->input('password'))]);
        }
        // Return view
        Session::flash('success', 'Akun student dengan nama "' . ($request->input('lname') == null ? $request->input('fname') : $request->input('fname') . ' ' . $request->input('lname')) . '" berhasil diedit.');
        return redirect()->route('dashboard');
    }

    public function delete(User $user) {
        // Validate Account
        if (Auth::user()->id == $user->id and $user->status == 'student') {
            // Return View
            Session::flash('error', 'Akun student dengan nama "' . $user->student->name . '" tidak dapat dihapus dikarenakan akun tersebut sedang anda gunakan!');
            return redirect()->route('dashboard');
        } else {
            User::destroy($user->id);
            // Return view
            Session::flash('success', 'Akun student dengan nama "' . $user->student->name . '" berhasil dihapus.');
            return redirect()->route('dashboard');
        }
    }

    public function detail(Student $student) {
        if (Auth::user()->status == 'employee') {
            // Return view
            return view('employee.student.detail', compact('student'));
        } else {
            // Return view
            return view('student.detail', compact('student'));
        }
    }
}
