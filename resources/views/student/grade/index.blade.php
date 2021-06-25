@extends('template.system')

@section('title', 'Daftar Nilai ' . Auth::user()->student->name  . ' - Kelas ' . Auth::user()->student->room->name . ' E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/dashboard.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <style>
        .title-teacher h2 {
            /* text style */
            font-size: 28px;
            font-weight: 600;
            color: #212121;
        }

        .title-teacher {
            /* size */
            width: 100%;
            max-width: 325px;
            /* layout */
            align-items: flex-start;
            justify-content: normal;
            gap: 5px;
        }

        .content-teacher {
            /* size */
            width: 100%;
            /* layout */
            justify-content: normal;
            box-sizing: border-box;
            padding-bottom: 15px;
            gap: 10px;
            /* style */
            border-radius: 5px;
            border: 1px solid #DDDDDD;
        }

        .content-teacher h3, .content-teacher p {
            /* size */
            margin: 0;
            /* text style */
            font-style: normal;
            text-align: center;
            font-size: 20px;
            color: #212121;
        }

        .content-teacher h3 {
            /* text style */
            font-weight: 600;
        }

        .content-teacher p {
            /* text style */
            font-weight: 400;
        }

        .content-teacher img {
            /* size */
            width: 100%;
            height: 425px;
            /* style */
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
            object-fit: cover;
        }
        .accordion-body a {
            /* text style */
            text-decoration: none;
        }

        .accordion-body a:hover {
            /* text style */
            text-decoration: underline;
        }
    </style>
@endsection

@section('nilai', 'nav-active')

@section('container')
    <div class="flex-column" id="container-dashboard">
        <div class="flex-row container-title">
            <h1 class="poppins">Daftar Nilai</h1>
        </div>
        @if (!$hasRoom)
            <div class="notif-warning flex-row montserrat">
                <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                <span>Akun anda ({{Auth::user()->student->name}}) tidak terdaftar pada kelas manapun silahkan hubungin admin untuk mendaftarkan anda pada suatu kelas.</span>
            </div>
        @else
            <div class="container-content flex-row">
                <div class="container-mapel flex-column" style="padding: 0; border-color: #ffffff">
                    @if (count(Auth::user()->student->room->assignment) < 1)
                        <div class="notif-warning flex-row montserrat">
                            <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                            <span>Belum ada tugas yang diberikan oleh guru {{Auth::user()->student->room->employee->name}}, silahkan menghubungi guru tersebut untuk membuatkan tugas apabila diperlukan.</span>
                        </div>
                    @elseif (count(Auth::user()->student->grade) < 1)
                        <div class="notif-warning flex-row montserrat">
                            <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                            <span>Masih belum ada tugas yang dinilai oleh guru {{Auth::user()->student->room->employee->name}}, silahkan menghubungi guru tersebut untuk membuatkan tugas apabila diperlukan.</span>
                        </div>
                    @else
                        <div class="accordion" id="listGrade" style="width: 100%!important;">
                            @foreach ($mark as $data)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{$data->assignment->id}}">
                                        <button class="accordion-button {{$loop->index != 0 ? 'collapsed' : ''}}" type="button" data-bs-toggle="collapse" data-bs-target="#grade{{$data->assignment->id}}" aria-expanded="{{$loop->index == 0 ? 'true' : 'false'}}" aria-controls="grade{{$data->assignment->id}}">
                                            {{date('l, d F H:i', strtotime($data->updated_at))}} - {{$data->assignment->name}}
                                        </button>
                                    </h2>
                                    <div id="grade{{$data->assignment->id}}" class="accordion-collapse collapse {{$loop->index == 0 ? 'show' : ''}}" aria-labelledby="heading{{$data->assignment->id}}" data-bs-parent="#listGrade">
                                        <div class="accordion-body">
                                            <p><b>Nilai : </b>{{$data->mark}}</p>
                                            <b>Keterangan :</b>
                                            <p style="text-align: justify">
                                                @if ($data->description != null)
                                                    {{$data->description}}
                                                @else
                                                    Tidak ada keterangan
                                                @endif
                                            </p>
                                            <b>Jawaban :</b>
                                            @if (Auth::user()->student->submission->where('assignment_id', $data->assignment->id)->first()->description != null)
                                                <p style="text-align: justify">{{Auth::user()->student->submission->where('assignment_id', $data->assignment->id)->first()->description}}</p>
                                            @endif
                                            @if (Auth::user()->student->submission->where('assignment_id', $data->assignment->id)->first()->file != null)
                                                <p>
                                                    <b>File Upload:</b>
                                                    <a href="{{route('submissionDownload', Auth::user()->student->submission->where('assignment_id', $data->assignment->id)->first()->id)}}" style="text-align: justify">{{Auth::user()->student->submission->where('assignment_id', $data->assignment->id)->first()->file}}</a>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                <div class="flex-column title-teacher">
                    <h2 class="poppins" style="width: 100%; text-align:center;">👑<br>Ranking 1</h2>
                    <div class="flex-column content-teacher">
                        @if ($hasRank)
                            <img src="{{asset('img/photo/'. ($ranker->photo == null ? 'default-student.jpg' : $ranker->photo))}}" alt="foto {{$ranker->name}}">
                            <h3 class="montserrat">{{Str::limit($ranker->name, 22, $end='...')}}</h3>
                            @if ($rankMark > 75)
                                <span class="badge bg-success poppins" style="font-size: 18px; font-weight: 500;">{{$rankMark}}</span>  
                            @elseif ($rankMark > 50)
                                <span class="badge bg-warning poppins" style="font-size: 18px; font-weight: 500;">{{$rankMark}}</span>
                            @else
                                <span class="badge bg-danger poppins" style="font-size: 18px; font-weight: 500;">{{$rankMark}}</span>
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
        @endif
    </div>
@endsection