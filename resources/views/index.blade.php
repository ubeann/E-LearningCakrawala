@extends('template.system')

@section('title', 'Selamat Datang di E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
@endsection

@section('container')
    <div class="flex-column container vh100" id="container">
        <div class="flex-column container-title">
            <h1 class="montserrat">e-Learning</h1>
            <h2 class="montserrat">SMAN 15 Cakrawala</h2>
        </div>
        <div class="flex-row container-row">
            <form action="" method="POST" class="flex-column container-form">
                @csrf
                <div class="flex-column form-title">
                    <h3 class="poppins">Login</h3>
                    <p class="montserrat">Selamat datang di web e-learning SMAN 15 Cakrawala. E-Learning adalah konsep pendidikan yang memanfaatkan Teknologi Informasi dan Komunikasi dalam proses belajar mengajar.</p>
                </div>
                @if (session('warning'))
                <div class="notif-warning flex-row montserrat">
                    <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                    <span>{{ session('warning') }}</span>
                </div>
                @endif
                <div class="flex-column form-input">
                    <div class="formel" id="input-id">
                        <input required type="number" name="id" id="id" placeholder="NIP/NIS">
                    </div>
                    <div class="formel" id="input-pass">
                        <input required type="password" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="formel flex-row">
                        <div class="remember flex-row">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember" class="montserrat link">Ingat saya</label>
                        </div>
                        <a href="#" class="montserrat link"> Lupa password?</a>
                    </div>
                </div>
                <div class="formel">
                    <button type="submit" class="poppins">Login</button>
                </div>
            </form>
            <div class="container-illust">
                <img src="{{asset('img/illust-index.svg')}}" alt="">
            </div>
        </div>
    </div>
@endsection