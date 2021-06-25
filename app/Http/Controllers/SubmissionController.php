<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Submission;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class SubmissionController extends Controller
{
    public function create(Assignment $assignment, Request $request) {
        // Check type assignment
        if ($assignment->type == 'Online Teks') {
            // Validate
            $request->validate(['description' => 'required|max:255']);
            // Store data to database (Submission table)
            Submission::create([
                'nis'          => Auth::user()->username,
                'assignment_id'=> $assignment->id,
                'description'  => $request->input('description'),
            ]);
        } elseif ($assignment->type == 'Upload File') {
            // Validate
            $request->validate(['file' => 'required|max:10000']);
            // File proccessing
            if ($request->file != null) {
                $fileName = time() . '-' . Auth::user()->username . '-' . Auth::user()->student->name . '.' . $request->file->getClientOriginalExtension();
                $fileName = Str::of($fileName)->replace(' ', '');
                $request->file->move(public_path('submission'), $fileName);
            }
            // Store data to database (Submission table)
            Submission::create([
                'nis'          => Auth::user()->username,
                'assignment_id'=> $assignment->id,
                'file'         => $fileName,
            ]);
        } else {
            // Validate
            $request->validate([
                'description'   => 'required|max:255',
                'file'          => 'required|max:10000',
            ]);
            // File proccessing
            if ($request->file != null) {
                $fileName = time() . '-' . Auth::user()->username . '-' . Auth::user()->student->name . '.' . $request->file->getClientOriginalExtension();
                $fileName = Str::of($fileName)->replace(' ', '');
                $request->file->move(public_path('submission'), $fileName);
            }
            // Store data to database (Submission table)
            Submission::create([
                'nis'          => Auth::user()->username,
                'assignment_id'=> $assignment->id,
                'description'  => $request->input('description'),
                'file'         => $fileName,
            ]);
        }
        // Return view
        Session::flash('success', 'Berhasil mengirim jawaban ' . $assignment->name . ', ' . date('l, d F - H:i:s', time()) . '.');
        return redirect()->route('taskDetail', $assignment->id);
    }

    public function update(Assignment $assignment, Request $request) {
        // Check type assignment
        if ($assignment->type == 'Online Teks') {
            // Validate
            $request->validate(['description' => 'required|max:255']);
            // Update data to database (Submission table)
            Submission::where('nis', Auth::user()->username)
                ->where('assignment_id', $assignment->id)
                ->update(['description' => $request->input('description')]);
        } elseif ($assignment->type == 'Upload File') {
            // Validate
            $request->validate(['file' => 'required|max:10000']);
            // File proccessing
            $file = Submission::where('nis', Auth::user()->username)->where('assignment_id', $assignment->id)->first()->file;
            if ($request->file != null) {
                if ($file != null) {
                    File::delete(public_path('submission/' . $file));
                }
                $fileName = time() . '-' . Auth::user()->username . '-' . Auth::user()->student->name . '.' . $request->file->getClientOriginalExtension();
                $fileName = Str::of($fileName)->replace(' ', '');
                $request->file->move(public_path('submission'), $fileName);
            }
            // Update data to database (Submission table)
            Submission::where('nis', Auth::user()->username)
                ->where('assignment_id', $assignment->id)
                ->update(['file' => $fileName]);
        } else {
            // Validate
            $request->validate([
                'description'   => 'required|max:255',
                'file'          => 'required|max:10000',
            ]);
            // File proccessing
            $file = Submission::where('nis', Auth::user()->username)->where('assignment_id', $assignment->id)->first()->file;
            if ($request->file != null) {
                if ($file != null) {
                    File::delete(public_path('submission/' . $file));
                }
                $fileName = time() . '-' . Auth::user()->username . '-' . Auth::user()->student->name . '.' . $request->file->getClientOriginalExtension();
                $fileName = Str::of($fileName)->replace(' ', '');
                $request->file->move(public_path('submission'), $fileName);
            }
            // Update data to database (Submission table)
            Submission::where('nis', Auth::user()->username)
                ->where('assignment_id', $assignment->id)
                ->update([
                    'description' => $request->input('description'),
                    'file'        => $fileName,
                ]);
        }
        // Return view
        Session::flash('success', 'Berhasil mengedit jawaban ' . $assignment->name . ', ' . date('l, d F - H:i:s', time()) . '.');
        return redirect()->route('taskDetail', $assignment->id);
    }

    public function delete(Assignment $assignment) {
        // Delete file
        $file = Submission::where('nis', Auth::user()->username)->where('assignment_id', $assignment->id)->first()->file;
        if ($file != null) {
            File::delete(public_path('submission/' . $file));
        }
        // Deleted submission
        Submission::where('assignment_id', $assignment->id)
            ->where('nis', Auth::user()->username)
            ->delete();
        // Return view
        Session::flash('success', 'Berhasil menghapus jawaban ' . $assignment->name . ', ' . date('l, d F - H:i:s', time()) . '. Jangan lupa untuk mengupload jawabanmu yang baru :)');
        return redirect()->route('taskDetail', $assignment->id);
    }

    public function download(Submission $submission) {
        // Check submission
        if ($submission->file != null) {
            // Download
            return response()->download(public_path('submission/' . $submission->file));
        }
    }
}