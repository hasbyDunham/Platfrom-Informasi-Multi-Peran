<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

        <a href="index.html" class="logo d-flex align-items-center me-auto me-xl-0">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="{{ asset('assets/front/img/logo.png') }}" alt=""> -->
            <h1 class="sitename">WartaBalarea</h1>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ url('/') }}" class="active">Home</a></li>
                <li><a href="about.html">About</a></li>
                {{-- <li><a href="single-post.html">Single Post</a></li> --}}
                <li class="dropdown"><a href="#"><span>Categories</span> <i
                            class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="category.html">Category 1</a></li>
                        <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i
                                    class="bi bi-chevron-down toggle-dropdown"></i></a>
                            <ul>
                                <li><a href="#">Deep Dropdown 1</a></li>
                                <li><a href="#">Deep Dropdown 2</a></li>
                                <li><a href="#">Deep Dropdown 3</a></li>
                                <li><a href="#">Deep Dropdown 4</a></li>
                                <li><a href="#">Deep Dropdown 5</a></li>
                            </ul>
                        </li>
                        <li><a href="category.html">Category 2</a></li>
                        <li><a href="category.html">Category 3</a></li>
                        <li><a href="category.html">Category 4</a></li>
                    </ul>
                </li>
                <li><a href="contact.html">Contact</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        {{-- <div class="header-social-links">
        <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
      </div> --}}

      <div class="user-menu">
        @if (Auth::check())
            <div class="dropdown">
                <a href="#" class="user-icon" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                </a>
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                    {{-- Tautan Dashboard Admin --}}
                    @if (auth()->user()->hasRole('Admin'))
                        <li><a class="dropdown-item" href="{{ route('admin.index') }}">Dashboard Admin</a></li>
                    @endif

                    {{-- Tautan Dashboard Writer --}}
                    @if (auth()->user()->hasRole('Writer'))
                        <li><a class="dropdown-item" href="{{ route('writer.index') }}">Dashboard Writer</a></li>
                    @endif

                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        @else
            <a href="{{ route('login') }}" class="login-button"><i class="bi bi-person-circle"></i> Login</a>
        @endif
    </div>


    </div>
</header>
