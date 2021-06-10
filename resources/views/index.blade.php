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
            <form action="{{ url('login') }}" method="POST" class="flex-column container-form">
                @csrf
                <div class="flex-column form-title">
                    <h3 class="poppins">Login</h3>
                    <p class="montserrat">Selamat datang di web e-learning SMAN 15 Cakrawala. E-Learning adalah konsep pendidikan yang memanfaatkan Teknologi Informasi dan Komunikasi dalam proses belajar mengajar.</p>
                </div>
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
                @if (Session::has('error'))
                <div class="notif-danger flex-row montserrat">
                    <img src="{{asset('img/icon/notif-danger.svg')}}" alt="danger image">
                    <span>{{Session::get('error')}}</span>
                </div>
                @endif
                <div class="flex-column form-input">
                    <div class="formel" id="input-id">
                        <input type="number" name="username" id="id" value="{{ old('username') }}" placeholder="NIP/NIS">
                    </div>
                    <div class="formel" id="input-pass">
                        <input type="password" name="password" id="password" value="{{ old('password') }}" placeholder="Password">
                    </div>
                    <div class="formel flex-row">
                        <div class="remember flex-row">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
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