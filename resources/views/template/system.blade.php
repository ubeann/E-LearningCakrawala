<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- css files -->
    <link rel="stylesheet" href="{{asset('css/system.css')}}">
    <link rel="stylesheet" href="{{asset('css/navbar.css')}}">
    @yield('css')
    <!-- js files -->
    @yield('scriptHead')
</head>
<body class="flex-row">
    <header class="flex-column vh100 header-clicked" id="header-side">
        <div class="flex-row nav-head js-item animate-normal" id="j-center">
            <img class="animate-normal" src="{{asset('img/icon/navbar-logo.svg')}}" alt="logo" style="display: none;">
            <button onclick="navbarActive()" type="button" class="flex-row rotate animate-normal"><img src="{{asset('img/icon/navbar-arrow-right.svg')}}"></button>
        </div>
        <nav class="flex-column nav-list js-item">
            <a href="dashboard.html" class="flex-row poppins @yield('dashboard')" id="j-center">
                <img src="{{asset('img/icon/navbar-dashboard.svg')}}">
                <span class="animate" style="display: none;">Dashboard</span>
            </a>
            <a href="kelas" class="flex-row poppins @yield('kelas')" id="j-center">
                <img src="{{asset('img/icon/navbar-kelas.svg')}}">
                <span class="animate" style="display: none;">Kelas</span>
            </a>
            <a href="jadwal.html" class="flex-row poppins @yield('jadwal')" id="j-center">
                <img src="{{asset('img/icon/navbar-jadwal.svg')}}">
                <span class="animate" style="display: none;">Jadwal</span>
            </a>
            <svg height="2" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 1H1000" stroke="#FBFEFD" stroke-opacity="0.5"/>
            </svg>
            <a href="tugas" class="flex-row poppins @yield('tugas')" id="j-center">
                <img src="{{asset('img/icon/navbar-tugas.svg')}}">
                <span class="animate" style="display: none;">Tugas</span>
            </a>
            <a href="absensi.html" class="flex-row poppins @yield('absensi')" id="j-center">
                <img src="{{asset('img/icon/navbar-absensi.svg')}}">
                <span class="animate" style="display: none;">Absensi</span>
            </a>
            <a href="nilai" class="flex-row poppins @yield('nilai')" id="j-center">
                <img src="{{asset('img/icon/navbar-nilai.svg')}}">
                <span class="animate" style="display: none;">Nilai</span>
            </a>
            <a href="spp.html" class="flex-row poppins @yield('spp')" id="j-center">
                <img src="{{asset('img/icon/navbar-spp.svg')}}">
                <span class="animate" style="display: none;">SPP</span>
            </a>
            <svg height="2" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 1H1000" stroke="#FBFEFD" stroke-opacity="0.5"/>
            </svg>
            <a href="settings" class="flex-row poppins @yield('settings')" id="j-center">
                <img src="{{asset('img/icon/navbar-pengaturan.svg')}}">
                <span class="animate" style="display: none;">Pengaturan</span>
            </a>
            <a href="helpdesk.html" class="flex-row poppins @yield('helpdesk')" id="j-center">
                <img src="{{asset('img/icon/navbar-helpdesk.svg')}}">
                <span class="animate" style="display: none;">Helpdesk</span>
            </a>
        </nav>
        <div class="flex-row nav-profile js-item" id="j-center">
            <img onclick="location.href='#'" src="{{isset($user->photo) ? asset('img/photo/'.$user->photo) : asset('img/photo/pp1.jpg') }}" alt="photo profile">
            <div class="flex-column nav-profile-detail" style="display: none;">
                <h5 class="poppins">{{isset($user->name) ? $user->name : "Silahkan Login" }}</h5>
                <h6 class="poppins">{{isset($user->id) ? $user->id : '' }}</h6>
            </div>
        </div>
    </header>
    @yield('container')
    @yield('scriptBody')
    <script src="{{asset('js/navbar.js')}}"></script>
</body>
</html>