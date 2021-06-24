<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class EmployeeController extends Controller
{
    public function form() {
        return view('admin.account.employee.create');
    }

    public function create(Request $request) {
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
            'username'  => 'required|unique:users,username',
            'fname'     => 'required',
            'phone'     => 'required|unique:employees,phone',
            'status'    => 'required',
            'salary'    => 'required',
            'tenure'    => 'required',
            'address'   => 'required',
            'password'  => 'required',
            'photo'     => 'mimes:jpg,png,jpeg|max:2048',
        ]);
        // Store to database part 1 (Users table)
        User::create([
            'status'   => 'employee',
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
        Employee::create([
            'user_id'   => User::max('id'),
            'nip'       => User::find(User::max('id'))->username,
            'name'      => $request->input('lname') == null ? $request->input('fname') : $request->input('fname') . ' ' . $request->input('lname'),
            'status'    => $request->input('status'),
            'phone'     => $phone,
            'salary'    => $request->input('salary'),
            'tenure'    => $request->input('tenure'),
            'address'   => $request->input('address'),
            'photo'     => isset($imageName) ? $imageName : null,
        ]);
        // Return view
        Session::flash('success', 'Akun employee dengan nama "' . ($request->input('lname') == null ? $request->input('fname') : $request->input('fname') . ' ' . $request->input('lname')) . '" telah dibuat.');
        return redirect()->route('dashboard');
    }

    public function edit(Employee $employee) {
        // Process Name
        $name = Str::of($employee->name)->explode(' ');
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
        // Return view
        return view('admin.account.employee.edit', compact('employee', 'firstName', 'lastName'));
    }

    public function update(Request $request, Employee $employee) {
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
            'username'  => 'required|unique:users,username,' . $employee->user_id,
            'fname'     => 'required',
            'phone'     => 'required|unique:employees,phone,' . $employee->id,
            'status'    => 'required',
            'salary'    => 'required',
            'tenure'    => 'required',
            'address'   => 'required',
            'photo'     => 'mimes:jpg,png,jpeg|max:2048',
        ]);
        // Update data to database (Employee table)
        Employee::where('id', $employee->id)
            ->update([
                'name'      => $request->input('lname') == null ? $request->input('fname') : $request->input('fname') . ' ' . $request->input('lname'),
                'status'    => $request->input('status'), 
                'phone'     => $phone, 
                'salary'    => $request->input('salary'), 
                'tenure'    => $request->input('tenure'), 
                'address'   => $request->input('address'), 
            ]);
        // Image proccessing
        if ($request->photo != null) {
            if ($employee->photo != null) {
                File::delete(public_path('img/photo/' . $employee->photo));
            }
            $imageName = time() . '-' . $request->input('fname') . $request->input('lname') . '.' . $request->photo->extension();
            $imageName = Str::of($imageName)->replace(' ', '');
            $request->photo->move(public_path('img/photo'), $imageName);
            Employee::where('id', $employee->id)
                ->update(['photo' => $imageName]);
        }
        // Change foreign
        if ($request->input('username') != $employee->nip) {
            User::where('id', $employee->user_id)
                ->update(['username' => $request->input('username')]);
        }
        // Change password
        if ($request->input('password') != null) {
            User::where('id', $employee->user_id)
                ->update(['password' => Hash::make($request->input('password'))]);
        }
        // Return view
        Session::flash('success', 'Akun employee dengan nama "' . ($request->input('lname') == null ? $request->input('fname') : $request->input('fname') . ' ' . $request->input('lname')) . '" berhasil diedit.');
        return redirect()->route('dashboard');
    }
    
    public function delete(User $user) {
        // Validate Account
        if (Auth::user()->id == $user->id and $user->status == 'employee') {
            // Return View
            Session::flash('error', 'Akun employee dengan nama "' . $user->employee->name . '" tidak dapat dihapus dikarenakan akun tersebut sedang anda gunakan!');
            return redirect()->route('dashboard');
        } else {
            User::destroy($user->id);
            // Return view
            Session::flash('success', 'Akun employee dengan nama "' . $user->employee->name . '" berhasil dihapus.');
            return redirect()->route('dashboard');
        }
    }
}