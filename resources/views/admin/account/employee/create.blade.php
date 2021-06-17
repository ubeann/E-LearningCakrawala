@extends('template.system')

@section('title', 'Buat Employee Baru - E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
@endsection

@section('container')
    <div class="flex-column container" id="container">
        <div class="flex-row container-row">
            <form action="{{route('employeeCreate')}}" method="POST" class="flex-column container-form" enctype="multipart/form-data">
                @csrf
                <div class="flex-column form-title">
                    <h3 class="poppins">Buat Employee Baru</h3>
                    <p class="montserrat">Isilah dengan teliti pada data-data pembuatan akun employee di bawah ini!</p>
                </div>
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
                <div class="flex-column form-input">
                    <div class="formel" id="input-id">
                        <input type="text" name="username" id="username" placeholder="Username" value="{{old('username')}}">
                    </div>
                    <div class="formel" id="input-pass">
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="formel flex-row">
                        <div class="formel" id="input-user">
                            <input type="text" name="fname" id="fname" placeholder="Nama depan" value="{{old('fname')}}">
                        </div>
                        <div class="formel" id="input-user">
                            <input type="text" name="lname" id="lname" placeholder="Nama belakang" value="{{old('lname')}}">
                        </div>
                    </div>
                    <div class="formel" id="input-phone">
                        <input type="text" name="phone" id="phone" placeholder="Nomor HP" value="{{old('phone')}}">
                    </div>
                    <div class="formel" id="input-status">
                        <select name="status" id="status">
                            <option disabled selected>Status</option>
                            <option {{old('status') == 'Tenaga Didik' ? 'selected' : ''}} value="Tenaga Didik">Tenaga Didik</option>
                            <option {{old('status') == 'Honorer' ? 'selected' : ''}} value="Honorer">Honorer</option>
                        </select>
                    </div>
                    <div class="formel flex-row">
                        <div class="formel" id="input-salary">
                            <input type="number" name="salary" id="salary" placeholder="Gaji" value="{{old('salary')}}">
                        </div>
                        <div class="formel" id="input-date">
                            @if (old('tenure') == null)
                                <input type="text" onfocus="(this.type='month')" name="tenure" id="tenure" placeholder="Tahun masuk">
                            @else
                                <input type="month" name="tenure" id="tenure" placeholder="Tahun masuk" value="{{old('tenure')}}">
                            @endif
                        </div>
                    </div>
                    <div class="formel" id="input-3dots">
                        <input type="text" onfocus="(this.type='file')" accept="image/*" name="photo" id="photo" placeholder="Upload foto (opsional)">
                    </div>
                    <div class="formel" id="input-address">
                        <textarea name="address" id="address" placeholder="Alamat" cols="30" rows="10">{{old('address')}}</textarea>
                    </div>
                </div>
                <div class="formel small-btn-submit">
                    <button type="submit" class="poppins" onclick="(document.getElementById('photo').type='file')">Buat Employee</button>
                </div>
            </form>
            <div class="container-illust">
                <img class="illust-center" src="{{asset('img/illust-settings-tk.svg')}}" alt="" style="right: 15px; max-width: 625px;">
            </div>
        </div>
    </div>
@endsection