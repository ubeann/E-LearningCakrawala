<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function form() {
        return view('admin.account.admin.create');
    }

    public function create(Request $request) {
        // Validation input
        $request->validate([
            'username' => 'required|unique:users,username',
            'password' => 'required',
        ]);
        // Store to database (Users table)
        User::create([
            'status'   => 'admin',
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ]);
        // Return view
        Session::flash('success', 'Akun admin dengan username "' . $request->input('username') . '" telah dibuat.');
        return redirect()->route('dashboard');
    }

    public function edit(User $user) {
        // Return view
        return view('admin.account.admin.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        // Validation input
        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
        ]);
        // Update to database (Users table)
        User::where('id', $user->id)
            ->update(['username' => $request->input('username')]);
        // Update password if user input new password
        if ($request->input('password') != null) {
            User::where('id', $user->id)
            ->update(['password' => Hash::make($request->input('password'))]);
        }
        // Return view
        Session::flash('success', 'Akun admin dengan username "' . $request->input('username') . '" berhasil diedit.');
        return redirect()->route('dashboard');
    }

    public function setting(Request $request, User $user) {
        // Validation input
        $request->validate([
            'username' => 'required|unique:users,username,' . $user->id,
        ]);
        // Update to database (Users table)
        User::where('id', $user->id)
            ->update(['username' => $request->input('username')]);
        // Update password if user input new password
        if ($request->input('password') != null) {
            User::where('id', $user->id)
            ->update(['password' => Hash::make($request->input('password'))]);
        }
        // Return view
        Session::flash('success', 'Akun admin "' . $request->input('username') . '" berhasil diedit.');
        return redirect()->route('setting');
    }

    public function delete(User $user) {
        // Validate Account
        if (Auth::user()->id == $user->id and $user->status == 'admin') {
            // Return View
            Session::flash('error', 'Akun admin dengan username "' . $user->username . '" tidak dapat dihapus dikarenakan akun tersebut sedang anda gunakan!');
            return redirect()->route('dashboard');
        } else {
            User::destroy($user->id);
            // Return view
            Session::flash('success', 'Akun admin dengan username "' . $user->username . '" berhasil dihapus.');
            return redirect()->route('dashboard');
        }
    }
}
