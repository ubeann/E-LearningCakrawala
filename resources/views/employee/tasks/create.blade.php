@extends('template.system')

@section('title', 'Buat Tugas Baru - E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
@endsection

@section('tugas', 'nav-active')

@section('container')
    <div class="flex-column container vh100" id="container">
        <div class="flex-row container-row">
            <form action="" method="POST" class="flex-column container-form">
                @csrf
                <div class="flex-column form-title">
                    <h3 class="poppins">Membuat Tugas Baru</h3>
                    <p class="montserrat">Isilah dengan teliti pada data-data di bawah ini!</p>
                </div>
                @if (session('warning'))
                <div class="notif-warning flex-row montserrat">
                    <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                    <span>{{ session('warning') }}</span>
                </div>
                @endif
                <div class="flex-column form-input">
                    <div class="formel" id="input-star">
                        <input required type="text" name="title" id="title" placeholder="Judul tugas">
                    </div>
                    <div class="formel flex-row">
                        <div class="formel" id="input-date">
                            <input required type="text" onfocus="(this.type='datetime-local')" name="startDate" id="startDate" placeholder="Tanggal dibuka">
                        </div>
                        <div class="formel" id="input-date">
                            <input required type="text" onfocus="(this.type='datetime-local')" name="endDate" id="endDate" placeholder="Tanggal ditutup">
                        </div>
                    </div>
                    <div class="formel" id="input-edit">
                        <textarea required name="description" id="description" placeholder="Deskripsi tugas" cols="30" rows="10"></textarea>
                    </div>
                    <!-- <div class="formel" id="input-plus-square">
                        <input type="text" onfocus="(this.type='file')" name="file" id="file" placeholder="Upload files" multiple>
                    </div> -->
                </div>
                <div class="formel small-btn-submit">
                    <button type="submit" class="poppins">Buat Tugas</button>
                </div>
            </form>
            <div class="container-illust">
                <img class="illust-center" src="{{asset('img/illust-tugas.svg')}}" alt="">
            </div>
        </div>
    </div>
@endsection