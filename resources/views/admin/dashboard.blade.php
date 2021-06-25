@extends('template.system')

@section('title', 'Dashboard Admin E-Learning Cakrawala (Admin ' . Auth::user()->id . ')')

@section('css')
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endsection

@section('dashboard', 'nav-active')

@section('container')
    <div class="flex-column" id="container-dashboard">
        <div class="flex-row container-title">
            <h1 class="poppins">Dashboard Admin {{Auth::user()->id}}</h1>
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
        @if (!$hasEmployee or !$hasStudent or !$hasRoom)
          <div class="notif-danger flex-row" style="align-items: flex-start">
            <img src="{{asset('img/icon/notif-danger.svg')}}" alt="danger image">
            <div class="span-list flex-column montserrat" style="gap: 5px;align-items: flex-start">
                <span>Pemberitahuan proses instalasi sistem masih belum selesai! Silahkan lakukan langkah-langkah di bawah ini agar sistem dapat berjalan dengan normal, serta diharap admin dapat memahami alur berjalannya sistem E-Learning Cakrawala. Berikut diantaranya langkah-langkah yang perlu dilakukan:</span>
                <div class="span-list-item flex-row" style="gap: 4px">
                    <span>1) Buat akun employee dengan status "Tenaga Didik"</span>
                    @if ($hasEmployee)
                        <span class="badge bg-success" style="padding: 6px 8px; font-weight: 500">{{$hasEmployee ? 'Selesai' : ''}}</span>
                    @else
                        <span class="badge bg-danger" style="padding: 6px 8px; font-weight: 500">{{!$hasEmployee ? 'Belum' : ''}}</span>
                    @endif
                </div>
                <div class="span-list-item flex-row" style="gap: 4px">
                    <span>2) Buat ruang kelas, dengan syarat telah menyelesaikan tahap 1</span>
                    @if ($hasRoom)
                        <span class="badge bg-success" style="padding: 6px 8px; font-weight: 500">{{$hasRoom ? 'Selesai' : ''}}</span>
                    @else
                        <span class="badge bg-danger" style="padding: 6px 8px; font-weight: 500">{{!$hasRoom ? 'Belum' : ''}}</span>
                    @endif
                </div>
                <div class="span-list-item flex-row" style="gap: 4px">
                    <span>3) Buat akun siswa, dengan syarat telah menyelesaikan tahap 2</span>
                    @if ($hasStudent)
                        <span class="badge bg-success" style="padding: 6px 8px; font-weight: 500">{{$hasStudent ? 'Selesai' : ''}}</span>
                    @else
                        <span class="badge bg-danger" style="padding: 6px 8px; font-weight: 500">{{!$hasStudent ? 'Belum' : ''}}</span>
                    @endif
                </div>
            </div>
          </div>
        @endif
        <div class="container-content flex-row">
            <!-- Modal Room -->
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
            <!-- Modal Student -->
            <div class="modal fade" id="modal-student" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal-studentLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="modal-studentLabel">Tidak Dapat Membuat Akun Siswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" style="text-align: justify">
                            Tidak dapat melakukan proses pembuatan akun Siswa dikarenakan tidak ada ruang kelas yang terdaftar pada sistem, disarankan untuk membuat ruang kelas terlebih dahulu.
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <a href="{{route('roomCreate')}}" class="btn btn-primary poppins" style="background-color: #52B788; border-color: #52B788;font-weight: 400;color: #FBFEFD;">Buat Kelas</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-mapel flex-column">
                <div class="title-section flex-row">
                    <button type="button" class="btn btn-primary" style="opacity: 0; cursor:default;">Primary</button>
                    <h2 class="poppins">Daftar Kelas</h2>
                    @if ($hasEmployee)
                        <a href="{{route('roomCreate')}}" class="btn btn-primary poppins" style="background-color: #52B788; border-color: #52B788;font-weight: 600;color: #FBFEFD;">+ Tambah Kelas</a>
                    @else
                      <!-- Button trigger modal -->
                      <button type="button" class="btn btn-primary poppins" style="background-color: #52B788; border-color: #52B788;font-weight: 600;color: #FBFEFD;" data-bs-toggle="modal" data-bs-target="#staticBackdrop">+ Tambah Kelas</button>
                    @endif
                </div>
                @if (count($room) == 0)
                  <div class="notif-warning flex-row montserrat">
                    <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                    <span>Belum ada kelas yang terdaftar pada sistem! Silahkan buat kelas terlebih dahulu.</span>
                  </div>
                @else
                  <div class="row row-cols-1 row-cols-md-3 g-4">
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
                  </div>
                @endif
            </div>
            <div class="container-account flex-column">
                <div class="title-section">
                    <h2 class="poppins">List Akun</h2>
                </div>
                @if (isset($admin))
                    <ul class="list-group montserrat" id="list-admin">
                        <li class="list-group-item active d-flex justify-content-between align-items-center" aria-current="true" style="background-color: #023047;border-color: #023047;font-weight: 500;">
                            Admin
                            <a href="{{route('adminCreate')}}" class="btn btn-warning">Create</a>
                        </li>
                    @forelse ($admin as $data)
                        <li class="list-item list-group-item d-flex justify-content-between align-items-center">
                            Admin {{$data->username}} {{Auth::user()->id == $data->id ? '(Saya)' : ''}}
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end" id="button-group">
                                <a href="{{route('adminEdit', $data->id)}}" class="btn btn-warning me-md-2" type="button">Edit</a>
                                <form action="{{route('adminDelete', $data->id)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </div>
                        </li>
                        @empty
                          <li class="list-item list-group-item d-flex justify-content-between align-items-center">
                              Belum ada akun admin
                          </li>
                    @endforelse
                    </ul>
                @endif
                @if (isset($employee))
                    <ul class="list-group montserrat" id="list-employee">
                        <li class="list-group-item active d-flex justify-content-between align-items-center" aria-current="true" style="background-color: #ffd166;border-color: #ffd166;font-weight: 500;color: #212121;">
                            Employee
                            <a href="{{route('employeeCreate')}}" class="btn btn-dark">Create</a>
                        </li>
                    @forelse ($employee as $data)
                        <li class="list-item list-group-item d-flex justify-content-between align-items-center">
                            {{'(' . $data->nip . ') ' . Str::limit($data->name, 16, $end='...')}}
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end" id="button-group">
                                <a href="{{route('employeeEdit', $data->id)}}" class="btn btn-warning me-md-2" type="button">Edit</a>
                                <form action="{{route('employeeDelete', $data->id)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </div>
                        </li>
                        @empty
                          <li class="list-item list-group-item d-flex justify-content-between align-items-center">
                              Belum ada akun employee
                          </li>
                    @endforelse
                    </ul>
                @endif
                @if (isset($student))
                    <ul class="list-group montserrat" id="list-student">
                        <li class="list-group-item active d-flex justify-content-between align-items-center" aria-current="true" style="background-color: #118ab2;border-color: #118ab2;font-weight: 500;">
                            Student
                            @if ($hasRoom)
                                <a href="{{route('studentCreate')}}" class="btn btn-warning">Create</a>
                            @else
                                <!-- Button trigger modal -->
                                {{-- <button type="button" class="btn btn-primary poppins" style="background-color: #52B788; border-color: #52B788;font-weight: 600;color: #FBFEFD;" data-bs-toggle="modal" data-bs-target="#modal-student">+ Tambah Kelas</button> --}}
                                <a class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-student">Create</a>
                            @endif
                        </li>
                    @forelse ($student as $data)
                        <li class="list-item list-group-item d-flex justify-content-between align-items-center">
                            {{'(' . $data->nis . ') ' . Str::limit($data->name, 16, $end='...')}}
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end" id="button-group">
                                <a href="{{route('studentEdit', $data->id)}}" class="btn btn-warning me-md-2" type="button">Edit</a>
                                <form action="{{route('studentDelete', $data->id)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </div>
                        </li>
                        @empty
                          <li class="list-item list-group-item d-flex justify-content-between align-items-center">
                              Belum ada akun student
                          </li>
                    @endforelse
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection