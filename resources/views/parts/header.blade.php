<nav class="navbar navbar-expand-lg">
    <div class="container">

        <a href="{{ route('calendar') }}" class="navbar-brand mx-auto mx-lg-0">
            <i class="bi-bullseye brand-logo"></i>
            <span class="brand-text">WorkMaster <br> Planner</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ route('calendar') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        {{ __('header.calendar') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        {{ __('header.dashboard') }}
                    </a>
                </li>

                @can('admin-only')
                <li class="nav-item">
                    <a href="{{ route('people_management') }}" class="nav-link {{ request()->is('people_management') ? 'active' : '' }}">
                        {{ __('header.people_management') }}
                    </a>
                </li>
                @endcan

                <li class="nav-item">
                    <a href="{{ route('profile') }}" class="nav-link {{ request()->is('profile') ? 'active' : '' }}">
                        {{ __('header.profile') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        {{ __('header.logout') }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
