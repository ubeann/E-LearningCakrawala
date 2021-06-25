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
                        @if ($errors->has('file'))
                            @error('file')
                                <span>{{$message}}</span>
                            @enderror
                        @elseif ($errors->has('description'))
                            @error('description')
                                <span>{{$message}}</span>
                            @enderror
                        @else
                            <span>Silahkan isi semua data yang diperlukan terlebih dahulu sebelum mengirim jawaban!</span>
                        @endif
                    </div>
                @endif
                <div class="flex-column content-description">
                    <h2 class="poppins">Deskripsi</h2>
                    <p class="montserrat">{{$assignment->description}}</p>
                </div>
                <div class="flex-column content-submission">
                    <h2 class="poppins">Pengerjaan</h2>
                    @if (time() < strtotime($assignment->release))
                        <div class="notif-warning flex-row montserrat" style="margin-bottom: 10px">
                            <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                            <span>Belum bisa mengumpulkan jawaban, tugas dibuka pada 
                                @if (\Carbon\Carbon::now()->diffInDays($assignment->release) >= 1)
                                    {{\Carbon\Carbon::now()->diffInDays($assignment->release)}} hari
                                @endif
                                @if (\Carbon\Carbon::now()->diffInHours($assignment->release) >= 1)
                                    {{\Carbon\Carbon::now()->diffInHours($assignment->release) - (\Carbon\Carbon::now()->diffInDays($assignment->release) * 24)}} jam
                                @endif
                                @if (\Carbon\Carbon::now()->diffInMinutes($assignment->release) >= 1 and \Carbon\Carbon::now()->diffInDays($assignment->release) == 0)
                                    {{\Carbon\Carbon::now()->diffInMinutes($assignment->release) - (\Carbon\Carbon::now()->diffInHours($assignment->release) * 60)}} menit
                                @endif
                                @if (\Carbon\Carbon::now()->diffInSeconds($assignment->release) >= 1 and \Carbon\Carbon::now()->diffInHours($assignment->release) == 0)
                                    {{\Carbon\Carbon::now()->diffInSeconds($assignment->release) - (\Carbon\Carbon::now()->diffInMinutes($assignment->release) * 60)}} detik
                                @endif
                                lagi.
                            </span>
                        </div>
                    @elseif (time() > strtotime($assignment->deadline) and count($submission) < 1)
                        <div class="notif-danger flex-row montserrat">
                            <img src="{{asset('img/icon/notif-danger.svg')}}" alt="danger image">
                            <span>Anda tidak mengumpulkan tugas, tidak dapat mengecek jawaban!</span>
                        </div>
                    @endif
                    <div class="flex-column submission-list">
                        <div class="flex-row submission-detail" style="border-bottom: 1px solid #E05780">
                            <h3 class="poppins">Status</h3>
                            <p class="montserrat">
                                @if (count($submission) >= 1)
                                    @if ($submission->first()->updated_at != null)
                                        Terkumpul 
                                        @if (\Carbon\Carbon::now()->diffInDays($submission->first()->updated_at) >= 1)
                                            {{\Carbon\Carbon::now()->diffInDays($submission->first()->updated_at)}} hari
                                        @endif
                                        @if (\Carbon\Carbon::now()->diffInHours($submission->first()->updated_at) >= 1)
                                            {{\Carbon\Carbon::now()->diffInHours($submission->first()->updated_at) - (\Carbon\Carbon::now()->diffInDays($submission->first()->updated_at) * 24)}} jam
                                        @endif
                                        @if (\Carbon\Carbon::now()->diffInMinutes($submission->first()->updated_at) >= 1 and \Carbon\Carbon::now()->diffInDays($submission->first()->updated_at) == 0)
                                            {{\Carbon\Carbon::now()->diffInMinutes($submission->first()->updated_at) - (\Carbon\Carbon::now()->diffInHours($submission->first()->updated_at) * 60)}} menit
                                        @endif
                                        @if (\Carbon\Carbon::now()->diffInSeconds($submission->first()->updated_at) >= 1 and \Carbon\Carbon::now()->diffInHours($submission->first()->updated_at) == 0)
                                            {{\Carbon\Carbon::now()->diffInSeconds($submission->first()->updated_at) - (\Carbon\Carbon::now()->diffInMinutes($submission->first()->updated_at) * 60)}} detik
                                        @endif
                                        yang lalu
                                        @else
                                            -
                                    @endif
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div class="flex-row submission-detail" style="border-bottom: 1px solid #E05780">
                            <h3 class="poppins">Penilaian</h3>
                            <p class="montserrat">
                                @if (count($assignment->grade->where('nis', Auth::user()->username)) >= 1)
                                    {{$assignment->grade->where('nis', Auth::user()->username)->first()->mark}}
                                @elseif (count($submission) >= 1)
                                    Belum dinilai
                                @else
                                    Tidak dinilai
                                @endif
                            </p>
                        </div>
                        <div class="flex-row submission-detail" style="border-bottom: 1px solid #E05780">
                            <h3 class="poppins">Tgl Pengumpulan</h3>
                            <p class="montserrat">{{date('l, d F - H:i', strtotime($assignment->deadline))}}</p>
                        </div>
                        <div class="flex-row submission-detail" style="border-bottom: 1px solid #E05780">
                            <h3 class="poppins">Waktu Tersisa</h3>
                            <p class="montserrat">
                                @if (time() > strtotime($assignment->release) and time() < strtotime($assignment->deadline))
                                    @if (\Carbon\Carbon::now()->diffInDays($assignment->deadline) >= 1)
                                        {{\Carbon\Carbon::now()->diffInDays($assignment->deadline)}} hari
                                    @endif
                                    @if (\Carbon\Carbon::now()->diffInHours($assignment->deadline) >= 1)
                                        {{\Carbon\Carbon::now()->diffInHours($assignment->deadline) - (\Carbon\Carbon::now()->diffInDays($assignment->deadline) * 24)}} jam
                                    @endif
                                    @if (\Carbon\Carbon::now()->diffInMinutes($assignment->deadline) >= 1 and \Carbon\Carbon::now()->diffInDays($assignment->deadline) == 0)
                                        {{\Carbon\Carbon::now()->diffInMinutes($assignment->deadline) - (\Carbon\Carbon::now()->diffInHours($assignment->deadline) * 60)}} menit
                                    @endif
                                    @if (\Carbon\Carbon::now()->diffInSeconds($assignment->deadline) >= 1 and \Carbon\Carbon::now()->diffInHours($assignment->deadline) == 0)
                                        {{\Carbon\Carbon::now()->diffInSeconds($assignment->deadline) - (\Carbon\Carbon::now()->diffInMinutes($assignment->deadline) * 60)}} detik
                                    @endif
                                    lagi
                                @elseif (time() > strtotime($assignment->deadline))
                                    Sudah ditutup
                                @else
                                    Belum dibuka
                                @endif
                            </p>
                        </div>
                        <div class="flex-row submission-detail">
                            <h3 class="poppins">Terakhir Diubah</h3>
                            <p class="montserrat">
                                @if (count($submission) >= 1)
                                    @if ($submission->first()->updated_at != null)
                                        {{date('l, d F - H:i', strtotime($submission->first()->updated_at))}}
                                    @else
                                        Belum mengumpulkan
                                    @endif
                                @else
                                    Belum mengumpulkan
                                @endif
                            </p>
                        </div>
                    </div>
                    @if (time() > strtotime($assignment->release))
                        <div class="flex-row submission-button">
                            @if ((time() > strtotime($assignment->deadline) and count($submission) >= 1) or count($assignment->grade->where('nis', Auth::user()->username)) >= 1)
                                <button type="button" class="small-btn-submit submit-success" data-bs-toggle="modal" data-bs-target="#check">Cek Jawaban</button>
                            @elseif (time() < strtotime($assignment->deadline) and count($submission) < 1)
                                <button type="button" class="small-btn-submit submit-success" data-bs-toggle="modal" data-bs-target="#create">Tambahkan Jawaban</button>
                            @elseif ((time() < strtotime($assignment->deadline) and count($submission) >= 1) and count($assignment->grade->where('nis', Auth::user()->username)) < 1)
                                <button type="button" class="small-btn-submit submit-edit" data-bs-toggle="modal" data-bs-target="#edit">Edit Jawaban</button>
                                <button type="button" class="small-btn-submit submit-danger" data-bs-toggle="modal" data-bs-target="#delete">Hapus Jawaban</button>
                            @endif
                        </div>
                            @if ((time() > strtotime($assignment->deadline) and count($submission) >= 1) or count($assignment->grade->where('nis', Auth::user()->username)) >= 1)
                                {{-- Modal Check --}}
                                <div class="modal fade" id="check" tabindex="-1" aria-labelledby="checkLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="checkLabel">Hasil Pengerjaan {{$assignment->name}}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>
                                                    <b>Nilai : </b>
                                                    @if (count($assignment->grade->where('nis', Auth::user()->username)) >= 1)
                                                        {{$assignment->grade->where('nis', Auth::user()->username)->first()->mark}}
                                                    @elseif (count($submission) >= 1)
                                                        Belum dinilai
                                                    @else
                                                        Tidak dinilai
                                                    @endif
                                                </p>
                                                @if ($assignment->grade->where('nis', Auth::user()->username)->first()->description != null)
                                                    <p style="text-align: justify">
                                                        <b>Keterangan : </b>
                                                        {{$assignment->grade->where('nis', Auth::user()->username)->first()->description}}
                                                    </p>
                                                @endif
                                                @if ($submission->first()->file != null)
                                                    <p>
                                                        <b>File Upload:</b>
                                                        <a href="{{route('submissionDownload', $submission->first()->id)}}" style="text-align: justify">{{$submission->first()->file}}</a>
                                                    </p>
                                                @endif
                                                @if ($submission->first()->description != null)
                                                    <p style="text-align: justify"><b>Jawaban:</b> {{$submission->first()->description}}</p>
                                                @endif
                                                @if ($submission->first()->description == null and $submission->first()->file == null)
                                                    <p><b>Jawaban:</b> Tidak ada jawaban</p>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif (time() < strtotime($assignment->deadline) and count($submission) < 1)    
                                {{-- Modal Create --}}
                                <div class="modal fade" id="create" tabindex="-1" aria-labelledby="createLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form class="modal-content" action="{{route('submission', $assignment->id)}}" method="POST" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="createLabel">Kirim Pengerjaan {{$assignment->name}}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                @if ($assignment->type == 'Online Teks')
                                                    <div class="mb-3">
                                                        <label for="description" class="col-form-label">Deskripsi Jawaban:</label>
                                                        <textarea name="description" class="form-control" id="description" rows="8" placeholder="Isi deskripsi jawaban sesuai dengan soal yang diberikan dan diharapkan tetap menjaga kejujuran!">{{old('description') != null ? old('description') : ''}}</textarea>
                                                    </div>
                                                @elseif ($assignment->type == 'Upload File')
                                                    <div class="mb-3">
                                                        <label for="file" class="col-form-label">Upload file:</label>
                                                        <input class="form-control" name="file" type="file" id="file">
                                                    </div>
                                                @else
                                                    <div class="mb-3">
                                                        <label for="file" class="col-form-label">Upload file:</label>
                                                        <input class="form-control" name="file" type="file" id="file">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="description" class="col-form-label">Deskripsi Jawaban:</label>
                                                        <textarea name="description" class="form-control" id="description" rows="8" placeholder="Isi deskripsi jawaban sesuai dengan soal yang diberikan dan diharapkan tetap menjaga kejujuran!">{{old('description') != null ? old('description') : ''}}</textarea>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" value="submit" class="btn btn-primary" style="background-color: #52B788; border-color: #52B788;font-weight: 400;color: #FBFEFD;">Kirim</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @elseif ((time() < strtotime($assignment->deadline) and count($submission) >= 1) and count($assignment->grade->where('nis', Auth::user()->username)) < 1)
                                {{-- Modal Edit --}}
                                <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="editLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <form class="modal-content" action="{{route('submissionEdit', $assignment->id)}}" method="POST" enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editLabel">Hasil Pengerjaan {{$assignment->name}}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @csrf
                                                @method('patch')
                                                @if ($submission->first()->file != null)
                                                    <b>File Lama:</b>
                                                    <a href="{{route('submissionDownload', $submission->first()->id)}}" style="text-align: justify">{{$submission->first()->file}}</a>
                                                @endif
                                                @if ($assignment->type == 'Online Teks')
                                                    <div class="mb-3">
                                                        <label for="description" class="col-form-label">Deskripsi Jawaban:</label>
                                                        @if ($submission->first()->description == null)
                                                            <textarea name="description" class="form-control" id="description" rows="8" placeholder="Isi deskripsi jawaban sesuai dengan soal yang diberikan dan diharapkan tetap menjaga kejujuran!">{{old('description') != null ? old('description') : ''}}</textarea>
                                                        @else
                                                            <textarea name="description" class="form-control" id="description" rows="8" placeholder="Isi deskripsi jawaban sesuai dengan soal yang diberikan dan diharapkan tetap menjaga kejujuran!">{{old('description') != null ? old('description') : $submission->first()->description}}</textarea>
                                                        @endif
                                                    </div>
                                                @elseif ($assignment->type == 'Upload File')
                                                <div class="mb-3">
                                                    <label for="file" class="col-form-label">Upload file:</label>
                                                    <input class="form-control" name="file" type="file" id="file">
                                                </div>
                                                @else
                                                    <div class="mb-3">
                                                        <label for="file" class="col-form-label">Upload file:</label>
                                                        <input class="form-control" name="file" type="file" id="file">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="description" class="col-form-label">Deskripsi Jawaban:</label>
                                                        @if ($submission->first()->description == null)
                                                            <textarea name="description" class="form-control" id="description" rows="8" placeholder="Isi deskripsi jawaban sesuai dengan soal yang diberikan dan diharapkan tetap menjaga kejujuran!">{{old('description') != null ? old('description') : ''}}</textarea>
                                                        @else
                                                            <textarea name="description" class="form-control" id="description" rows="8" placeholder="Isi deskripsi jawaban sesuai dengan soal yang diberikan dan diharapkan tetap menjaga kejujuran!">{{old('description') != null ? old('description') : $submission->first()->description}}</textarea>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                <button type="submit" class="btn btn-warning">Edit</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{-- Modal Delete --}}
                                <div class="modal fade" id="delete" data-bs-backdrop="static" tabindex="-1" aria-labelledby="deleteLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteLabel">Hapus Pengerjaan {{$assignment->name}} ?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    @if ($assignment->type == 'Online Teks' or $assignment->type == 'Keduanya')
                                                        <b>Jawaban:</b>
                                                        @if ($submission->first()->description != null)
                                                            <p style="text-align: justify">{{$submission->first()->description}}</p>
                                                        @else
                                                            <p>Tidak ada deskripsi jawaban.</p>
                                                        @endif
                                                    @endif
                                                    @if ($assignment->type == 'Upload File' or $assignment->type == 'Keduanya')
                                                        <p><b>File Upload:</b>
                                                        @if ($submission->first()->file != null)
                                                        <a href="{{route('submissionDownload', $submission->first()->id)}}" style="text-align: justify">{{$submission->first()->file}}</a>
                                                        @else
                                                            Tidak file upload jawaban.
                                                        @endif
                                                        </p>
                                                    @endif
                                                    <b>Catatan:</b>
                                                    <p style="text-align: justify">Berhati-hati sebelum menghapus jawaban pada sistem! Serta jangan lupa untuk mengirim jawabanmu yang baru apabila menghapus jawaban.</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{route('submissionDelete', $assignment->id)}}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                    @endif
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