<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Employee;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class RoomController extends Controller
{
    public function form() {
        // Check has Teacher or not
        if (!(count(Employee::where('status', 'Tenaga Didik')->get()) >= 1)) {
            Session::flash('error', 'Belum ada akun Employee dengan status Tenaga Didik! Silahkan buat akun employee terlebih dahulu.');
            return redirect()->route('dashboard');
        }
        // Get data from database
        $data = Employee::where('status', 'Tenaga Didik')->get();
        // Return view
        return view('admin.room.create', compact('data'));
    }

    public function create(Request $request) {
        // Check has Teacher or not
        if (!(count(Employee::where('status', 'Tenaga Didik')->get()) >= 1)) {
            Session::flash('error', 'Belum ada akun Employee dengan status Tenaga Didik! Silahkan buat akun employee terlebih dahulu.');
            return redirect()->route('dashboard');
        }
        // Validation input
        $request->validate([
            'name'          => 'required',
            'teacher_id'    => 'required',
            'year'          => 'required',
            'description'   => 'required|max:255',
            'photo'         => 'mimes:jpg,png,jpeg|max:2048',
        ]);
        // Image proccessing
        if ($request->photo != null) {
            $imageName = time() . '-' . $request->input('name') . '.' . $request->photo->extension();
            $imageName = Str::of($imageName)->replace(' ', '');
            $request->photo->move(public_path('img/room'), $imageName);
        }
        // Store to database (Rooms table)
        Room::create([
            'teacher_id'  => $request->input('teacher_id'),
            'name'        => $request->input('name'),
            'year'        => $request->input('year'),
            'description' => $request->input('description'),
            'photo'       => isset($imageName) ? $imageName : null,
        ]);
        // Return view
        Session::flash('success', 'Ruang kelas dengan nama "' . $request->input('name') . '" telah dibuat.');
        return redirect()->route('dashboard');
    }

    public function edit(Room $room) {
        // Get data from database
        $data = Employee::where('status', 'Tenaga Didik')->get();
        // Return view
        return view('admin.room.edit', compact('room', 'data'));
    }

    public function update(Request $request, Room $room) {
        // Validation input
        $request->validate([
            'name'          => 'required',
            'teacher_id'    => 'required',
            'year'          => 'required',
            'description'   => 'required|max:255',
            'photo'         => 'mimes:jpg,png,jpeg|max:2048',
        ]);
        // Update data to database (Rooms table)
        Room::where('id', $room->id)
            ->update([
                'teacher_id'  => $request->input('teacher_id'),
                'name'        => $request->input('name'),
                'year'        => $request->input('year'),
                'description' => $request->input('description'),
            ]);
        // Image proccessing
        if ($request->photo != null) {
            if ($room->photo != null) {
                File::delete(public_path('img/room/' . $room->photo));
            }
            $imageName = time() . '-' . $request->input('name') . '.' . $request->photo->extension();
            $imageName = Str::of($imageName)->replace(' ', '');
            $request->photo->move(public_path('img/room'), $imageName);
            Room::where('id', $room->id)
                ->update(['photo' => $imageName]);
        }
        // Return view
        Session::flash('success', 'Ruang kelas dengan nama "' . $request->input('name') . '" berhasil diedit.');
        return redirect()->route('dashboard');
    }

    public function delete(Room $room) {
        // Delete room on database
        Room::destroy($room->id);
        // Return view
        Session::flash('success', 'Ruang kelas dengan nama "' . $room->name . '" berhasil dihapus.');
        return redirect()->route('dashboard');
    }

    public function detail(Room $room) {
        // Prepare variable
        $teacher = Employee::where('nip', $room->teacher_id)->get()->first();
        $salary = "Rp " . number_format($teacher->salary,0,',','.');
        $hasStudent = count($room->student) >= 1;
        // Return view
        return view('admin.room.detail', compact('room', 'teacher', 'salary', 'hasStudent'));
    }

    public function index() {
        // Get data from database
        $room = Room::all();
        $hasTeacher = count(Employee::where('status', 'Tenaga Didik')->get()) >= 1;
        // Return view
        return view('admin.room.index', compact('room', 'hasTeacher'));
    }
}