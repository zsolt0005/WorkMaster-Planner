<nav class="navbar navbar-expand-lg">
    <div class="container">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <a href="{{ route('index') }}" class="navbar-brand mx-auto mx-lg-0">
            <i class="bi-bullseye brand-logo"></i>
            <span class="brand-text">WorkMaster <br> Planner</span>
        </a>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="{{ route('index') }}"
                       class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                        Calendar
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('people_management') }}"
                       class="nav-link {{ request()->is('people_management') ? 'active' : '' }}">
                        People Management
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('profile') }}"
                       class="nav-link {{ request()->is('profile') ? 'active' : '' }}">
                        Profile
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
