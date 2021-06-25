@extends('template.system')

@section('title', 'Dashboard E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endsection

@section('dashboard', 'nav-active')

@section('container')
    <div class="flex-column" id="container-dashboard">
        <div class="flex-row container-title">
            <h1 class="poppins">Dashboard</h1>
        </div>
        @if (Session::has('error'))
            <div class="notif-danger flex-row montserrat">
                <img src="{{asset('img/icon/notif-danger.svg')}}" alt="danger image">
                <span>{{Session::get('error')}}</span>
            </div>
        @endif
        @if (Session::has('warning'))
            <div class="notif-warning flex-row montserrat">
                <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                <span>{{Session::get('warning')}}</span>
            </div>
        @endif
        @if (Session::has('success'))
            <div class="notif-success flex-row montserrat">
                <img src="{{asset('img/icon/notif-success.svg')}}" alt="success image">
                <span>{{Session::get('success')}}</span>
            </div>
        @endif
        @if (!$hasRoom)
            <div class="notif-warning flex-row montserrat">
                <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                <span>Akun anda ({{Auth::user()->student->name}}) tidak terdaftar pada kelas manapun silahkan hubungin admin untuk mendaftarkan anda pada suatu kelas.</span>
            </div>
        @else
            <div class="container-content flex-row">
                <div class="container-mapel flex-column">
                    <div class="title-section flex-row">
                        <button type="button" class="btn btn-primary" style="opacity: 0; cursor:default;">Primary</button>
                        <h2 class="poppins">Daftar Tugas Kelas {{Auth::user()->student->room->name}}</h2>
                        <button type="button" class="btn btn-primary" style="opacity: 0; cursor:default;">Primary</button>
                    </div>
                    @if (count($assignment) >= 1)
                        <div class="row row-cols-1 row-cols-md-3 g-4" style="width: 100%;">
                            @foreach ($assignment as $task)
                                <div class="col">
                                    <a class="card h-100 hover-shadow" href="{{route('taskDetail', $task->id)}}" style="text-decoration: none; color: #212121;">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                {{Str::limit($task->name, 25, $end='...')}}
                                                @if (time() > strtotime($task->release) and time() < strtotime($task->deadline))
                                                    <span class="badge bg-warning text-dark">Berjalan</span>
                                                @elseif (time() < strtotime($task->release))
                                                    <span class="badge bg-danger">Tertunda</span>
                                                @else
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </h5>
                                            <h6 class="card-subtitle mb-2 text-muted">
                                                @if (time() > strtotime($task->release) and time() < strtotime($task->deadline))
                                                    @if (\Carbon\Carbon::now()->diffInDays($task->deadline) >= 1)
                                                        {{\Carbon\Carbon::now()->diffInDays($task->deadline)}} hari
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInHours($task->deadline) >= 1)
                                                        {{\Carbon\Carbon::now()->diffInHours($task->deadline) - (\Carbon\Carbon::now()->diffInDays($task->deadline) * 24)}} jam
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInMinutes($task->deadline) >= 1 and \Carbon\Carbon::now()->diffInDays($task->deadline) == 0)
                                                        {{\Carbon\Carbon::now()->diffInMinutes($task->deadline) - (\Carbon\Carbon::now()->diffInHours($task->deadline) * 60)}} menit
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInSeconds($task->deadline) >= 1 and \Carbon\Carbon::now()->diffInHours($task->deadline) == 0)
                                                        {{\Carbon\Carbon::now()->diffInSeconds($task->deadline) - (\Carbon\Carbon::now()->diffInMinutes($task->deadline) * 60)}} detik
                                                    @endif
                                                    lagi
                                                @elseif (time() < strtotime($task->release))
                                                    Dibuka
                                                    @if (\Carbon\Carbon::now()->diffInDays($task->release) >= 1)
                                                        {{\Carbon\Carbon::now()->diffInDays($task->release)}} hari
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInHours($task->release) >= 1)
                                                        {{\Carbon\Carbon::now()->diffInHours($task->release) - (\Carbon\Carbon::now()->diffInDays($task->release) * 24)}} jam
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInMinutes($task->release) >= 1 and \Carbon\Carbon::now()->diffInDays($task->release) == 0)
                                                        {{\Carbon\Carbon::now()->diffInMinutes($task->release) - (\Carbon\Carbon::now()->diffInHours($task->release) * 60)}} menit
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInSeconds($task->release) >= 1 and \Carbon\Carbon::now()->diffInHours($task->release) == 0)
                                                        {{\Carbon\Carbon::now()->diffInSeconds($task->release) - (\Carbon\Carbon::now()->diffInMinutes($task->release) * 60)}} detik
                                                    @endif
                                                    lagi
                                                @else
                                                    @if (\Carbon\Carbon::now()->diffInDays($task->deadline) >= 1)
                                                        {{\Carbon\Carbon::now()->diffInDays($task->deadline)}} hari
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInHours($task->deadline) >= 1)
                                                        {{\Carbon\Carbon::now()->diffInHours($task->deadline) - (\Carbon\Carbon::now()->diffInDays($task->deadline) * 24)}} jam
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInMinutes($task->deadline) >= 1 and \Carbon\Carbon::now()->diffInDays($task->deadline) == 0)
                                                        {{\Carbon\Carbon::now()->diffInMinutes($task->deadline) - (\Carbon\Carbon::now()->diffInHours($task->deadline) * 60)}} menit
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInSeconds($task->deadline) >= 1 and \Carbon\Carbon::now()->diffInHours($task->deadline) == 0)
                                                        {{\Carbon\Carbon::now()->diffInSeconds($task->deadline) - (\Carbon\Carbon::now()->diffInMinutes($task->deadline) * 60)}} detik
                                                    @endif
                                                    yang lalu
                                                @endif
                                            </h6>
                                            <p class="card-text" style="min-width: 100%; text-align: justify;">{{$task->description}}</p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="notif-warning flex-row montserrat">
                            <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                            <span>Tidak ada tugas yang diberikan, silahkan hubungin guru <b>{{Auth::user()->student->room->employee->name}}</b> untuk membuatkan tugas apabila diperlukan!</span>
                        </div>
                    @endif
                </div>
                <div class="flex-column container-assignment">
                    <div class="title-section">
                        <h2 class="poppins">Teman Sekelas</h2>
                    </div>
                    <ul class="list-group montserrat" id="list-admin">
                        <li class="list-group-item active d-flex justify-content-between align-items-center" aria-current="true" style="background-color: #023047;border-color: #023047;font-weight: 500;">
                            Kelas {{Auth::user()->student->room->name}}
                            <a href="{{route('roomIndex')}}" class="btn btn-warning">Check</a>
                        </li>
                        @forelse ($student as $data)
                            @if ($data->nis != Auth::user()->username)
                                <li class="list-item list-group-item d-flex justify-content-between align-items-center">
                                    <div class="list-detail flex-column" style="justify-content: normal; gap:5px; align-items: flex-start;">
                                        <span class="flex-row" style="justify-content: normal; gap:5px">
                                            {{Str::limit($data->name, 27, $end='...')}}
                                        </span>
                                    </div>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end" id="button-group">
                                        <a href="{{route('studentDetail', $data->id)}}" class="btn btn-success me-md-2" type="button" style="margin-right: 0!important">Detail</a>
                                    </div>
                                </li>
                            @endif
                            @empty
                            <li class="list-item list-group-item d-flex justify-content-between align-items-center">
                                Tidak ada teman sekelas :(
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        @endif
    </div>
@endsection