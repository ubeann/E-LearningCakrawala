<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Room;
use App\Models\Grade;
use App\Models\Assignment;
use App\Models\Student;
use App\Models\Submission;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class AssignmentController extends Controller
{
    public function form(Room $room) {
        return view('employee.tasks.create', compact('room'));
    }

    public function create(Room $room, Request $request) {
        // Validation input
        $request->validate([
            'name'          => 'required',
            'type'          => 'required',
            'release'       => 'required|date|after:now',
            'deadline'      => 'required|date|after:release',
            'description'   => 'required',
        ]);
        // Store to database (Assignments table)
        Assignment::create([
            'room_id'     => $room->id,
            'name'        => $request->input('name'),
            'type'        => $request->input('type'),
            'release'     => $request->input('release'),
            'deadline'    => $request->input('deadline'),
            'description' => $request->input('description'),
        ]);
        // Return view
        Session::flash('success', 'Tugas dengan nama "' . $request->input('name') . '" telah dibuat pada kelas ' . $room->name . '.');
        return redirect()->route('dashboard');
    }

    public function edit(Assignment $assignment) {
        // Return view
        return view('employee.tasks.edit', compact('assignment'));
    }

    public function update(Assignment $assignment, Request $request) {
        // Validation input
        $request->validate([
            'name'          => 'required',
            'type'          => 'required',
            'description'   => 'required',
        ]);
        // Update data to database (Assignments table)
        Assignment::where('id', $assignment->id)
            ->update([
                'name'        => $request->input('name'),
                'type'        => $request->input('type'),
                'description' => $request->input('description'),
            ]);
        // Validate change release date
        if (Carbon::parse($assignment->release)->format('Y-m-d H:i') != Carbon::parse($request->input('release'))->format('Y-m-d H:i')) {
            $request->validate(['release' => 'required|date|after:now']);
            Assignment::where('id', $assignment->id)->update(['release' => $request->input('release')]);
        }
        // Validate change deadline date
        if (Carbon::parse($assignment->deadline)->format('Y-m-d H:i') != Carbon::parse($request->input('deadline'))->format('Y-m-d H:i')){
            $request->validate(['deadline' => 'required|date|after:release']);
            Assignment::where('id', $assignment->id)->update(['deadline' => $request->input('deadline')]);
        }
        // Return view
        Session::flash('success', 'Tugas dengan nama "' . $request->input('name') . '" berhasil diedit pada kelas ' . $assignment->room->name . '.');
        return redirect()->route('dashboard');
    }

    public function delete(Assignment $assignment) {
        // Delete whole submission including file upload
        foreach (Submission::where('assignment_id', $assignment->id)->get() as $key) {
            if ($key->file != null) {
                File::delete(public_path('submission/' . $key->file));
            }
        }
        // Delete task
        Assignment::destroy($assignment->id);
        // Return view
        Session::flash('success', 'Tugas dengan nama "' . $assignment->name . '" telah dihapus pada kelas ' . $assignment->room->name . '.');
        return redirect()->route('dashboard');
    }

    public function index() {
        if (Auth::user()->status == 'employee') {
            // Get data from database
            if (Auth::user()->employee->status == 'Tenaga Didik') {
                $room = Room::where('teacher_id', Auth::user()->username)->orderBy('name','asc')->get();
            } else {
                $room = Room::orderBy('name','asc')->get();
            }
            $hasRoom = count($room) >= 1;
            $task = [];
            $roomKey = [];
            foreach ($room as $key) {
                $roomKey = Arr::add($roomKey, $key->name , $key->id);
                $task = Arr::add($task, $key->name , Assignment::where('room_id', $key->id)->orderBy('deadline', 'desc')->get());
            }
            // Return view
            return view('employee.tasks.index', compact('hasRoom', 'task', 'roomKey'));
        } else {
            // Get data from database
            $room = Room::where('id', Auth::user()->student->room->id)->get();
            $hasRoom = count($room) >= 1;
            $assignment = Assignment::where('room_id', $room->first()->id)->orderBy('deadline', 'asc')->get();
            // Return view
            return view('student.tasks.index', compact('hasRoom', 'assignment'));
        }
    }
    
    public function detail(Assignment $assignment) {
        // Get data from database
        $grade = Grade::where('assignment_id', $assignment->id)->whereNotNull('mark')->orderBy('mark','desc')->get();
        $rank = $grade->first();
        $hasRank = $rank != null;
        $ranker = $hasRank ? Student::where('nis', $rank->nis)->first() : null;
        // Employee access
        if (Auth::user()->status == 'employee') {
            // Get data from database
            $submission = Submission::where('assignment_id', $assignment->id)->get();
            $student = Student::where('room_id', $assignment->room->id)->orderBy('name', 'asc')->get();
            // Return view
            return view('employee.tasks.detail', compact('assignment', 'rank', 'hasRank', 'ranker', 'student', 'grade', 'submission'));
        // Student access
        } else {
            // Get data from database
            $submission = Submission::where('assignment_id', $assignment->id)->where('nis', Auth::user()->username)->get();
            // Return view
            return view('student.tasks.detail', compact('assignment', 'rank', 'hasRank', 'ranker', 'grade', 'submission'));
        }        
    }
}