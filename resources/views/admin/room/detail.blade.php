@extends('template.system')

@section('title', 'Kelas ' . $room->name . ' E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/kelas.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endsection

@section('kelas', 'nav-active')

@section('container')
    <div class="flex-column" id="container-kelas">
        <div class="flex-column head-content">
            <img src="{{asset('img/room/'. ($room->photo == null ? 'default.jpg' : $room->photo))}}" alt="foto {{$room->name}}">
            <div class="flex-row head-text poppins">
                <h1>{{Str::limit($room->name, 20, $end='...')}}</h1>
                <h1>-</h1>
                <h1>{{Str::limit($teacher->name, 20, $end='...')}}</h1>
            </div>
        </div>
        <div class="flex-row detail-content">
            <div class="flex-column content-group">
                <div class="flex-column content-description">
                    <h2 class="poppins">Deskripsi</h2>
                    <p class="montserrat">{{$room->description}}</p>
                </div>
                <div class="flex-column content-student">
                    <h2 class="poppins">Siswa</h2>
                    @if (!$hasStudent)
                        <div class="notif-warning flex-row montserrat">
                            <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                            <span>Belum ada siswa yang terdaftar pada kelas {{$room->name}}! Silahkan tambahkan siswa ke kelas ini melalui <b>create siswa</b> atau <b>edit siswa</b>.</span>
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
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($room->student as $data)
                                    <tr>
                                        <th scope="row">{{$loop->index + 1}}</th>
                                        <td>{{$data->nis}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->gender}}</td>
                                        <td>{{$data->address}}</td>
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
                    @if (!$hasTask)
                        <div class="notif-warning flex-row montserrat">
                            <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                            <span>Belum ada tugas yang diberikan pada kelas {{$room->name}}! Silahkan hubungi guru <b>{{$teacher->name}}</b> untuk membuatkan tugas jika diperlukan.</span>
                        </div>
                    @else
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Tipe Tugas</th>
                                    <th scope="col">Tanggal dibuka</th>
                                    <th scope="col">Tanggal ditutup</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($task as $data)
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
                                        <td>{{$data->type}}</td>
                                        <td>{{$data->release}}</td>
                                        <td>{{$data->deadline}}</td>
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
                    <img src="{{asset('img/photo/'. ($teacher->photo == null ? 'default.jpg' : $teacher->photo))}}" alt="foto {{$teacher->name}}">
                    <h3 class="montserrat">{{Str::limit($teacher->name, 22, $end='...')}}</h3>
                    <p class="montserrat">{{Str::limit($teacher->phone, 22, $end='...')}}</p>
                    <p class="montserrat">{{Str::limit($salary, 22, $end='...')}}</p>
                    <p class="montserrat" style="box-sizing: border-box; padding-left: 15px; padding-right: 15px;">{{Str::limit($teacher->address, 100, $end='...')}}</p>
                </div>
            </div>
        </div>
    </div>
@endsection