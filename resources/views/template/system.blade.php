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
<body class="flex-row" id="align-item-start">
    <header class="flex-column vh100 header-clicked" id="header-side">
        <div class="flex-row nav-head js-item animate-normal" id="j-center">
            <img class="animate-normal" src="{{asset('img/icon/navbar-logo.svg')}}" alt="logo" style="display: none;">
            <button onclick="navbarActive()" type="button" class="flex-row rotate animate-normal"><img src="{{asset('img/icon/navbar-arrow-right.svg')}}"></button>
        </div>
        <nav class="flex-column nav-list js-item">
            <a href="{{Auth::check() ? route('dashboard') : route('login')}}" class="flex-row poppins @yield('dashboard')" id="j-center">
                <img src="{{asset('img/icon/navbar-dashboard.svg')}}">
                <span class="animate" style="display: none;">{{Auth::check() ? 'Dashboard' : 'Login'}}</span>
            </a>
            @if (Auth::check())
                <svg height="2" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 1H1000" stroke="#FBFEFD" stroke-opacity="0.5"/>
                </svg>
                <a href="{{route('roomIndex')}}" class="flex-row poppins @yield('kelas')" id="j-center">
                    <img src="{{asset('img/icon/navbar-kelas.svg')}}">
                    <span class="animate" style="display: none;">Kelas</span>
                </a>
                @if (Auth::user()->status != 'admin')
                    <a href="{{route('taskIndex')}}" class="flex-row poppins @yield('tugas')" id="j-center">
                        <img src="{{asset('img/icon/navbar-tugas.svg')}}">
                        <span class="animate" style="display: none;">Tugas</span>
                    </a>
                    @if (Auth::user()->status == 'student')
                        <a href="{{route('grade')}}" class="flex-row poppins @yield('nilai')" id="j-center">
                            <img src="{{asset('img/icon/navbar-nilai.svg')}}">
                            <span class="animate" style="display: none;">Nilai</span>
                        </a>
                    @endif
                @endif
                <svg height="2" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 1H1000" stroke="#FBFEFD" stroke-opacity="0.5"/>
                </svg>
                <a href="{{route('setting')}}" class="flex-row poppins @yield('settings')" id="j-center">
                    <img src="{{asset('img/icon/navbar-pengaturan.svg')}}">
                    <span class="animate" style="display: none;">Pengaturan</span>
                </a>
            @endif
            <a href="{{route('helpdesk')}}" class="flex-row poppins @yield('helpdesk')" id="j-center">
                <img src="{{asset('img/icon/navbar-helpdesk.svg')}}">
                <span class="animate" style="display: none;">Helpdesk</span>
            </a>
            @if (Auth::check())
                <svg height="2" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 1H1000" stroke="#FBFEFD" stroke-opacity="0.5"/>
                </svg>
                <a href="{{route('logout')}}" class="flex-row poppins" id="j-center">
                    <img src="{{asset('img/icon/navbar-logout-2.svg')}}">
                    <span class="animate" style="display: none;">Keluar</span>
                </a>
            @endif
        </nav>
        <div class="flex-row nav-profile js-item" id="j-center">
            @if (Auth::check())
                @if (Auth::user()->status == 'employee')
                    <img {{str_replace('$',"'", 'onclick=location.href=$' . route('setting') . '$')}} src="{{Auth::user()->employee->photo != null ? asset('img/photo/' . Auth::user()->employee->photo) : asset('img/photo/pp1.jpg') }}" alt="profile {{Auth::user()->employee->name}}"> 
                @elseif (Auth::user()->status == 'student')
                    <img {{str_replace('$',"'", 'onclick=location.href=$' . route('setting') . '$')}} src="{{Auth::user()->student->photo != null ? asset('img/photo/' . Auth::user()->student->photo) : asset('img/photo/pp1.jpg') }}" alt="profile {{Auth::user()->student->name}}"> 
                @else
                    <img src="{{asset('img/photo/pp1.jpg')}}" alt="profile admin {{Auth::user()->username}}"> 
                @endif
            @else
                <img src="{{asset('img/photo/pp1.jpg')}}" alt="profile user"> 
            @endif
            <div class="flex-column nav-profile-detail" style="display: none;">
                @if (isset(Auth::user()->student->name))
                    <h5 class="poppins">{{Auth::user()->student->name}}</h5>
                @elseif (isset(Auth::user()->employee->name))
                    <h5 class="poppins">{{Auth::user()->employee->name}}</h5>
                @elseif (isset(Auth::user()->status) and Auth::user()->status == 'admin')
                    <h5 class="poppins">Admin {{Auth::user()->id}}</h5>
                @else
                    <h5 class="poppins">{{"Silahkan Login"}}</h5>
                @endif
                <h6 class="poppins">{{isset(Auth::user()->username) ? Auth::user()->username : '' }}</h6>
            </div>
        </div>
    </header>
    @yield('container')
    @yield('scriptBody')
    <script src="{{asset('js/navbar.js')}}"></script>
</body>
</html>