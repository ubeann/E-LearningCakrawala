@extends('template.system')

@section('title', 'Daftar Kelas E-Learning Cakrawala (Admin ' . Auth::user()->id . ')')

@section('css')
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endsection

@section('kelas', 'nav-active')

@section('container')
    <div class="flex-column" id="container-dashboard">
        <div class="flex-row container-title">
            <h1 class="poppins">Daftar Kelas</h1>
        </div>
        <div class="container-content flex-row">
            <div class="container-mapel flex-column" style="border-width: 0; padding: 0;">
                @if (!$hasRoom)
                    <div class="notif-warning flex-row montserrat">
                        <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                        @if (Auth::user()->employee->status == 'Tenaga Didik')
                            <span>Akun anda ({{Auth::user()->employee->name}}) tidak terdaftar pada kelas manapun! Silahkan hubungin admin untuk mendaftarkan anda pada suatu kelas.</span>
                        @else
                            <span>Tidak ada kelas yang terdaftar pada sistem! Silahkan hubungin admin untuk melakukan pengecekan apabila terjadi error.</span>
                        @endif
                    </div>
                @else
                  <div class="row row-cols-1 row-cols-md-4 g-4">
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
                @endif
            </div>
        </div>
    </div>
@endsection