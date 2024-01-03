<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
                aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand">
            <a href="{{ route('homepage') }}">
                <img src="{{ 'https://placehold.co/550x160/182433/FFFFFF?text=' . config('app.name') }}"
                     width="110" height="32" alt="{{ config('app.name') }}" class="navbar-brand-image">
            </a>
        </h1>
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                   aria-label="Open user menu">
                            <span class="avatar avatar-sm"
                                  style="background-image: url('{{ auth()->user()->profile_picture_url }}')"></span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ auth()->user()->name }}</div>
                        <div class="mt-1 small text-secondary">{{ auth()->user()->field ?? '-' }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <a href="{{ route('auth.logout') }}" class="dropdown-item"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('homepage') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M5 12l-2 0l9 -9l9 9l-2 0"></path>
                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7"></path>
                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6"></path>
                            </svg>
                        </span>
                        <span class="nav-link-title">Home</span>
                    </a>
                </li>
                @if(auth()->user()->role == \App\Enums\UserRole::STUDENT)
                    <li class="nav-item">
                        <a class="nav-link @if(request()->routeIs('course.enrolled')) active @endif"
                           href="{{ route('course.enrolled') }}">
                            <span class="nav-link-icon d-md-none d-lg-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                         stroke-linecap="round" stroke-linejoin="round"><path stroke="none"
                                                                                              d="M0 0h24v24H0z"
                                                                                              fill="none"/><path
                                            d="M22 9l-10 -4l-10 4l10 4l10 -4v6"/><path
                                            d="M6 10.6v5.4a6 3 0 0 0 12 0v-5.4"/></svg>
                            </span>
                            <span class="nav-link-title">My Course</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link @if(request()->routeIs('course.catalogue')) active @endif"
                       href="{{ route('course.catalogue') }}">
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search"
                                 width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                 stroke="currentColor" fill="none" stroke-linecap="round"
                                 stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path
                                    d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"/><path
                                    d="M21 21l-6 -6"/></svg>
                        </span>
                        <span class="nav-link-title">Browse Course</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-red" href="{{ route('auth.logout') }}"
                       onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-red" width="24" height="24"
                                         viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                         stroke-linecap="round" stroke-linejoin="round"><path stroke="none"
                                                                                              d="M0 0h24v24H0z"
                                                                                              fill="none"/><path
                                            d="M10 8v-2a2 2 0 0 1 2 -2h7a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2"/><path
                                            d="M15 12h-12l3 -3"/><path d="M6 15l-3 -3"/></svg>
                                </span>
                        <span class="nav-link-title">
                                    Logout
                                </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</aside>
