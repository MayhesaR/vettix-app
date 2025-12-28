@section('sidebar_menu')
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-house"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('events.create') }}" class="nav-link {{ request()->routeIs('events.create') ? 'active' : '' }}">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>Tambah Event</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('events.index') }}" class="nav-link {{ request()->routeIs('events.index') ? 'active' : '' }}">
                        <i class="fa-solid fa-building"></i>
                        <span>Semua Event</span>
                    </a>
                </li>

            </ul>
@endsection

