@extends('template.system')

@section('title', 'Dashboard E-Learning Cakrawala (' . Auth::user()->employee->name . ')')

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
                <span>Akun anda ({{Auth::user()->employee->name}}) tidak terdaftar pada kelas manapun silahkan hubungin admin untuk mendaftarkan anda pada suatu kelas.</span>
            </div>
        @else
            <div class="container-content flex-row">
                <div class="container-mapel flex-column">
                    <div class="title-section flex-row">
                        <button type="button" class="btn btn-primary" style="opacity: 0; cursor:default;">Primary</button>
                        <h2 class="poppins">Daftar Kelas</h2>
                        <button type="button" class="btn btn-primary" style="opacity: 0; cursor:default;">Primary</button>
                    </div>
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        @foreach ($room as $data)
                            <div class="col">
                                <a href="{{route('roomDetail', $data->id)}}" class="card h-100 hover-shadow" style="text-decoration: none; color: #212121;">
                                    <img src="{{$data->photo == null ? asset('img/room/default.jpg') : asset('img/room/' . $data->photo)}}" class="card-img-top" alt="foto kelas" style="height: 200px;object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{$data->name}}</h5>
                                        <p class="card-text" style="text-align: justify">{{$data->description}}</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="flex-column container-assignment">
                    <div class="title-section">
                        <h2 class="poppins">List Tugas</h2>
                    </div>
                    @if (isset($room))
                        @foreach ($room as $data)
                            <ul class="list-group montserrat" id="list-admin">
                                <li class="list-group-item active d-flex justify-content-between align-items-center" aria-current="true" style="background-color: #023047;border-color: #023047;font-weight: 500;">
                                    {{$data->name}}
                                    @if (Auth::user()->employee->status == 'Tenaga Didik')
                                        <a href="{{route('taskCreate', $data->id)}}" class="btn btn-warning">+ Task</a>
                                    @else
                                        <div class=""></div>
                                    @endif
                                </li>
                            @forelse ($data->assignment as $assignment)
                                <li class="list-item list-group-item d-flex justify-content-between align-items-center">
                                    <div class="list-detail flex-column" style="justify-content: normal; gap:5px; align-items: flex-start;">
                                        <span class="flex-row" style="justify-content: normal; gap:5px">
                                            {{Str::limit($assignment->name, 12, $end='...')}}
                                            @if (time() > strtotime($assignment->release) and time() < strtotime($assignment->deadline))
                                                <span class="badge bg-warning text-dark">Berjalan</span>
                                            @elseif (time() < strtotime($assignment->release))
                                                <span class="badge bg-danger">Tertunda</span>
                                            @else
                                                <span class="badge bg-success">Selesai</span>
                                            @endif
                                        </span>
                                        @if (time() > strtotime($assignment->release) and time() < strtotime($assignment->deadline))
                                            @if (\Carbon\Carbon::now()->diffInDays($assignment->deadline) >= 1)
                                                {{\Carbon\Carbon::now()->diffInDays($assignment->deadline)}} hari
                                            @endif
                                            @if (\Carbon\Carbon::now()->diffInHours($assignment->deadline) >= 1)
                                                {{\Carbon\Carbon::now()->diffInHours($assignment->deadline) - (\Carbon\Carbon::now()->diffInDays($assignment->deadline) * 24)}} jam
                                            @endif
                                            @if (\Carbon\Carbon::now()->diffInMinutes($assignment->deadline) >= 1 and \Carbon\Carbon::now()->diffInDays($assignment->deadline) == 0)
                                                {{\Carbon\Carbon::now()->diffInMinutes($assignment->deadline) - (\Carbon\Carbon::now()->diffInHours($assignment->deadline) * 60)}} menit
                                            @endif
                                            @if (\Carbon\Carbon::now()->diffInSeconds($assignment->deadline) >= 1 and \Carbon\Carbon::now()->diffInHours($assignment->deadline) == 0)
                                                {{\Carbon\Carbon::now()->diffInSeconds($assignment->deadline) - (\Carbon\Carbon::now()->diffInMinutes($assignment->deadline) * 60)}} detik
                                            @endif
                                            lagi
                                        @elseif (time() < strtotime($assignment->release))
                                            Dibuka
                                            @if (\Carbon\Carbon::now()->diffInDays($assignment->release) >= 1)
                                                {{\Carbon\Carbon::now()->diffInDays($assignment->release)}} hari
                                            @endif
                                            @if (\Carbon\Carbon::now()->diffInHours($assignment->release) >= 1)
                                                {{\Carbon\Carbon::now()->diffInHours($assignment->release) - (\Carbon\Carbon::now()->diffInDays($assignment->release) * 24)}} jam
                                            @endif
                                            @if (\Carbon\Carbon::now()->diffInMinutes($assignment->release) >= 1 and \Carbon\Carbon::now()->diffInDays($assignment->release) == 0)
                                                {{\Carbon\Carbon::now()->diffInMinutes($assignment->release) - (\Carbon\Carbon::now()->diffInHours($assignment->release) * 60)}} menit
                                            @endif
                                            @if (\Carbon\Carbon::now()->diffInSeconds($assignment->release) >= 1 and \Carbon\Carbon::now()->diffInHours($assignment->release) == 0)
                                                {{\Carbon\Carbon::now()->diffInSeconds($assignment->release) - (\Carbon\Carbon::now()->diffInMinutes($assignment->release) * 60)}} detik
                                            @endif
                                            lagi
                                        @else
                                            @if (\Carbon\Carbon::now()->diffInDays($assignment->deadline) >= 1)
                                                {{\Carbon\Carbon::now()->diffInDays($assignment->deadline)}} hari
                                            @endif
                                            @if (\Carbon\Carbon::now()->diffInHours($assignment->deadline) >= 1)
                                                {{\Carbon\Carbon::now()->diffInHours($assignment->deadline) - (\Carbon\Carbon::now()->diffInDays($assignment->deadline) * 24)}} jam
                                            @endif
                                            @if (\Carbon\Carbon::now()->diffInMinutes($assignment->deadline) >= 1 and \Carbon\Carbon::now()->diffInDays($assignment->deadline) == 0)
                                                {{\Carbon\Carbon::now()->diffInMinutes($assignment->deadline) - (\Carbon\Carbon::now()->diffInHours($assignment->deadline) * 60)}} menit
                                            @endif
                                            @if (\Carbon\Carbon::now()->diffInSeconds($assignment->deadline) >= 1 and \Carbon\Carbon::now()->diffInHours($assignment->deadline) == 0)
                                                {{\Carbon\Carbon::now()->diffInSeconds($assignment->deadline) - (\Carbon\Carbon::now()->diffInMinutes($assignment->deadline) * 60)}} detik
                                            @endif
                                            yang lalu
                                        @endif
                                    </div>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end" id="button-group">
                                        @if (Auth::user()->employee->status == 'Tenaga Didik')
                                            <a href="{{route('taskEdit', $assignment->id)}}" class="btn btn-warning me-md-2" type="button">Edit</a>
                                            <form action="{{route('taskDelete', $assignment->id)}}" method="POST">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger" type="submit">Delete</button>
                                            </form>
                                        @else
                                            <a href="{{route('taskDetail', $assignment->id)}}" class="btn btn-success me-md-2" type="button">Check</a>
                                        @endif
                                    </div>
                                </li>
                                @empty
                                <li class="list-item list-group-item d-flex justify-content-between align-items-center">
                                    Belum ada tugas yang diberikan
                                </li>
                            @endforelse
                            </ul>
                        @endforeach
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection