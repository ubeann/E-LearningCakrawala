@extends('template.system')

@section('title', 'Daftar Tugas Kelas ' . Auth::user()->student->room->name . ' - E-Learning Cakrawala')

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
                        <span>Akun anda ({{Auth::user()->student->name}}) tidak terdaftar pada kelas manapun silahkan hubungin admin untuk mendaftarkan anda pada suatu kelas.</span>
                    </div>
                @else
                    @if (count($assignment) >= 1)
                        <div class="row row-cols-1 row-cols-md-4 g-4" style="width: 100%; margin-right: 0!important; margin-left: 0!important;">
                            @foreach ($assignment as $data)
                                <div class="col">
                                    <a class="card h-100 hover-shadow" href="{{route('taskDetail', $data->id)}}" style="text-decoration: none; color: #212121;">
                                        <div class="card-body">
                                            <h5 class="card-title">
                                                {{Str::limit($data->name, 25, $end='...')}}
                                                @if (time() > strtotime($data->release) and time() < strtotime($data->deadline))
                                                    <span class="badge bg-warning text-dark">Berjalan</span>
                                                @elseif (time() < strtotime($data->release))
                                                    <span class="badge bg-danger">Tertunda</span>
                                                @else
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </h5>
                                            <h6 class="card-subtitle mb-2 text-muted">
                                                @if (time() > strtotime($data->release) and time() < strtotime($data->deadline))
                                                    @if (\Carbon\Carbon::now()->diffInDays($data->deadline) >= 1)
                                                        {{\Carbon\Carbon::now()->diffInDays($data->deadline)}} hari
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInHours($data->deadline) >= 1)
                                                        {{\Carbon\Carbon::now()->diffInHours($data->deadline) - (\Carbon\Carbon::now()->diffInDays($data->deadline) * 24)}} jam
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInMinutes($data->deadline) >= 1 and \Carbon\Carbon::now()->diffInDays($data->deadline) == 0)
                                                        {{\Carbon\Carbon::now()->diffInMinutes($data->deadline) - (\Carbon\Carbon::now()->diffInHours($data->deadline) * 60)}} menit
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInSeconds($data->deadline) >= 1 and \Carbon\Carbon::now()->diffInHours($data->deadline) == 0)
                                                        {{\Carbon\Carbon::now()->diffInSeconds($data->deadline) - (\Carbon\Carbon::now()->diffInMinutes($data->deadline) * 60)}} detik
                                                    @endif
                                                    lagi
                                                @elseif (time() < strtotime($data->release))
                                                    Dibuka
                                                    @if (\Carbon\Carbon::now()->diffInDays($data->release) >= 1)
                                                        {{\Carbon\Carbon::now()->diffInDays($data->release)}} hari
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInHours($data->release) >= 1)
                                                        {{\Carbon\Carbon::now()->diffInHours($data->release) - (\Carbon\Carbon::now()->diffInDays($data->release) * 24)}} jam
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInMinutes($data->release) >= 1 and \Carbon\Carbon::now()->diffInDays($data->release) == 0)
                                                        {{\Carbon\Carbon::now()->diffInMinutes($data->release) - (\Carbon\Carbon::now()->diffInHours($data->release) * 60)}} menit
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInSeconds($data->release) >= 1 and \Carbon\Carbon::now()->diffInHours($data->release) == 0)
                                                        {{\Carbon\Carbon::now()->diffInSeconds($data->release) - (\Carbon\Carbon::now()->diffInMinutes($data->release) * 60)}} detik
                                                    @endif
                                                    lagi
                                                @else
                                                    @if (\Carbon\Carbon::now()->diffInDays($data->deadline) >= 1)
                                                        {{\Carbon\Carbon::now()->diffInDays($data->deadline)}} hari
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInHours($data->deadline) >= 1)
                                                        {{\Carbon\Carbon::now()->diffInHours($data->deadline) - (\Carbon\Carbon::now()->diffInDays($data->deadline) * 24)}} jam
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInMinutes($data->deadline) >= 1 and \Carbon\Carbon::now()->diffInDays($data->deadline) == 0)
                                                        {{\Carbon\Carbon::now()->diffInMinutes($data->deadline) - (\Carbon\Carbon::now()->diffInHours($data->deadline) * 60)}} menit
                                                    @endif
                                                    @if (\Carbon\Carbon::now()->diffInSeconds($data->deadline) >= 1 and \Carbon\Carbon::now()->diffInHours($data->deadline) == 0)
                                                        {{\Carbon\Carbon::now()->diffInSeconds($data->deadline) - (\Carbon\Carbon::now()->diffInMinutes($data->deadline) * 60)}} detik
                                                    @endif
                                                    yang lalu
                                                @endif
                                            </h6>
                                            <p class="card-text" style="min-width: 100%; text-align: justify;">{{$data->description}}</p>
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
                @endif
            </div>
        </div>
    </div>
@endsection