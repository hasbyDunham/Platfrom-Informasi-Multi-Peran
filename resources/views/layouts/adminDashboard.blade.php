<!doctype html>
<html lang="en" data-bs-theme="bodered-theme">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | Dashboard</title>
    <!--favicon-->
    <link rel="icon" href="{{asset('assets/back/images/favicon-32x32.png')}}" type="image/png">
    <!-- loader-->
    <link href="{{asset('assets/back/css/pace.min.css')}}" rel="stylesheet">
    <script src="{{asset('assets/back/js/pace.min.js')}}"></script>

    <!--plugins-->
    <link href="{{asset('assets/back/plugins/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/back/plugins/metismenu/metisMenu.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/back/plugins/metismenu/mm-vertical.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/back/plugins/simplebar/css/simplebar.css')}}">
    <!--bootstrap css-->
    <link href="{{asset('assets/back/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <!--main css-->
    <link href="{{asset('assets/back/css/bootstrap-extended.css')}}" rel="stylesheet">
    <link href="{{asset('assets/back/sass/main.css')}}" rel="stylesheet">
    <link href="{{asset('assets/back/sass/dark-theme.css')}}" rel="stylesheet">
    <link href="{{asset('assets/back/sass/blue-theme.css')}}" rel="stylesheet">
    <link href="{{asset('assets/back/sass/semi-dark.css')}}" rel="stylesheet">
    <link href="{{asset('assets/back/sass/bordered-theme.css')}}" rel="stylesheet">
    <link href="{{asset('assets/back/sass/responsive.css')}}" rel="stylesheet">
    <!--cdnicont-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    @yield('styles')

</head>

<body>

    {{-- start header --}}
    @include('layouts.admin.head')
    {{-- end header --}}


    {{-- end header --}}
    @include('layouts.admin.side')
    {{-- end header --}}


    <!--start main wrapper-->
    <main class="main-wrapper">
        <div class="main-content">
            @yield('content')
            <!--breadcrumb-->
            <!--end breadcrumb-->
        </div>
    </main>
    <!--end main wrapper-->

    <!--start overlay-->
    <div class="overlay btn-toggle"></div>
    <!--end overlay-->

    <!--start footer-->
    <footer class="page-footer">
        <p class="mb-0">Copyright © 2024. All right reserved.</p>
    </footer>
    <!--end footer-->

    <!--start cart-->

    <!--end cart-->



    <!--start switcher-->
    <button class="btn btn-grd btn-grd-primary position-fixed bottom-0 end-0 m-3 d-flex align-items-center gap-2"
        type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop">
        <i class="material-icons-outlined">tune</i>Customize
    </button>

    <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="staticBackdrop">
        <div class="offcanvas-header border-bottom h-70">
            <div class="">
                <h5 class="mb-0">Theme Customizer</h5>
                <p class="mb-0">Customize your theme</p>
            </div>
            <a href="javascript:;" class="primaery-menu-close" data-bs-dismiss="offcanvas">
                <i class="material-icons-outlined">close</i>
            </a>
        </div>
        <div class="offcanvas-body">
            <div>
                <p>Theme variation</p>

                <div class="row g-3">
                    <div class="col-12 col-xl-6">
                        <input type="radio" class="btn-check" name="theme-options" id="BlueTheme" checked>
                        <label
                            class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
                            for="BlueTheme">
                            <span class="material-icons-outlined">contactless</span>
                            <span>Blue</span>
                        </label>
                    </div>
                    <div class="col-12 col-xl-6">
                        <input type="radio" class="btn-check" name="theme-options" id="LightTheme">
                        <label
                            class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
                            for="LightTheme">
                            <span class="material-icons-outlined">light_mode</span>
                            <span>Light</span>
                        </label>
                    </div>
                    <div class="col-12 col-xl-6">
                        <input type="radio" class="btn-check" name="theme-options" id="DarkTheme">
                        <label
                            class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
                            for="DarkTheme">
                            <span class="material-icons-outlined">dark_mode</span>
                            <span>Dark</span>
                        </label>
                    </div>
                    <div class="col-12 col-xl-6">
                        <input type="radio" class="btn-check" name="theme-options" id="SemiDarkTheme">
                        <label
                            class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
                            for="SemiDarkTheme">
                            <span class="material-icons-outlined">contrast</span>
                            <span>Semi Dark</span>
                        </label>
                    </div>
                    <div class="col-12 col-xl-6">
                        <input type="radio" class="btn-check" name="theme-options" id="BoderedTheme">
                        <label
                            class="btn btn-outline-secondary d-flex flex-column gap-1 align-items-center justify-content-center p-4"
                            for="BoderedTheme">
                            <span class="material-icons-outlined">border_style</span>
                            <span>Bordered</span>
                        </label>
                    </div>
                </div><!--end row-->

            </div>
        </div>
    </div>
    <!--start switcher-->

    <!--bootstrap js-->
    <script src="{{asset('assets/back/js/bootstrap.bundle.min.js')}}"></script>

    <!--plugins-->
    <script src="{{asset('assets/back/js/jquery.min.js')}}"></script>
    <!--plugins-->
    <script src="{{asset('assets/back/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('assets/back/plugins/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{asset('assets/back/plugins/apexchart/apexcharts.min.js')}}"></script>
    <script src="{{asset('assets/back/plugins/simplebar/js/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/back/plugins/peity/jquery.peity.min.js')}}"></script>
    <script>
        $(".data-attributes span").peity("donut")
    </script>
    <script src="{{asset('assets/back/js/main.js')}}"></script>
    <script src="{{asset('assets/back/js/dashboard1.js')}}"></script>
    <script>
        new PerfectScrollbar(".user-list")
    </script>
    {{-- @stack('scripts') --}}
    {{-- @include('sweetalert::alert') --}}
</body>

</html>
