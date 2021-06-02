@extends('template.system')

@section('title', 'Pengaturan - E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
@endsection

@section('settings', 'nav-active')

{{-- @section('container')
    <div class="flex-column container vh100" id="container">
        <div class="flex-row container-row">
            <form action="" method="POST" class="flex-column container-form">
                @csrf
                <div class="flex-column form-title">
                    <h3 class="poppins">Data Diri Tenaga Kerja</h3>
                    <p class="montserrat">Isilah dengan teliti pada data-data di bawah ini!</p>
                </div>
                @if (session('warning'))
                <div class="notif-warning flex-row montserrat">
                    <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                    <span>{{ session('warning') }}</span>
                </div>
                @endif
                <div class="flex-column form-input">
                    <div class="formel flex-row">
                        <div class="formel" id="input-user">
                            <input required type="text" name="fname" id="fname" placeholder="Nama depan">
                        </div>
                        <div class="formel" id="input-user">
                            <input required type="text" name="lname" id="lname" placeholder="Nama belakang">
                        </div>
                    </div>
                    <div class="formel" id="input-phone">
                        <input required type="text" name="phone" id="phone" placeholder="Nomor HP">
                    </div>
                    <div class="formel" id="input-status">
                        <select name="status" id="status">
                            <option value="" disabled selected>Status</option>
                            <option value="Tenaga Didik">Tenaga Didik</option>
                            <option value="Honorer">Honorer</option>
                        </select>
                    </div>
                    <div class="formel flex-row">
                        <div class="formel" id="input-salary">
                            <input required type="number" name="salary" id="salary" placeholder="Gaji">
                        </div>
                        <div class="formel" id="input-date">
                            <input required type="text" onfocus="(this.type='month')" name="tenure" id="tenure" placeholder="Tahun masuk">
                        </div>
                    </div>
                    <div class="formel" id="input-address">
                        <textarea required name="address" id="adress" placeholder="Alamat" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="formel small-btn-submit">
                    <button type="submit" class="poppins">Simpan</button>
                </div>
            </form>
            <div class="container-illust">
                <img class="illust-center" src="{{asset('img/illust-settings-tk.svg')}}" alt="">
            </div>
        </div>
    </div>
@endsection --}}

@section('container')
    <div class="flex-column container vh100" id="container">
        <div class="flex-row container-row">
            <form action="" method="POST" class="flex-column container-form">
                @csrf
                <div class="flex-column form-title">
                    <h3 class="poppins">Data Diri Siswa</h3>
                    <p class="montserrat">Isilah dengan teliti pada data-data di bawah ini!</p>
                </div>
                @if (session('warning'))
                <div class="notif-warning flex-row montserrat">
                    <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                    <span>{{ session('warning') }}</span>
                </div>
                @endif
                <div class="flex-column form-input">
                    <div class="formel flex-row">
                        <div class="formel" id="input-user">
                            <input required type="text" name="fname" id="fname" placeholder="Nama depan">
                        </div>
                        <div class="formel" id="input-user">
                            <input required type="text" name="lname" id="lname" placeholder="Nama belakang">
                        </div>
                    </div>
                    <div class="formel" id="input-gender">
                        <select name="gender" id="gender">
                            <option value="" disabled selected>Jenis Kelamin</option>
                            <option value="Tenaga Didik">Laki-laki</option>
                            <option value="Honorer">Perempuan</option>
                        </select>
                    </div>
                    <div class="formel" id="input-birth">
                        <input required type="text" onfocus="(this.type='date')" name="birth" id="birth" placeholder="Tanggal lahir">
                    </div>
                    <div class="formel" id="input-address">
                        <textarea required name="address" id="address" placeholder="Alamat" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="formel small-btn-submit">
                    <button type="submit" class="poppins">Simpan</button>
                </div>
            </form>
            <div class="container-illust">
                <img class="illust-center" src="{{asset('img/illust-settings-students.svg')}}" alt="">
            </div>
        </div>
    </div>
@endsection