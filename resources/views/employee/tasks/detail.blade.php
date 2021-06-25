@extends('template.system')

@section('title', 'Tugas ' . str_replace('Tugas','',$assignment->name)  . ' Kelas ' . $assignment->room->name . ' E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/kelas.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <style>
        #button-group {
            /* addition */
            transition: 0.35s;
            /* style */
            opacity: 0;
        }
        tr:hover #button-group {
            /* style */
            opacity: 100;
        }
        /* Chrome, Safari, Edge, Opera */
        input[type='number']::-webkit-outer-spin-button,
        input[type='number']::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type='number'] {
            -moz-appearance: textfield;
        }
        .modal-body a {
            /* text style */
            text-decoration: none;
        }

        .modal-body a:hover {
            /* text style */
            text-decoration: underline;
        }
    </style>
@endsection

@section('tugas', 'nav-active')

@section('container')
    <div class="flex-column" id="container-kelas">
        <div class="flex-column head-content">
            <img src="{{asset('img/room/'. ($assignment->room->photo == null ? 'default.jpg' : $assignment->room->photo))}}" alt="foto {{$assignment->room->name}}">
            <div class="flex-row head-text poppins">
                <h1>{{Str::limit($assignment->name, 50, $end='...')}}</h1>
                <h1>-</h1>
                <h1>{{Str::limit($assignment->room->name, 20, $end='...')}}</h1>
            </div>
        </div>
        <div class="flex-row detail-content">
            <div class="flex-column content-group">
                @if (Session::has('error'))
                    <div class="notif-danger flex-row montserrat">
                        <img src="{{asset('img/icon/notif-danger.svg')}}" alt="danger image">
                        <span>{{Session::get('error')}}</span>
                    </div>
                @endif
                @if (Session::has('warning'))
                    <div class="notif-warning flex-row montserrat">
                        <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                        <span>{{Session::get('warning')}}</span>
                    </div>
                @endif
                @if (Session::has('success'))
                    <div class="notif-success flex-row montserrat">
                        <img src="{{asset('img/icon/notif-success.svg')}}" alt="success image">
                        <span>{{Session::get('success')}}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="notif-warning flex-row montserrat">
                        <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                        @if ($errors->has('mark'))
                            @error('mark')
                                <span>{{$message}}</span>
                            @enderror
                        @elseif ($errors->has('description'))
                            @error('description')
                                <span>{{$message}}</span>
                            @enderror
                        @else
                            <span>Silahkan isi semua data yang diperlukan terlebih dahulu sebelum memberikan nilai!</span>
                        @endif
                    </div>
                @endif
                <div class="flex-column content-description">
                    <h2 class="poppins">Deskripsi</h2>
                    <p class="montserrat">{{$assignment->description}}</p>
                </div>
                <div class="flex-column content-student">
                    <h2 class="poppins">Pengerjaan siswa</h2>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">NIS</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Status</th>
                                <th scope="col">Nilai</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($student as $data)
                                <tr>
                                    <th scope="row">{{$loop->index + 1}}</th>
                                    <td>{{$data->nis}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>
                                        @if (count($submission->where('nis', $data->nis)) < 1)
                                            <span class="badge bg-danger">Belum</span>
                                        @else
                                            <span class="badge bg-success">Terkumpul</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if (count($grade->where('nis', $data->nis)) < 1)
                                            -
                                        @else
                                            {{$grade->where('nis', $data->nis)->first()->mark}}
                                        @endif
                                    </td>
                                    <td>
                                        @if (count($submission->where('nis', $data->nis)) < 1)
                                            Menunggu siswa mengumpulkan
                                        @else
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-start" id="button-group">
                                                <button class="btn btn-warning me-md-2" type="button" style="font-size: 14px; font-weight:500;" data-bs-toggle="modal" data-bs-target="#{{str_replace(' ','',$data->name)}}C">Check</button>
                                                @if (Auth::user()->employee->status == 'Tenaga Didik')
                                                    <button class="btn btn-success me-md-2" type="button" style="font-size: 14px; font-weight:500;" data-bs-toggle="modal" data-bs-target="#{{str_replace(' ','',$data->name)}}N">Nilai</button>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>   
                                @if (count($submission->where('nis', $data->nis)) >= 1)
                                    {{-- Modal Check --}}
                                    <div class="modal fade" id="{{str_replace(' ','',$data->name)}}C" tabindex="-1" aria-labelledby="{{str_replace(' ','',$data->name)}}CLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="{{str_replace(' ','',$data->name)}}CLabel">Hasil Pengerjaan {{$data->name}}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($assignment->type == 'Upload File' or $assignment->type == 'Keduanya')
                                                        <p><b>File Upload:</b>
                                                        @if ($submission->first()->file != null)
                                                        <a href="{{route('submissionDownload', $submission->first()->id)}}" style="text-align: justify">{{$submission->first()->file}}</a>
                                                        @else
                                                            Tidak file upload jawaban.
                                                        @endif
                                                        </p>
                                                    @endif
                                                    @if ($assignment->type == 'Online Teks' or $assignment->type == 'Keduanya')
                                                        <b>Jawaban:</b>
                                                        @if ($submission->first()->description != null)
                                                            <p style="text-align: justify">{{$submission->first()->description}}</p>
                                                        @else
                                                            <p>Tidak ada deskripsi jawaban.</p>
                                                        @endif
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    @if (Auth::user()->employee->status == 'Tenaga Didik')
                                                        <button type="button" class="btn btn-primary" data-bs-target="#{{str_replace(' ','',$data->name)}}N" data-bs-toggle="modal" data-bs-dismiss="modal" style="background-color: #52B788; border-color: #52B788;font-weight: 400;color: #FBFEFD;">Nilai</button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if (Auth::user()->employee->status == 'Tenaga Didik')
                                        {{-- Modal Grade --}}
                                        <div class="modal fade" id="{{str_replace(' ','',$data->name)}}N" tabindex="-1" aria-labelledby="{{str_replace(' ','',$data->name)}}NLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="{{str_replace(' ','',$data->name)}}NLabel">Nilai {{$data->name}}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{route('grading', [$assignment->id, $data->id])}}" method="POST">
                                                        @csrf
                                                        @if (count($grade->where('nis', $data->nis)) >= 1)
                                                            @method('patch')
                                                        @endif
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="mark" class="col-form-label">Nilai:</label>
                                                                <div class="row g-3" style="align-items: flex-end">
                                                                    @if ($grade->where('nis', $data->nis)->first() == null)
                                                                        <div class="col-md-2">
                                                                            <input type="number" name="mark" class="form-control" id="mark" min="0" max="100" oninput="document.getElementById('markSlider').value = this.value" value="{{old('mark') != null ? old('mark') : ''}}">
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <input type="range" name="markSlider" class="form-range" min="0" max="100" id="markSlider" oninput="document.getElementById('mark').value = this.value" value="{{old('mark') != null ? old('mark') : '0'}}">
                                                                        </div>
                                                                    @else
                                                                        <div class="col-md-2">
                                                                            <input type="number" name="mark" class="form-control" id="mark" min="0" max="100" oninput="document.getElementById('markSlider').value = this.value" value="{{old('mark') != null ? old('mark') : $grade->where('nis', $data->nis)->first()->mark}}">
                                                                        </div>
                                                                        <div class="col-md-10">
                                                                            <input type="range" name="markSlider" class="form-range" min="0" max="100" id="markSlider" oninput="document.getElementById('mark').value = this.value" value="{{old('mark') != null ? old('mark') : $grade->where('nis', $data->nis)->first()->mark}}">
                                                                        </div>
                                                                        
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="description" class="col-form-label">Deskripsi:</label>
                                                                @if ($grade->where('nis', $data->nis)->first() == null)
                                                                    <textarea name="description" class="form-control" id="description" rows="8" placeholder="Berikan deskripsi agar siswa semangat belajar">{{old('description') != null ? old('description') : ''}}</textarea>
                                                                @else
                                                                    <textarea name="description" class="form-control" id="description" rows="8" placeholder="Berikan deskripsi agar siswa semangat belajar">{{old('description') != null ? old('description') : $grade->where('nis', $data->nis)->first()->description}}</textarea>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                            <button type="submit" class="btn btn-primary" style="background-color: #52B788; border-color: #52B788;font-weight: 400;color: #FBFEFD;">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex-column title-teacher">
                <h2 class="poppins">Nilai Tertinggi</h2>
                <div class="flex-column content-teacher">
                    @if ($hasRank)
                        <img src="{{asset('img/photo/'. ($ranker->photo == null ? 'default-student.jpg' : $ranker->photo))}}" alt="foto {{$ranker->name}}">
                        <h3 class="montserrat">{{Str::limit($ranker->name, 22, $end='...')}}</h3>
                        @if ($rank->mark > 75)
                            <span class="badge bg-success poppins" style="font-size: 18px; font-weight: 500;">{{$rank->mark}}</span>  
                        @elseif ($rank->mark > 50)
                            <span class="badge bg-warning poppins" style="font-size: 18px; font-weight: 500;">{{$rank->mark}}</span>
                        @else
                            <span class="badge bg-danger poppins" style="font-size: 18px; font-weight: 500;">{{$rank->mark}}</span>
                        @endif
                        <p class="montserrat">{{Str::limit($ranker->gender, 22, $end='...')}}</p>
                        <p class="montserrat" style="box-sizing: border-box; padding-left: 15px; padding-right: 15px;">{{Str::limit($ranker->address, 100, $end='...')}}</p>
                    @else
                        <img src="{{asset('img/photo/'. 'default-student.png')}}" alt="foto default">
                        <h3 class="montserrat">Belum ada siswa yang dinilai</h3>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection