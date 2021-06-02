<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di E-Learning Cakrawala</title>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- css files -->
    <link rel="stylesheet" href="{{asset('css/system.css')}}">
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    <link rel="stylesheet" href="{{asset('css/form.css')}}">
</head>
<body class="flex-row">
    <header class="flex-column vh100 header-clicked" id="header-side">
        <div class="flex-row nav-head js-item animate-normal" id="j-center">
            <img class="animate-normal" src="{{asset('img/icon/navbar-logo.svg')}}" alt="logo" style="display: none;">
            <button onclick="navbarActive()" type="button" class="flex-row rotate animate-normal"><img src="{{asset('img/icon/navbar-arrow-right.svg')}}"></button>
        </div>
        <nav class="flex-column nav-list js-item">
            <a href="dashboard.html" class="flex-row poppins" id="j-center">
                <img src="{{asset('img/icon/navbar-dashboard.svg')}}">
                <span class="animate" style="display: none;">Dashboard</span>
            </a>
            <a href="kelas.html" class="flex-row poppins" id="j-center">
                <img src="{{asset('img/icon/navbar-kelas.svg')}}">
                <span class="animate" style="display: none;">Kelas</span>
            </a>
            <a href="jadwal.html" class="flex-row poppins" id="j-center">
                <img src="{{asset('img/icon/navbar-jadwal.svg')}}">
                <span class="animate" style="display: none;">Jadwal</span>
            </a>
            <svg height="2" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 1H1000" stroke="#FBFEFD" stroke-opacity="0.5"/>
            </svg>
            <a href="tugas.html" class="flex-row poppins" id="j-center">
                <img src="{{asset('img/icon/navbar-tugas.svg')}}">
                <span class="animate" style="display: none;">Tugas</span>
            </a>
            <a href="absensi.html" class="flex-row poppins" id="j-center">
                <img src="{{asset('img/icon/navbar-absensi.svg')}}">
                <span class="animate" style="display: none;">Absensi</span>
            </a>
            <a href="nilai.html" class="flex-row poppins" id="j-center">
                <img src="{{asset('img/icon/navbar-nilai.svg')}}">
                <span class="animate" style="display: none;">Nilai</span>
            </a>
            <a href="spp.html" class="flex-row poppins" id="j-center">
                <img src="{{asset('img/icon/navbar-spp.svg')}}">
                <span class="animate" style="display: none;">SPP</span>
            </a>
            <svg height="2" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 1H1000" stroke="#FBFEFD" stroke-opacity="0.5"/>
            </svg>
            <a href="pengaturan.html" class="flex-row poppins" id="j-center">
                <img src="{{asset('img/icon/navbar-pengaturan.svg')}}">
                <span class="animate" style="display: none;">Pengaturan</span>
            </a>
            <a href="helpdesk.html" class="flex-row poppins" id="j-center">
                <img src="{{asset('img/icon/navbar-helpdesk.svg')}}">
                <span class="animate" style="display: none;">Helpdesk</span>
            </a>
        </nav>
        <div class="flex-row nav-profile js-item" id="j-center">
            <img onclick="location.href='#'" src="{{asset('img/photo/pp1.jpg')}}">
            <div class="flex-column nav-profile-detail" style="display: none;">
                <h5 class="poppins">Muhammad Rizal Bagus Prakasa</h5>
                <h6 class="poppins">081911633071</h6>
            </div>
        </div>
    </header>
    <div class="flex-column container vh100" id="container">
        <div class="flex-column container-title">
            <h1 class="montserrat">e-Learning</h1>
            <h2 class="montserrat">SMAN 15 Cakrawala</h2>
        </div>
        <div class="flex-row container-row">
            <form action="" method="POST" class="flex-column container-form">
                @csrf
                <div class="flex-column form-title">
                    <h3 class="poppins">Login</h3>
                    <p class="montserrat">Selamat datang di web e-learning SMAN 15 Cakrawala. E-Learning adalah konsep pendidikan yang memanfaatkan Teknologi Informasi dan Komunikasi dalam proses belajar mengajar.</p>
                </div>
                {{-- <div class="notif-warning flex-row montserrat">
                    <img src="{{asset('img/icon/notif-warning.svg')}}" alt="warning image">
                    <span></span>
                </div> --}}
                <div class="flex-column form-input">
                    <div class="formel" id="input-id">
                        <input required type="number" name="id" id="id" placeholder="NIP/NIS">
                    </div>
                    <div class="formel" id="input-pass">
                        <input required type="password" name="password" id="password" placeholder="Password">
                    </div>
                    <div class="formel flex-row">
                        <div class="remember flex-row">
                            <input type="checkbox" name="remember" id="remember">
                            <label for="remember" class="montserrat link">Ingat saya</label>
                        </div>
                        <a href="#" class="montserrat link"> Lupa password?</a>
                    </div>
                </div>
                <div class="formel">
                    <button type="submit" class="poppins">Login</button>
                </div>
            </form>
            <div class="container-illust">
                <img src="{{asset('img/illust-index.svg')}}" alt="">
            </div>
        </div>
    </div>
    <script src="{{asset('js/navbar.js')}}"></script>
</body>
</html>