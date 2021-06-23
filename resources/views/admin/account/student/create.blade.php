@extends('template.system')

@section('title', 'Buat Student Baru - E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
@endsection

@section('container')
    <div class="flex-column container" id="container">
        <div class="flex-row container-row">
            <form action="{{route('studentCreate')}}" method="POST" class="flex-column container-form" enctype="multipart/form-data">
                @csrf
                <div class="flex-column form-title">
                    <h3 class="poppins">Buat Student Baru</h3>
                    <p class="montserrat">Isilah dengan teliti pada data-data pembuatan akun student di bawah ini!</p>
                </div>
                @if ($errors->any())
                <div class="notif-warning flex-row montserrat">
                    <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                    @if ($errors->has('fname','address','room','gender','birthday'))
                        <span>Silahkan isi semua data yang diperlukan terlebih dahulu!</span>
                    @elseif ($errors->has('username'))
                        @error('username')
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
                    @else
                        <span>Silahkan isi semua data yang diperlukan terlebih dahulu!</span>
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
                    <div class="formel" id="input-status">
                        <select name="room" id="room">
                            @if (count($room) == 0)
                                <option disabled selected>Tidak ada kelas yang tersedia</option>
                            @else
                                <option disabled {{old('room') == null ? 'selected' : ''}}>Pilih ruangan kelas</option>
                                @foreach ($room as $data)
                                    <option {{old('room') == $data->id ? 'selected' : ''}} value="{{$data->id}}">{{$data->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="formel flex-row">
                        <div class="formel" id="input-gender">
                            <select name="gender" id="gender">
                                <option disabled {{old('gender') == null ? 'selected' : ''}}>Jenis Kelamin</option>
                                <option {{old('gender') == 'Laki-laki' ? 'selected' : ''}} value="Laki-laki">Laki-laki</option>
                                <option {{old('gender') == 'Perempuan' ? 'selected' : ''}} value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="formel" id="input-date">
                            @if (old('birthday') == null)
                                <input type="text" onfocus="(this.type='date')" name="birthday" id="birthday" placeholder="Tanggal lahir">
                            @else
                                <input type="date" name="birthday" id="birthday" placeholder="Tanggal lahir" value="{{old('birthday')}}">
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
                    <button type="submit" class="poppins" onclick="(document.getElementById('photo').type='file')">Buat Student</button>
                </div>
            </form>
            <div class="container-illust">
                <img class="illust-center" src="{{asset('img/illust-settings-students.svg')}}" alt="" style="right: 15px; max-width: 625px;">
            </div>
        </div>
    </div>
@endsection