<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home() {
        return view('index');
    }
    public function settings() {
        return view('settings');
    }
    public function kelas() {
        return view('admin.kelas.create');
    }
    public function tugas() {
        return view('worker.tasks.create');
    }
    public function mapel() {
        return view('admin.mapel.create');
    }
    public function nilai() {
        return view('worker.nilai.create');
    }
}
