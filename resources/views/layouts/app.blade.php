<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vettix - @yield('title', 'Dashboard')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <div class="sidebar">
        <div class="sidebar-header">
            <div class="logo-box">
                <i class="fa-solid fa-code-branch"></i>
            </div>
            <span class="brand-name">Vettix</span>
        </div>

        <nav class="sidebar-menu">
            @section('sidebar_menu')
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('events.create') }}" class="nav-link {{ request()->routeIs('events.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>Organisasi & Event</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('venues.index') }}" class="nav-link {{ request()->routeIs('venues.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-building"></i>
                        <span>Venue</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('rankings.index') }}" class="nav-link {{ request()->routeIs('rankings.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-ranking-star"></i>
                        <span>Ranking</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('certificates.index') }}" class="nav-link {{ request()->routeIs('certificates.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-certificate"></i>
                        <span>Sertifikat</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('speakers.index') }}" class="nav-link {{ request()->routeIs('speakers.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-microphone"></i>
                        <span>Pembicara</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('reviews.index') }}" class="nav-link {{ request()->routeIs('reviews.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-star"></i>
                        <span>Review</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('participants.index') }}" class="nav-link {{ request()->routeIs('participants.*') ? 'active' : '' }}">
                        <i class="fa-solid fa-star"></i>
                        <span>Participants</span>
                    </a>
                </li>
            </ul>
            @show
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <img src="https://ui-avatars.com/api/?name=Admin+Kampus&background=9CA3AF&color=fff" alt="Profile" class="user-avatar">
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name ?? 'Guest' }}</span>
                    <span class="user-role">Administrator</span>
                </div>
                <button class="menu-dots">
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="main-content">
        <header class="topbar">
            <h2 class="page-title">@yield('title')</h2>
        </header>

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
