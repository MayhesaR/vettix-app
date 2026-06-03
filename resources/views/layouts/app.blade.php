<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vettix - @yield('title-text', 'Dashboard')</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Tailwind CSS (for extra utility padding/margins if needed) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: {
                preflight: false, // Prevent Tailwind from overriding Bootstrap basics
            }
        }
    </script>

    <!-- Custom Style Sheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <!-- Sidebar Backdrop Overlay -->
    <div class="sidebar-backdrop" id="sidebar-backdrop"></div>

    <!-- Sidebar Navigation -->
    <div class="sidebar" id="sidebar">
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
                    <a href="#submenu-organisasi" class="nav-link" role="button" aria-expanded="{{ request()->routeIs('events.*') ? 'true' : 'false' }}" aria-controls="submenu-organisasi" id="submenu-toggle-btn">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>Organisasi & Event</span>
                        <i class="fa-solid fa-chevron-down ms-auto dropdown-chevron text-xs"></i>
                    </a>
                    <div class="submenu-collapse {{ request()->routeIs('events.*') ? 'show' : '' }}" id="submenu-organisasi">
                        <ul class="submenu-list">
                            <li>
                                <a href="{{ route('events.create') }}" class="nav-link submenu-link {{ request()->routeIs('events.create') ? 'active' : '' }}">
                                    <i class="fa-solid fa-plus-circle"></i>
                                    <span>Tambah Event</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('events.index') }}" class="nav-link submenu-link {{ request()->routeIs('events.index') ? 'active' : '' }}">
                                    <i class="fa-solid fa-list"></i>
                                    <span>Semua Event</span>
                                </a>
                            </li>
                        </ul>
                    </div>
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
                        <i class="fa-solid fa-users"></i>
                        <span>Peserta</span>
                    </a>
                </li>
            </ul>
            @show
        </nav>

        <div class="sidebar-footer">
            <div class="user-profile">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Guest') }}&background=00c2cb&color=fff" alt="Profile" class="user-avatar">
                <div class="user-info">
                    <span class="user-name" title="{{ Auth::user()->name ?? 'Guest' }}">{{ Auth::user()->name ?? 'Guest' }}</span>
                    <span class="user-role">{{ ucfirst(Auth::user()->role ?? 'Guest') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Topbar Header -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="sidebar-toggle" id="sidebar-toggle-btn" aria-label="Toggle Sidebar">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h2 class="page-title">@yield('page-title', 'Vettix')</h2>
            </div>

            <div class="topbar-right">
                <!-- Profile dropdown menu -->
                <div class="profile-dropdown">
                    <button class="profile-trigger" id="profile-dropdown-btn" aria-label="User profile options">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Guest') }}&background=00c2cb&color=fff" alt="Avatar" class="profile-trigger-avatar">
                        <span class="profile-trigger-name">{{ Auth::user()->name ?? 'Guest' }}</span>
                        <i class="fa-solid fa-chevron-down text-xs text-slate-400"></i>
                    </button>

                    <div class="profile-menu" id="profile-menu">
                        <div class="profile-menu-header">
                            <div class="profile-menu-name">{{ Auth::user()->name ?? 'Guest' }}</div>
                            <div class="profile-menu-email">{{ Auth::user()->email ?? 'guest@example.com' }}</div>
                        </div>
                        <a href="{{ route('settings') }}" class="profile-menu-item">
                            <i class="fa-solid fa-gear"></i>
                            <span>Pengaturan Akun</span>
                        </a>
                        <hr class="my-1 border-slate-100">
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="profile-menu-item logout">
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- UI Interaction Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sidebar Controls
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebar-backdrop');
            const toggleBtn = document.getElementById('sidebar-toggle-btn');

            if (toggleBtn) {
                toggleBtn.addEventListener('click', function () {
                    sidebar.classList.toggle('show');
                });
            }

            if (backdrop) {
                backdrop.addEventListener('click', function () {
                    sidebar.classList.remove('show');
                });
            }

            // Profile Dropdown Controls
            const profileBtn = document.getElementById('profile-dropdown-btn');
            const profileMenu = document.getElementById('profile-menu');

            if (profileBtn && profileMenu) {
                profileBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    profileMenu.classList.toggle('show');
                });

                document.addEventListener('click', function (e) {
                    if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                        profileMenu.classList.remove('show');
                    }
                });
            }

            // Submenu Collapse Controls
            const submenuToggle = document.getElementById('submenu-toggle-btn');
            const submenuCollapse = document.getElementById('submenu-organisasi');

            if (submenuToggle && submenuCollapse) {
                submenuToggle.addEventListener('click', function (e) {
                    e.preventDefault();
                    submenuCollapse.classList.toggle('show');
                    const isExpanded = submenuCollapse.classList.contains('show');
                    submenuToggle.setAttribute('aria-expanded', isExpanded ? 'true' : 'false');
                });
            }
        });
    </script>
</body>
</html>
