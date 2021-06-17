@extends('template.system')

@section('title', 'Edit Admin ' . $user->username . ' - E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
@endsection

@section('container')
    <div class="flex-column container vh100" id="container">
        <div class="flex-row container-row">
            <form action="{{route('adminEdit', $user->id)}}" method="POST" class="flex-column container-form">
                @csrf
                <div class="flex-column form-title">
                    <h3 class="poppins">Edit Data Admin {{$user->username}}</h3>
                    <p class="montserrat">Isilah dengan teliti pada data-data edit akun admin di bawah ini!</p>
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
                <div class="flex-column form-input">
                    <div class="formel" id="input-id">
                        <input type="text" name="username" id="username" placeholder="Username" value="{{old('username') != null ? old('username') : $user->username}}">
                    </div>
                    <div class="formel" id="input-pass">
                        <input type="password" name="password" id="password" placeholder="Password baru (opsional)">
                    </div>
                </div>
                <div class="formel small-btn-submit">
                    <button type="submit" class="poppins">Simpan</button>
                </div>
            </form>
            <div class="container-illust">
                <img class="illust-center" src="{{asset('img/illust-create-admin.svg')}}" alt="" style="right: 15px; max-width: 625px;">
            </div>
        </div>
    </div>
@endsection