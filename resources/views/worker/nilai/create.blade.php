@extends('template.system')

@section('title', 'Menginput Nilai - E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
@endsection

@section('nilai', 'nav-active')

@section('container')
    <div class="flex-column container vh100" id="container">
        <div class="flex-row container-row">
            <form action="" method="POST" class="flex-column container-form">
                @csrf
                <div class="flex-column form-title">
                    <h3 class="poppins">Menginput Nilai</h3>
                    <p class="montserrat">Isilah dengan teliti pada data-data di bawah ini!</p>
                </div>
                @if (session('warning'))
                <div class="notif-warning flex-row montserrat">
                    <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                    <span>{{ session('warning') }}</span>
                </div>
                @endif
                <div class="flex-column form-input">
                    <div class="formel" id="input-user">
                        <select name="user" id="user">
                            <option value="" disabled selected>Nama siswa</option>
                            <option value="Jalii">Jalii</option>
                            <option value="Rijal">Rijal</option>
                            <option value="Ubean">Ubean</option>
                        </select>
                    </div>
                    <div class="formel" id="input-star">
                        <select name="mapel" id="mapel">
                            <option value="" disabled selected>Nama mata pelajaran</option>
                            <option value="TSI">TSI</option>
                            <option value="MKB">MKB</option>
                            <option value="PW">PW</option>
                        </select>
                    </div>
                    <div class="formel" id="input-3dots">
                        <select name="category" id="category">
                            <option value="" disabled selected>Kategori nilai</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                        </select>
                    </div>
                    <div class="formel" id="input-plus-square">
                        <input required type="number" name="nilai" id="nilai" placeholder="Nilai mata pelajaran">
                    </div>
                </div>
                <div class="formel medium-btn-submit">
                    <button type="submit" class="poppins">Input Nilai</button>
                </div>
            </form>
            <div class="container-illust">
                <img class="illust-center" src="{{asset('img/illust-nilai.svg')}}" alt="">
            </div>
        </div>
    </div>
@endsection