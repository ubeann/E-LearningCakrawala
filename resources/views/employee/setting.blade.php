@extends('template.system')

@section('title', 'Setting E-Learning Cakrawala (' . Auth::user()->employee->name . ')')

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
                @if ($errors->has('fname','address','salary','tenure'))
                    <span>Silahkan isi semua data yang diperlukan terlebih dahulu!</span>
                @elseif ($errors->has('username'))
                    @error('username')
                        <span>{{$message}}</span>
                    @enderror
                @elseif ($errors->has('phone'))
                    @error('phone')
                        <span>{{$message}}</span>
                    @enderror
                @elseif ($errors->has('password'))
                    @error('password')
                        <span>{{$message}}</span>
                    @enderror
                @elseif ($errors->has('photo'))
                    @error('photo')
                        <span>{{$message}}</span>
                    @enderror
                @endif
            </div>
        @endif
        <div class="flex-row container-data">
            <div class="flex-column box-container">
                <div class="flex-column container-preview" style="border-radius: 5px;border: 1px solid #DDDDDD; padding-bottom:10px; gap:5px;">
                    <img src="{{Auth::user()->employee->photo != null ? asset('img/photo/' . Auth::user()->employee->photo) : asset('img/photo/default.jpg')}}" alt="foto {{Auth::user()->employee->name}}" style="border-bottom-left-radius: 0;border-bottom-right-radius: 0;">
                    <h2 class="poppins">{{Auth::user()->employee->name}}</h2>
                    <p class="montserrat">{{Auth::user()->employee->status}}</p>
                    <p class="montserrat">{{Auth::user()->employee->phone}}</p>
                    <p class="montserrat" style="padding: 0 10px;">{{Auth::user()->employee->address}}</p>
                </div>
                @if (Auth::user()->employee->photo == null)
                    <span class="notif-warning montserrat">Anda tidak memiliki foto profil, untuk saat ini akan menggunakan foto <b>default</b> dari sistem.</span>
                @endif
            </div>
            <form class="flex-column container-input" action="{{route('setting')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <h2 class="poppins">Biodata Diri</h2>
                <div class="flex-row container-question">
                    <span class="montserrat question">Nama Lengkap</span>
                    <span class="montserrat question-mark">:</span>
                    <div class="formel" id="input-id">
                        <input type="text" name="name" id="name" placeholder="Nama lenkap" value="{{old('name') != null ? old('name') : Auth::user()->employee->name}}">
                    </div>
                </div>
                <div class="flex-row container-question">
                    <span class="montserrat question">Nomor HP</span>
                    <span class="montserrat question-mark">:</span>
                    <div class="formel" id="input-phone">
                        <input type="text" name="phone" id="phone" placeholder="Nomor HP" value="{{old('phone') != null ? old('phone') : Auth::user()->employee->phone}}">
                    </div>
                </div>
                <div class="flex-row container-question" style="align-items: flex-start">
                    <span class="montserrat question">Alamat</span>
                    <span class="montserrat question-mark">:</span>
                    <div class="formel" id="input-address">
                        <textarea name="address" id="address" placeholder="Alamat" cols="30" rows="10">{{old('address') != null ? old('address') : Auth::user()->employee->address}}</textarea>
                    </div>
                </div>
                <div class="flex-row container-question">
                    <span class="montserrat question">Foto</span>
                    <span class="montserrat question-mark">:</span>
                    <div class="formel" id="input-3dots">
                        <input type="text" onfocus="(this.type='file')" accept="image/*" name="photo" id="photo" placeholder="Ganti foto (opsional)">
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
                    <button type="submit" class="poppins" onclick="(document.getElementById('photo').type='file')">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection