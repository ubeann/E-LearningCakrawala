@extends('template.system')

@section('title', 'Buat Kelas Baru - E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
@endsection

@section('kelas', 'nav-active')

@section('container')
    <div class="flex-column container" id="container">
        <div class="flex-row container-row">
            <form action="{{route('roomCreate')}}" method="POST" class="flex-column container-form" enctype="multipart/form-data">
                @csrf
                <div class="flex-column form-title">
                    <h3 class="poppins">Buat Kelas Baru</h3>
                    <p class="montserrat">Isilah dengan teliti pada data-data pembuatan ruangan kelas di bawah ini!</p>
                </div>
                @if ($errors->any())
                <div class="notif-warning flex-row montserrat">
                    <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                    @if ($errors->has('name','teacher_id','year','description'))
                        <span>Silahkan isi semua data yang diperlukan terlebih dahulu!</span>
                    @elseif ($errors->has('name'))
                        @error('name')
                            <span>{{$message}}</span>
                        @enderror
                    @elseif ($errors->has('teacher_id'))
                        @error('teacher_id')
                            <span>{{$message}}</span>
                        @enderror
                    @elseif ($errors->has('year'))
                        @error('year')
                            <span>{{$message}}</span>
                        @enderror
                    @elseif ($errors->has('description'))
                        @error('description')
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
                    <div class="formel" id="input-star">
                        <input type="text" name="name" id="name" placeholder="Nama kelas" value="{{old('name')}}">
                    </div>
                    <div class="formel flex-row">
                        <div class="formel" id="input-user">
                            <select name="teacher_id" id="teacher_id">
                                @if (count($data) == 0)
                                    <option disabled selected>Tidak ada tenaga didik</option>
                                @else
                                    <option disabled {{old('teacher_id') == null ? 'selected' : ''}}>Wali Kelas</option>
                                    @foreach ($data as $teacher)
                                        <option {{old('teacher_id') == $teacher->nip ? 'selected' : ''}} value="{{$teacher->nip}}">{{$teacher->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="formel" id="input-date-square">
                            @if (old('year') == null)
                                <input type="text" onfocus="(this.type='month')" name="year" id="year" placeholder="Tahun ajaran">
                            @else
                                <input type="month" name="year" id="year" placeholder="Tahun ajaran" value="{{old('year')}}">
                            @endif
                        </div>
                    </div>
                    <div class="formel" id="input-3dots">
                        <input type="text" onfocus="(this.type='file')" accept="image/*" name="photo" id="photo" placeholder="Upload foto (opsional)">
                    </div>
                    <div class="formel" id="input-edit">
                        <textarea name="description" id="description" placeholder="Deskripsi" cols="30" rows="10">{{old('description')}}</textarea>
                    </div>
                </div>
                <div class="formel small-btn-submit">
                    <button type="submit" class="poppins" onclick="(document.getElementById('photo').type='file')">Buat Kelas</button>
                </div>
            </form>
            <div class="container-illust">
                <img class="illust-center" src="{{asset('img/illust-kelas.svg')}}" alt="" style="right: 15px; max-width: 625px;">
            </div>
        </div>
    </div>
@endsection