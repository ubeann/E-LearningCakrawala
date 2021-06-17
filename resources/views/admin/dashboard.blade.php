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
        <div class="container-content flex-row">
            <div class="container-mapel flex-column">
                <div class="title-section">
                    <h2 class="poppins">Mata Pelajaran</h2>
                </div>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <div class="col">
                      <div class="card h-100">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card h-100">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <p class="card-text">This is a short card.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card h-100">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card h-100">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card h-100">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card h-100">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <p class="card-text">This is a short card.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card h-100">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card h-100">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card h-100">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card h-100">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <p class="card-text">This is a short card.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card h-100">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
                        </div>
                      </div>
                    </div>
                    <div class="col">
                      <div class="card h-100">
                        <img src="..." class="card-img-top" alt="...">
                        <div class="card-body">
                          <h5 class="card-title">Card title</h5>
                          <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="container-account flex-column">
                <div class="title-section">
                    <h2 class="poppins">List Akun</h2>
                </div>
                @if (count($admin) >= 1)
                    <ul class="list-group montserrat" id="list-admin">
                        <li class="list-group-item active d-flex justify-content-between align-items-center" aria-current="true" style="background-color: #023047;border-color: #023047;font-weight: 500;">
                            Admin
                            <a href="{{route('adminCreate')}}" class="btn btn-warning">Create</a>
                        </li>
                    @foreach ($admin as $data)
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
                    @endforeach
                    </ul>
                @endif
                @if (count($employee) >= 1)
                    <ul class="list-group montserrat" id="list-employee">
                        <li class="list-group-item active d-flex justify-content-between align-items-center" aria-current="true" style="background-color: #ffd166;border-color: #ffd166;font-weight: 500;color: #212121;">
                            Employee
                            <a href="{{route('employeeCreate')}}" class="btn btn-dark">Create</a>
                        </li>
                    @foreach ($employee as $data)
                        <li class="list-item list-group-item d-flex justify-content-between align-items-center">
                            {{'(' . $data->employee->nip . ') ' . Str::limit($data->employee->name, 16, $end='...')}}
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end" id="button-group">
                                <a href="{{route('employeeEdit', $data->employee->id)}}" class="btn btn-warning me-md-2" type="button">Edit</a>
                                <form action="{{route('employeeDelete', $data->id)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                @endif
                @if (count($student) >= 1)
                    <ul class="list-group montserrat" id="list-student">
                        <li class="list-group-item active d-flex justify-content-between align-items-center" aria-current="true" style="background-color: #118ab2;border-color: #118ab2;font-weight: 500;">
                            Student
                            <a href="{{route('studentCreate')}}" class="btn btn-warning">Create</a>
                        </li>
                    @foreach ($student as $data)
                        <li class="list-item list-group-item d-flex justify-content-between align-items-center">
                            {{'(' . $data->student->nis . ') ' . Str::limit($data->student->name, 16, $end='...')}}
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end" id="button-group">
                                <a href="{{route('studentEdit', $data->student->id)}}" class="btn btn-warning me-md-2" type="button">Edit</a>
                                <form action="{{route('studentDelete', $data->id)}}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endsection