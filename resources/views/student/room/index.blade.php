@extends('template.system')

@section('title', 'Kelas ' . $room->name . ' E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/kelas.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <style>
        #button-group {
            /* addition */
            transition: 0.35s;
            /* style */
            opacity: 0;
        }
        tr:hover #button-group {
            /* style */
            opacity: 100;
        }
        .container-notif {
            /* size */
            width: 100%;
            /* layout */
            box-sizing: border-box; 
            padding: 20px 75px; 
        }
        @media only screen and (max-width: 720px) {
            .container-notif {
                padding: 20px 15px;
            }
        }
    </style>
@endsection

@section('kelas', 'nav-active')

@section('container')
    <div class="flex-column" id="container-kelas">
        @if (!$hasRoom)
            <div class="container-notif">
                <div class="notif-danger flex-row montserrat">
                    <img src="{{asset('img/icon/notif-danger.svg')}}" alt="danger image">
                    <span>Akun anda ({{Auth::user()->student->name}}) tidak terdaftar pada kelas manapun silahkan hubungin admin untuk mendaftarkan anda pada suatu kelas.</span>
                </div>
            </div>
        @else
            <div class="flex-column head-content">
                <img src="{{asset('img/room/'. ($room->photo == null ? 'default.jpg' : $room->photo))}}" alt="foto {{$room->name}}">
                <div class="flex-row head-text poppins">
                    <h1>{{Str::limit($room->name, 25, $end='...')}}</h1>
                    <h1>-</h1>
                    <h1>{{Str::limit($room->employee->name, 25, $end='...')}}</h1>
                </div>
            </div>
            <div class="flex-row detail-content">
                <div class="flex-column content-group">
                    <div class="flex-column content-description">
                        <h2 class="poppins">Deskripsi</h2>
                        <p class="montserrat">{{$room->description}}</p>
                    </div>
                    <div class="flex-column content-student">
                        <h2 class="poppins">Teman Sekelas</h2>
                        @if (count($room->student) < 1)
                            <div class="notif-warning flex-row montserrat">
                                <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                                <span>Belum ada siswa yang terdaftar pada kelas {{$room->name}}! Silahkan hubungi admin jika memang terjadi error.</span>
                            </div>
                        @else
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">NIS</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Jenis Kelamin</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($student as $data)
                                        <tr class="{{$data->nis == Auth::user()->username ? 'table-secondary' : ''}}">
                                            <th scope="row">{{$loop->index + 1}}</th>
                                            <td>{{$data->nis}}</td>
                                            <td>{{$data->name}} {{$data->nis == Auth::user()->username ? '(Saya)' : ''}}</td>
                                            <td>{{$data->gender}}</td>
                                            <td>{{$data->address}}</td>
                                            <td>
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-start" id="button-group">
                                                    <a href="{{route('studentDetail', $data->id)}}" class="btn btn-success me-md-2" type="button">Detail</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="flex-column content-student">
                        <div class="flex-row task-title" style="gap:10px;">
                            <h2 class="poppins">Tugas</h2>
                        </div>
                        @if (count($room->assignment) < 1)
                            <div class="notif-warning flex-row montserrat">
                                <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                                <span>Belum ada tugas yang diberikan pada kelas {{$room->name}}! Silahkan hubungi guru <b>{{$room->employee->name}}</b> untuk membuatkan tugas jika diperlukan.</span>
                            </div>
                        @else
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Tanggal dibuka</th>
                                        <th scope="col">Tanggal ditutup</th>
                                        <th scope="col">Nilai</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assignment as $data)
                                        <tr class="{{ (time() > strtotime($data->release) and time() < strtotime($data->deadline)) ? 'table-warning' : ''}} {{ time() < strtotime($data->release) ? 'table-danger' : ''}} {{ (time() < strtotime($data->release) or (time() > strtotime($data->release) and time() < strtotime($data->deadline))) ? '' : 'table-success'}}">
                                            <th scope="row">{{$loop->index + 1}}</th>
                                            <td>{{$data->name}}</td>
                                            <td>
                                                @if (time() > strtotime($data->release) and time() < strtotime($data->deadline))
                                                    <span class="badge bg-warning text-dark">Berjalan</span>
                                                @elseif (time() < strtotime($data->release))
                                                    <span class="badge bg-danger">Tertunda</span>
                                                @else
                                                    <span class="badge bg-success">Selesai</span>
                                                @endif
                                            </td>
                                            <td>{{date('l, d F - H:i', strtotime($data->release))}}</td>
                                            <td>{{date('l, d F - H:i', strtotime($data->deadline))}}</td>
                                            <td>
                                                @if (count($data->grade->where('nis', Auth::user()->username)) >= 1)
                                                    {{$data->grade->where('nis', Auth::user()->username)->first()->mark}}
                                                @elseif (count($data->submission->where('nis', Auth::user()->username)) >= 1)
                                                    <span class="badge bg-warning text-dark">Belum dinilai</span>
                                                @elseif (time() > strtotime($data->deadline))
                                                    <span class="badge bg-danger">Tidak Mengumpulkan</span>
                                                @elseif (time() > strtotime($data->release) and time() < strtotime($data->deadline))
                                                    <span class="badge bg-warning text-dark">Belum Mengerjakan</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Belum Dibuka</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-grid gap-2 d-md-flex justify-content-md-start" id="button-group">
                                                    <a href="{{route('taskDetail', $data->id)}}" class="btn btn-success me-md-2" type="button">Detail</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
                <div class="flex-column title-teacher">
                    <h2 class="poppins">Pengajar</h2>
                    <div class="flex-column content-teacher">
                        @if ($room->employee->photo == null)
                            <span class="notif-warning montserrat">{{$room->employee->name}} tidak memiliki foto profil, untuk saat ini akan menggunakan foto <b>default</b> dari sistem.</span>
                        @endif
                        <img src="{{asset('img/photo/'. ($room->employee->photo == null ? 'default.jpg' : $room->employee->photo))}}" alt="foto {{$room->employee->name}}">
                        <h3 class="montserrat">{{Str::limit($room->employee->name, 22, $end='...')}}</h3>
                        <p class="montserrat">{{Str::limit($room->employee->phone, 22, $end='...')}}</p>
                        <p class="montserrat" style="box-sizing: border-box; padding-left: 15px; padding-right: 15px;">{{Str::limit($room->employee->address, 100, $end='...')}}</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection