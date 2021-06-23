@extends('template.system')

@section('title', 'Helpdesk E-Learning Cakrawala')

@section('css')
    <link rel="stylesheet" href="{{asset('css/helpdesk.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
@endsection

@section('helpdesk', 'nav-active')

@section('container')
    <div class="flex-column" id="container-helpdesk">
        <div class="flex-row container-title">
            <h1 class="poppins">Helpdesk</h1>
        </div>
        <div class="flex-row container-group">
            <div id="img-slider" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#img-slider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#img-slider" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#img-slider" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="{{asset('img/helpdesk-1.jpg')}}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                      <h5>Presentasi</h5>
                      <p>Presentasi menyampaikan informasi dari pembicara kepada audiens.</p>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img src="{{asset('img/helpdesk-2.jpg')}}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                      <h5>Belajar</h5>
                      <p>Belajar adalah perubahan yang relatif permanen dalam perilaku atau potensi perilaku <br> sebagai hasil dari pengalaman atau latihan yang diperkuat. </p>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img src="{{asset('img/helpdesk-3.jpg')}}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                      <h5>Ilmu</h5>
                      <p>Ilmu, sains, atau ilmu pengetahuan adalah usaha-usaha sadar untuk menyelidiki, menemukan <br> dan meningkatkan pemahaman manusia dari berbagai segi kenyataan dalam alam manusia.</p>
                    </div>
                  </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#img-slider" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#img-slider" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="flex-column container-contact">
                <div class="contact-title">
                    <h2 class="poppins">Hubungi Kami</h2>
                </div>
                <div class="flex-row contact-item">
                    <img src="{{asset('img/icon/helpdesk-location.svg')}}" alt="address">
                    <span class="montserrat">Jl. Senopati VIIB, Jakarta - 60135 Indonesia</span>
                </div>
                <div class="flex-row contact-item">
                    <img src="{{asset('img/icon/helpdesk-call.svg')}}" alt="address">
                    <span class="montserrat">+62-8155-3507-248</span>
                </div>
                <div class="flex-row contact-item">
                    <img src="{{asset('img/icon/helpdesk-message.svg')}}" alt="address">
                    <span class="montserrat">admin@cakrawala.co.id</span>
                </div>
            </div>
        </div>
    </div>
@endsection