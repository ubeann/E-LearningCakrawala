@extends('template.system')

@section('title', 'Daftar Tugas (' . Auth::user()->employee->name . ') - E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endsection

@section('tugas', 'nav-active')

@section('container')
    <div class="flex-column" id="container-dashboard">
        <div class="flex-row container-title">
            <h1 class="poppins">Daftar Tugas</h1>
        </div>
        <div class="container-content flex-row">
            <div class="container-mapel flex-column" style="border-width: 0; padding: 0; gap:30px;">
                @if (!$hasRoom)
                    <div class="notif-warning flex-row montserrat">
                        <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                        <span>Akun anda ({{Auth::user()->employee->name}}) tidak terdaftar pada kelas manapun silahkan hubungin admin untuk mendaftarkan anda pada suatu kelas.</span>
                    </div>
                @else
                    @foreach (array_keys($task) as $room)
                        <div class="flex-column container-task" style="align-items: flex-start; gap:10px; width:100%;">
                            <div class="flex-row task-title" style="gap: 15px;">
                                <h2 class="poppins" style="margin: 0;font-size: 26px;font-weight: 600;font-style: normal;color: #212121;">{{$room}}</h2>
                                @if (Auth::user()->employee->status == 'Tenaga Didik')
                                <a href="{{route('taskCreate', $roomKey[$room])}}" class="btn btn-primary poppins" style="background-color: #52B788; border-color: #52B788;font-weight: 600;color: #FBFEFD;">+ Tugas</a>
                                @endif
                            </div>
                            @if (count($task[$room]) >= 1)
                                <div class="row row-cols-1 row-cols-md-4 g-4" style="width: 100%">
                                    @foreach ($task[$room] as $assignment)
                                        <div class="col">
                                            <{{Auth::user()->employee->status != 'Tenaga Didik' ? 'a' : 'div'}} class="card h-100 {{Auth::user()->employee->status != 'Tenaga Didik' ? 'hover-shadow' : ''}}" {{Auth::user()->employee->status != 'Tenaga Didik' ? 'href=' . route('taskDetail', $assignment->id) : ''}} style="text-decoration: none; color: #212121;">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        {{Str::limit($assignment->name, 25, $end='...')}}
                                                        @if (time() > strtotime($assignment->release) and time() < strtotime($assignment->deadline))
                                                            <span class="badge bg-warning text-dark">Berjalan</span>
                                                        @elseif (time() < strtotime($assignment->release))
                                                            <span class="badge bg-danger">Tertunda</span>
                                                        @else
                                                            <span class="badge bg-success">Selesai</span>
                                                        @endif
                                                    </h5>
                                                    <h6 class="card-subtitle mb-2 text-muted">
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
                                                    </h6>
                                                    <p class="card-text" style="min-width: 100%; text-align: justify;">{{$assignment->description}}</p>
                                                    @if (Auth::user()->employee->status == 'Tenaga Didik')
                                                        <div class="d-grid gap-1 d-md-flex justify-content-md-start" id="button-group">
                                                            <a href="{{route('taskDetail',$assignment->id)}}" class="btn btn-success me-md-2" type="button">Detail</a>
                                                            <a href="{{route('taskEdit',$assignment->id)}}" class="btn btn-warning me-md-2" type="button">Edit</a>
                                                            <form action="{{route('taskDelete',$assignment->id)}}" method="POST">
                                                                @csrf
                                                                @method('delete')
                                                                <button class="btn btn-danger" type="submit">Delete</button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </{{Auth::user()->employee->status != 'Tenaga Didik' ? 'a' : 'div'}}>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <span class="montserrat" style="margin-top: -5px">Tidak ada tugas pada kelas ini</span>
                            @endif
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection