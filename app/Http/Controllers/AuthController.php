<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function formLogin() {
        if (Auth::check()) { 
            // Login Success redirect to dashboard
            return redirect()->route('dashboard');
        }
        return view('index');
    }
  
    public function login(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'remember' => 'nullable'
        ]);
  
        $data = [
            'username'  => $request->input('username'),
            'password'  => $request->input('password'),
        ];
  
        Auth::attempt($data);
  
        if (Auth::check()) {
            //Login Success
            return redirect()->route('dashboard');
  
        } else { // false
            //Login Fail
            Session::flash('error', 'Username atau password salah! Silahkan hubungi pusat bantuan apabila masih tidak dapat diakses.');
            return redirect()->route('login');
        }
  
    }
  
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
