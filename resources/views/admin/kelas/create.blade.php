@extends('template.system')

@section('title', 'Buat Kelas Baru - E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
@endsection

@section('kelas', 'nav-active')

@section('container')
    <div class="flex-column container vh100" id="container">
        <div class="flex-row container-row">
            <form action="" method="POST" class="flex-column container-form">
                @csrf
                <div class="flex-column form-title">
                    <h3 class="poppins">Membuat Kelas Baru</h3>
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
                        <input required type="text" name="name" id="name" placeholder="Nama kelas">
                    </div>
                    <div class="formel" id="input-user">
                        <select name="user" id="user">
                            <option value="" disabled selected>Wali Kelas</option>
                            <option value="Tenaga Didik">Laki-laki</option>
                            <option value="Honorer">Perempuan</option>
                        </select>
                    </div>
                    <div class="formel" id="input-date-square">
                        <input required type="text" onfocus="(this.type='date')" name="date" id="date" placeholder="Tahun Ajaran">
                    </div>
                </div>
                <div class="formel small-btn-submit">
                    <button type="submit" class="poppins">Buat Kelas</button>
                </div>
            </form>
            <div class="container-illust">
                <img class="illust-center" src="{{asset('img/illust-kelas.svg')}}" alt="">
            </div>
        </div>
    </div>
@endsection