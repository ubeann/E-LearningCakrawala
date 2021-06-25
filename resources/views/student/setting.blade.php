@extends('template.system')

@section('title', 'Setting E-Learning Cakrawala (' . Auth::user()->student->name . ')')

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
                @if ($errors->has('name','address','gender','birthday'))
                    <span>Silahkan isi semua data yang diperlukan terlebih dahulu!</span>
                @elseif ($errors->has('password'))
                    @error('password')
                        <span>{{$message}}</span>
                    @enderror
                @elseif ($errors->has('photo'))
                    @error('photo')
                        <span>{{$message}}</span>
                    @enderror
                @else
                    <span>Silahkan isi semua data yang diperlukan terlebih dahulu!</span>
                @endif
            </div>
        @endif
        @if (Auth::user()->student->room == null)
            <div class="notif-danger flex-row montserrat">
                <img src="{{asset('img/icon/notif-danger.svg')}}" alt="danger image">
                <span>Akun anda ({{Auth::user()->student->name}}) tidak terdaftar pada kelas manapun silahkan hubungin admin untuk mendaftarkan anda pada suatu kelas.</span>
            </div>
        @endif
        <div class="flex-row container-data">
            <div class="flex-column box-container">
                <div class="flex-column container-preview" style="border-radius: 5px;border: 1px solid #DDDDDD; padding-bottom:10px; gap:5px;">
                    <img src="{{Auth::user()->student->photo != null ? asset('img/photo/' . Auth::user()->student->photo) : asset('img/photo/default-student.jpg')}}" alt="foto {{Auth::user()->student->name}}" style="border-bottom-left-radius: 0;border-bottom-right-radius: 0;">
                    <h2 class="poppins">{{Auth::user()->student->name}}</h2>
                    @if (Auth::user()->student->room != null)
                        <p class="montserrat">Kelas {{Auth::user()->student->room->name}}</p>
                    @endif
                    <p class="montserrat">{{Auth::user()->student->gender}}</p>
                    <p class="montserrat">{{date('l, d F Y', strtotime(Auth::user()->student->birthday))}}</p>
                    <p class="montserrat" style="padding: 0 10px;">{{Auth::user()->student->address}}</p>
                </div>
                @if (Auth::user()->student->photo == null)
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
                        <input type="text" name="name" id="name" placeholder="Nama lenkap" value="{{old('name') != null ? old('name') : Auth::user()->student->name}}">
                    </div>
                </div>
                <div class="flex-row container-question">
                    <span class="montserrat question">Jenis Kelamin</span>
                    <span class="montserrat question-mark">:</span>
                    <div class="formel" id="input-gender">
                        @if (old('gender') != null)
                            <select name="gender" id="gender">
                                <option disabled {{(old('gender') == null and Auth::user()->student->gender == null) ? 'selected' : ''}}>Jenis Kelamin</option>
                                <option {{old('gender') == 'Laki-laki' ? 'selected' : ''}} value="Laki-laki">Laki-laki</option>
                                <option {{old('gender') == 'Perempuan' ? 'selected' : ''}} value="Perempuan">Perempuan</option>
                            </select>
                        @else
                            <select name="gender" id="gender">
                                <option disabled {{(old('gender') == null and Auth::user()->student->gender == null) ? 'selected' : ''}}>Jenis Kelamin</option>
                                <option {{Auth::user()->student->gender == 'Laki-laki' ? 'selected' : ''}} value="Laki-laki">Laki-laki</option>
                                <option {{Auth::user()->student->gender == 'Perempuan' ? 'selected' : ''}} value="Perempuan">Perempuan</option>
                            </select>
                        @endif
                    </div>
                </div>
                <div class="flex-row container-question">
                    <span class="montserrat question">Tanggal Lahir</span>
                    <span class="montserrat question-mark">:</span>
                    <div class="formel" id="input-date">
                        @if (old('birthday') == null and Auth::user()->student->birthday == null)
                            <input type="text" onfocus="(this.type='date')" name="birthday" id="birthday" placeholder="Tanggal lahir">
                        @else
                            <input type="date" name="birthday" id="birthday" placeholder="Tanggal lahir" value="{{old('birthday') != null ? old('birthday') : Auth::user()->student->birthday}}">
                        @endif
                    </div>
                </div>
                <div class="flex-row container-question" style="align-items: flex-start">
                    <span class="montserrat question">Alamat</span>
                    <span class="montserrat question-mark">:</span>
                    <div class="formel" id="input-address">
                        <textarea name="address" id="address" placeholder="Alamat" cols="30" rows="10">{{old('address') != null ? old('address') : Auth::user()->student->address}}</textarea>
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