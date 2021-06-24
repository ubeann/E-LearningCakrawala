<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Student;
use App\Models\Assignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GradeController extends Controller
{
    public function create(Assignment $assignment, Student $student,Request $request) {
        // Validation input
        $request->validate([
            'mark'         => 'required|numeric|min:0|max:100',
            'description'  => 'max:255',
        ]);
        // Store data to database (Grade table)
        Grade::create([
            'assignment_id'=> $assignment->id,
            'nis'          => $student->nis,
            'mark'         => $request->input('mark'),
            'description'  => $request->input('description'),
        ]);
        // Return view
        Session::flash('success', 'Siswa"' . $student->name . '" berhasil diberikan nilai sebesar ' . $request->input('mark') . '.');
        return redirect()->route('taskDetail', $assignment->id);
    }

    public function update(Assignment $assignment, Student $student,Request $request) {
        // Validation input
        $request->validate([
            'mark'         => 'required|numeric|min:0|max:100',
            'description'  => 'max:255',
        ]);
        // Update data to database (Grade table)
        Grade::where('assignment_id', $assignment->id)
            ->where('nis', $student->nis)
            ->update([
                'mark'        => $request->input('mark'),
                'description' => $request->input('description'),
            ]);
        // Return view
        Session::flash('success', 'Nilai siswa"' . $student->name . '" berhasil diubah menjadi ' . $request->input('mark') . '.');
        return redirect()->route('taskDetail', $assignment->id);
    }
}
