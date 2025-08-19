<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TravelCom') }}</title>

    <!-- Preconnect for faster external loads -->
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://unpkg.com" crossorigin>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/templatemo-woox-travel.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">

    <!-- Fonts (with swap to prevent CLS) -->
    <link href="https://fonts.bunny.net/css?family=Nunito&display=swap" rel="stylesheet">

    <!-- Vite (compiled CSS/JS) -->
    @vite(['resources/js/app.js'])
</head>
<body>
    <div id="app">

        <!-- ***** Header Area Start ***** -->
        <header class="header-area header-sticky">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav class="main-nav">
                            <h1>
                                <a href="{{ url('/') }}">
                                    <span class="logo" style="color:white;">TravelCom</span>
                                </a>
                            </h1>
                            <ul class="nav">
                                @guest
                                    @if (Route::has('login'))
                                        <li><a href="{{ route('login') }}">Login</a></li>
                                    @endif
                                    @if (Route::has('register'))
                                        <li><a href="{{ route('register') }}">Register</a></li>
                                    @endif
                                @else
                                    @auth
                                        @if (Auth::user()->role == 1)
                                            <li><a href="{{ route('admin.dashboard') }}">Hi, {{ Auth::user()->name }}!</a></li>
                                            <li><a href="{{ route('admin.notifications.index') }}">Notifications</a></li>
                                        @else
                                            <li><a href="{{ route('home') }}">Hi, {{ Auth::user()->name }}!</a></li>
                                            <li><a href="{{ route('friends.index') }}">Friends</a></li>
                                            <li><a href="{{ route('itineraries.index') }}">Itineraries</a></li>
                                            <li><a href="{{ route('group_trips.index') }}">Group Trips</a></li>
                                            <li><a href="{{ route('user.notifications') }}">Notifications</a></li>
                                        @endif
                                    @endauth
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </li>
                                @endguest
                            </ul>
                            <a class='menu-trigger'><span>Menu</span></a>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
        <!-- ***** Header Area End ***** -->

        <!-- Pico Navigation for Post-related Features -->
        <nav class="container mt-3">
            <ul>
                <li><strong>TravelCom</strong></li>
            </ul>
            <ul>
                <li><a href="{{ route('posts.index') }}">Posts</a></li>
                <li><a href="{{ route('activity.liked') }}">Liked</a></li>
                <li><a href="{{ route('activity.commented') }}">Commented</a></li>
                <li><a href="{{ route('recommendations.create') }}">Recommend</a></li>
                <li><a href="{{ route('recommendations.index') }}">Inbox</a></li>
            </ul>
        </nav>

        <main class="py-4 container">
            @if(session('success'))
                <article class="contrast">{{ session('success') }}</article>
            @endif
            @yield('content')
        </main>
    </div>

    <footer>
        <div class="container text-center mt-4">
            <p>
                Design: <a href="https://templatemo.com" target="_blank">TemplateMo</a> | 
                Distribution: <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
            </p>
        </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/isotope.min.js') }}" defer></script>
    <script src="{{ asset('assets/js/owl-carousel.js') }}" defer></script>
    <script src="{{ asset('assets/js/wow.js') }}" defer></script>
    <script src="{{ asset('assets/js/tabs.js') }}" defer></script>
    <script src="{{ asset('assets/js/popup.js') }}" defer></script>
    <script src="{{ asset('assets/js/custom.js') }}" defer></script>
</body>
</html>
