@extends('template.system')

@section('title', 'Profil (' . $student->name . ') E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/setting.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endsection

@section('kelas', 'nav-active')

@section('container')
    <div class="flex-column" id="container-setting">
        <div class="flex-row container-title">
            <h1 class="poppins">{{$student->name}}</h1>
        </div>
        <div class="flex-row container-data">
            <div class="flex-column box-container">
                <div class="flex-column container-preview" style="border-radius: 5px;border: 1px solid #DDDDDD; padding-bottom:10px; gap:5px;">
                    <img src="{{$student->photo != null ? asset('img/photo/' . $student->photo) : asset('img/photo/default-student.jpg')}}" alt="foto {{$student->name}}" style="border-bottom-left-radius: 0;border-bottom-right-radius: 0;">
                    <h2 class="poppins">{{$student->name}} {{$student->nis == Auth::user()->username ? '(Saya)' : ''}}</h2>
                    <p class="montserrat">{{$student->gender}}</p>
                </div>
                @if ($student->photo == null)
                    <span class="notif-warning montserrat">{{$student->name}} tidak memiliki foto profil, untuk saat ini akan menggunakan foto <b>default</b> dari sistem.</span>
                @endif
            </div>
            <div class="flex-column container-input">
                @csrf
                <h2 class="poppins">Biodata Diri</h2>
                <div class="flex-row container-question">
                    <span class="montserrat question">NIS</span>
                    <span class="montserrat question-mark">:</span>
                    <div class="formel" id="input-star">
                        <input type="text" name="name" id="name" placeholder="Tidak ada NIS" value="{{$student->nis}}" readonly>
                    </div>
                </div>
                <div class="flex-row container-question">
                    <span class="montserrat question">Nama Lengkap</span>
                    <span class="montserrat question-mark">:</span>
                    <div class="formel" id="input-id">
                        <input type="text" name="name" id="name" placeholder="Tidak ada nama" value="{{$student->name}}" readonly>
                    </div>
                </div>
                <div class="flex-row container-question">
                    <span class="montserrat question">Jenis Kelamin</span>
                    <span class="montserrat question-mark">:</span>
                    <div class="formel" id="input-gender">
                        <input type="text" name="phone" id="phone" placeholder="Tidak ada no HP" value="{{$student->gender}}" readonly>
                    </div>
                </div>
                <div class="flex-row container-question">
                    <span class="montserrat question">Tanggal Lahir</span>
                    <span class="montserrat question-mark">:</span>
                    @if ($student->birthday == null)
                        <div class="formel" id="input-date">
                            <input type="text" name="phone" id="phone" placeholder="Tidak ada tanggal lahir" readonly>
                        </div>
                    @else
                        <div class="formel" id="input-date">
                            <input type="text" name="birthday" id="birthday" placeholder="Tanggal lahir" value="{{date('l, d F Y', strtotime($student->birthday))}}" readonly>
                        </div>
                    @endif
                </div>
                <div class="flex-row container-question" style="align-items: flex-start">
                    <span class="montserrat question">Alamat</span>
                    <span class="montserrat question-mark">:</span>
                    <div class="formel" id="input-address">
                        <textarea name="address" id="address" placeholder="Tidak ada alamat" cols="30" rows="10" readonly>{{$student->address}}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection