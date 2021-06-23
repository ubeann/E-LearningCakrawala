@extends('template.system')

@section('title', 'Setting E-Learning Cakrawala (Admin ' . Auth::user()->id . ')')

@section('css')
    <link rel="stylesheet" href="{{asset('css/setting.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endsection

@section('settings', 'nav-active')

@section('container')
    <div class="flex-column" id="container-setting">
        <div class="flex-row container-title">
            <h1 class="poppins">Pengaturan</h1>
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
        @if ($errors->any())
        <div class="notif-warning flex-row montserrat">
            <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
            @if ($errors->has('username','password'))
                <span>Silahkan isi username dan password terlebih dahulu!</span>
            @else
                @foreach ($errors->all() as $error)
                    <span>{{ $error }}</span>
                @endforeach
            @endif
        </div>
        @endif
        <div class="flex-row container-data">
            <div class="flex-column container-preview">
                <img src="{{asset('img/photo/default-admin.jpg')}}" alt="foto admin {{Auth::user()->username}}">
                <h2 class="poppins">Admin {{Auth::user()->username}}</h2>
                <span class="montserrat">Admin tidak memiliki foto profil, hanya dapat menggunakan foto <b>default</b></span>
            </div>
            <form class="flex-column container-input" action="{{route('adminEdit', Auth::user()->id)}}" method="POST">
                @csrf
                @method('patch')
                <h2 class="poppins">Data Admin</h2>
                <div class="flex-row container-question">
                    <span class="montserrat question">Username</span>
                    <span class="montserrat question-mark">:</span>
                    <div class="formel" id="input-id">
                        <input type="text" name="username" id="username" placeholder="Username" value="{{old('username') != null ? old('username') : Auth::user()->username}}">
                    </div>
                </div>
                <div class="flex-row container-question">
                    <span class="montserrat question">Ganti password</span>
                    <span class="montserrat question-mark">:</span>
                    <div class="formel" id="input-pass">
                        <input type="password" name="password" id="password" placeholder="Ganti password? (opsional)">
                    </div>
                </div>
                <div class="formel small-btn-submit">
                    <button type="submit" class="poppins">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection