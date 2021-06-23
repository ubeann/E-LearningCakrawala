@extends('template.system')

@section('title', 'Edit Student ' . $student->name . ' - E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
@endsection

@section('container')
    <div class="flex-column container" id="container">
        <div class="flex-row container-row">
            <form action="{{route('studentEdit', $student->id)}}" method="POST" class="flex-column container-form" enctype="multipart/form-data">
                @csrf
                <div class="flex-column form-title">
                    <h3 class="poppins">Edit Student {{Str::limit($student->name, 20, $end='...')}}</h3>
                    <p class="montserrat">Isilah dengan teliti pada data-data edit akun student di bawah ini!</p>
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
                        <input type="text" name="username" id="username" placeholder="Username" value="{{old('username') != null ? old('username') : $student->nis}}">
                    </div>
                    <div class="formel" id="input-pass">
                        <input type="password" name="password" id="password" placeholder="Password baru (opsional)">
                    </div>
                    <div class="formel flex-row">
                        <div class="formel" id="input-user">
                            <input type="text" name="fname" id="fname" placeholder="Nama depan" value="{{old('fname') != null ? old('fname') : $firstName}}">
                        </div>
                        <div class="formel" id="input-user">
                            <input type="text" name="lname" id="lname" placeholder="Nama belakang" value="{{old('lname') != null ? old('lname') : $lastName}}">
                        </div>
                    </div>
                    <div class="formel" id="input-status">
                        <select name="room" id="room">
                            @if (count($room) == 0)
                                <option disabled selected>Tidak ada kelas yang tersedia</option>
                            @else
                                <option disabled {{(old('room') == null and $student->room_id == null) ? 'selected' : ''}}>Pilih ruangan kelas</option>
                                @foreach ($room as $data)
                                    @if (old('room') != null)
                                        <option {{old('room') == $data->id ? 'selected' : ''}} value="{{$data->id}}">{{$data->name}}</option>
                                    @else 
                                        <option {{$student->room_id == $data->id ? 'selected' : ''}} value="{{$data->id}}">{{$data->name}}</option>
                                    @endif
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="formel flex-row">
                        <div class="formel" id="input-gender">
                            <select name="gender" id="gender">
                                <option disabled {{(old('gender') == null and $student->gender == null) ? 'selected' : ''}}>Jenis Kelamin</option>
                                <option {{old('gender') == 'Laki-laki' ? 'selected' : ($student->gender == 'Laki-laki' ? 'selected' : '')}} value="Laki-laki">Laki-laki</option>
                                <option {{old('gender') == 'Perempuan' ? 'selected' : ($student->gender == 'Perempuan' ? 'selected' : '')}} value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="formel" id="input-date">
                            @if (old('birthday') == null and $student->birthday == null)
                                <input type="text" onfocus="(this.type='date')" name="birthday" id="birthday" placeholder="Tanggal lahir">
                            @else
                                <input type="date" name="birthday" id="birthday" placeholder="Tanggal lahir" value="{{old('birthday') != null ? old('birthday') : $student->birthday}}">
                            @endif
                        </div>
                    </div>
                    <div class="formel" id="input-3dots">
                        <input type="text" onfocus="(this.type='file')" accept="image/*" name="photo" id="photo" placeholder="Upload foto (opsional)">
                    </div>
                    <div class="formel" id="input-address">
                        <textarea name="address" id="address" placeholder="Alamat" cols="30" rows="10">{{old('address') != null ? old('address') : $student->address}}</textarea>
                    </div>
                </div>
                <div class="formel small-btn-submit">
                    <button type="submit" class="poppins" onclick="(document.getElementById('photo').type='file')">Simpan</button>
                </div>
            </form>
            <div class="container-illust">
                <img class="illust-center" src="{{asset('img/illust-settings-students.svg')}}" alt="" style="right: 15px; max-width: 625px;">
            </div>
        </div>
    </div>
@endsection