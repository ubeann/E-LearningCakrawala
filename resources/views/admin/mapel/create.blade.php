@extends('template.system')

@section('title', 'Buat Mata Pelajaran Baru - E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
@endsection

@section('tugas', 'nav-active')

@section('container')
    <div class="flex-column container vh100" id="container">
        <div class="flex-row container-row">
            <form action="" method="POST" class="flex-column container-form">
                @csrf
                <div class="flex-column form-title">
                    <h3 class="poppins">Membuat Mata Pelajaran Baru</h3>
                    <p class="montserrat">Isilah dengan teliti pada data-data di bawah ini!</p>
                </div>
                @if (session('warning'))
                <div class="notif-warning flex-row montserrat">
                    <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                    <span>{{ session('warning') }}</span>
                </div>
                @endif
                <div class="flex-column form-input">
                    <div class="formel" id="input-star">
                         <input required type="text" name="name" id="name" placeholder="Nama mata pelajaran">
                    </div>
                    <div class="formel" id="input-edit">
                        <input required type="text" name="kode" id="kode" placeholder="Kode mata pelajaran">
                    </div>
                    <div class="formel" id="input-user">
                        <select name="user" id="user">
                            <option value="" disabled selected>Guru pengajar</option>
                            <option value="Tenaga Didik">TenDik</option>
                            <option value="Honorer">Honorer</option>
                        </select>
                    </div>
                    <div class="formel" id="input-plus">
                        <input required type="number" name="KKM" id="KKM" placeholder="Nilai KKM">
                    </div>
                </div>
                <div class="formel medium-btn-submit">
                    <button type="submit" class="poppins">Buat Mata Pelajaran</button>
                </div>
            </form>
            <div class="container-illust">
                <img class="illust-center" src="{{asset('img/illust-mapel.svg')}}" alt="">
            </div>
        </div>
    </div>
@endsection