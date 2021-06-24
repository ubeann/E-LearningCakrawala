@extends('template.system')

@section('title', 'Edit Tugas (' . $assignment->name . ') - E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
@endsection

@section('tugas', 'nav-active')

@section('container')
    <div class="flex-column container" id="container">
        <div class="flex-row container-row">
            <form action="{{route('taskEdit', $assignment->id)}}" method="POST" class="flex-column container-form">
                @csrf
                <div class="flex-column form-title">
                    <h3 class="poppins">Edit Tugas ({{$assignment->name}}) Pada Kelas {{$assignment->room->name}}</h3>
                    <p class="montserrat">Isilah dengan teliti pada data-data di bawah ini!</p>
                </div>
                @if ($errors->any())
                <div class="notif-warning flex-row montserrat">
                    <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                    @if ($errors->has('name','type','release','deadline','description'))
                        <span>Silahkan isi semua data yang diperlukan terlebih dahulu!</span>
                    @elseif ($errors->has('type'))
                        @error('type')
                            <span>Silahkan pilih type tugas yang akan dibuat!</span>
                        @enderror
                    @elseif ($errors->has('release'))
                        @error('release')
                            <span>{{$message}}</span>
                        @enderror
                    @elseif ($errors->has('deadline'))
                        @error('deadline')
                            <span>{{$message}}</span>
                        @enderror
                    @else
                        <span>Silahkan isi semua data yang diperlukan terlebih dahulu!</span>
                    @endif
                </div>
                @endif
                @if (session('warning'))
                <div class="notif-warning flex-row montserrat">
                    <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                    <span>{{ session('warning') }}</span>
                </div>
                @endif
                <div class="flex-column form-input">
                    <div class="formel" id="input-star">
                        <input type="text" name="name" id="name" placeholder="Judul tugas" value="{{old('name') != null ? old('name') : $assignment->name}}">
                    </div>
                    <div class="formel" id="input-3dots">
                        <select name="type" id="type">
                            <option disabled {{(old('type') == null and $assignment->type == null) ? 'selected' : ''}}>Tipe Tugas</option>
                            @if (old('type') != null)
                                <option {{old('type') == 'Online Teks' ? 'selected' : ''}} value="Online Teks">Online Teks</option>
                                <option {{old('type') == 'Upload File' ? 'selected' : ''}} value="Upload File">Upload File</option>
                                <option {{old('type') == 'Keduanya' ? 'selected' : ''}} value="Keduanya">Keduanya</option>
                            @else
                                <option {{$assignment->type == 'Online Teks' ? 'selected' : ''}} value="Online Teks">Online Teks</option>
                                <option {{$assignment->type == 'Upload File' ? 'selected' : ''}} value="Upload File">Upload File</option>
                                <option {{$assignment->type == 'Keduanya' ? 'selected' : ''}} value="Keduanya">Keduanya</option>
                            @endif
                        </select>
                    </div>
                    <div class="formel flex-row">
                        <div class="formel" id="input-date">
                            @if (old('release') == null and $assignment->release == null)
                                <input type="text" onfocus="(this.type='datetime-local')" name="release" id="release" placeholder="Tanggal dibuka">
                            @else
                                <input type="datetime-local" name="release" id="release" placeholder="Tanggal dibuka" value="{{old('release') != null ? old('release') : str_replace(' ','T', $assignment->release)}}">
                            @endif
                        </div>
                        <div class="formel" id="input-date">
                            @if (old('deadline') == null and $assignment->release == null)
                                <input type="text" onfocus="(this.type='datetime-local')" name="deadline" id="deadline" placeholder="Tanggal ditutup">
                            @else
                                <input type="datetime-local" name="deadline" id="deadline" placeholder="Tanggal ditutup" value="{{old('deadline') != null ? old('deadline') : str_replace(' ','T', $assignment->deadline)}}">
                            @endif
                        </div>
                    </div>
                    <div class="formel" id="input-edit">
                        <textarea name="description" id="description" placeholder="Deskripsi tugas" cols="30" rows="10">{{old('description') != null ? old('description') : $assignment->description}}</textarea>
                    </div>
                </div>
                <div class="formel small-btn-submit">
                    <button type="submit" class="poppins">Simpan</button>
                </div>
            </form>
            <div class="container-illust">
                <img class="illust-center" src="{{asset('img/illust-tugas.svg')}}" alt="">
            </div>
        </div>
    </div>
@endsection