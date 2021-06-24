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
        <div class="container-content flex-row">
            <div class="container-mapel flex-column" style="border-width: 0; padding: 0;">
                <div class="title-section flex-row">
                    <button type="button" class="btn btn-primary" style="opacity: 0; cursor:default;">Primary</button>
                    <h2 class="poppins"></h2>
                    @if ($hasTeacher)
                      <a href="{{route('roomCreate')}}" class="btn btn-primary poppins" style="background-color: #52B788; border-color: #52B788;font-weight: 600;color: #FBFEFD;">+ Tambah Kelas</a>
                    @else
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary poppins" style="background-color: #52B788; border-color: #52B788;font-weight: 600;color: #FBFEFD;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">+ Tambah Kelas</button>
                      <!-- Modal -->
                      <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="staticBackdropLabel">Tidak Dapat Menambahkan Kelas</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="text-align: justify">
                              Tidak dapat melakukan proses penambahan kelas dikarenakan tidak ada akun Employee dengan status "Tenaga Didik", disarankan untuk membuat akun Employee terlebih dahulu.
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <a href="{{route('employeeCreate')}}" class="btn btn-primary poppins" style="background-color: #52B788; border-color: #52B788;font-weight: 400;color: #FBFEFD;" >Buat Employee</a>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endif
                </div>
                @if (!$hasTeacher)
                  <div class="notif-danger flex-row montserrat">
                    <img src="{{asset('img/icon/notif-danger.svg')}}" alt="danger image">
                    <span>Belum ada akun Employee dengan status <b>Tenaga Didik</b>! Silahkan buat akun employee terlebih dahulu.</span>
                  </div>
                @endif
                @if (count($room) == 0)
                  <div class="notif-warning flex-row montserrat">
                    <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                    <span>Belum ada kelas yang terdaftar pada sistem! Silahkan buat kelas terlebih dahulu.</span>
                  </div>
                @else
                  <div class="row row-cols-1 row-cols-md-4 g-4">
                    @foreach ($room as $data)
                    <div class="col">
                      <div class="card h-100">
                        <img src="{{$data->photo == null ? asset('img/room/default.jpg') : asset('img/room/' . $data->photo)}}" class="card-img-top" alt="foto kelas" style="height: 200px;object-fit: cover;">
                        <div class="card-body">
                          <h5 class="card-title">{{$data->name}}</h5>
                          <p class="card-text" style="text-align: justify">{{$data->description}}</p>
                          <div class="d-grid gap-1 d-md-flex justify-content-md-start" id="button-group">
                            <a href="{{route('roomDetail', $data->id)}}" class="btn btn-success me-md-2" type="button">Detail</a>
                            <a href="{{route('roomEdit', $data->id)}}" class="btn btn-warning me-md-2" type="button">Edit</a>
                            <form action="{{route('roomDelete', $data->id)}}" method="POST">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                    <div class="col"></div>
                    <div class="col"></div>
                  </div>
                @endif
            </div>
        </div>
    </div>
@endsection