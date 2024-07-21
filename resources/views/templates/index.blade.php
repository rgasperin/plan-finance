<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Plan Finance</title>

    <link href="{{ url('assets/img/favicon.png') }}" rel="icon" />
    <link href="{{ url('assets/img/favicon.png') }}" rel="apple-touch-icon" />


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('assets/dist/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/dist/uicons/css/uicons-regular-rounded.css') }}">
    <link rel="stylesheet" href="{{ url('assets/dist/uicons-solid/css/uicons-solid-straight.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="{{ url('assets/css/plugins.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/css/styles.css') }}">

</head>

<body>
    <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
            <div class="logo-header" data-background-color="dark">
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('assets/img/logo.png') }}" alt="Logo do Plan Finance" class="navbar-brand"
                        height="30" />
                </a>
            </div>
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <ul class="nav nav-secondary">
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="collapsed" aria-expanded="false">
                            <i class="fi fi-rr-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Páginas</h4>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('despesa') }}">
                            <i class="fi fi-rr-coins"></i>
                            <p>Despesas</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('entrada') }}">
                            <i class="fi fi-rr-credit-card"></i>
                            <p>Entrada</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('categoria') }}">
                            <i class="fi fi-rr-tags"></i>
                            <p>Categoria</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="main-panel">

        <div class="container">
            @yield('content')
        </div>

        <footer class="footer">
            <div class="container-fluid d-flex justify-content-center">
                <nav class="pull-left">
                    <div class="copyright">
                        Site criado por Rafael © 2024. Todos os direitos reservados.
                    </div>
                </nav>
            </div>
        </footer>
    </div>

    <script src="{{ asset('assets/dist/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/dist/js/jquery.js') }}"></script>
    <script src="{{ asset('assets/dist/js/jquery_mask.js') }}"></script>
    <script src="{{ asset('assets/dist/js/ckeditor.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr"></script>
    <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/chart-circle/circles.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/jsvectormap/world.js') }}"></script>
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script>
        @if (Session::has('success'))
            Swal.fire({
                position: "top-center",
                icon: 'success',
                title: 'Sucesso!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        @if (Session::has('error'))
            Swal.fire({
                position: "top-center",
                icon: 'error',
                title: 'Erro!',
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        @if (Session::has('info'))
            Swal.fire({
                position: "top-center",
                icon: 'info',
                title: 'Info',
                text: "{{ session('info') }}",
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        @if (Session::has('warning'))
            Swal.fire({
                position: "top-center",
                icon: 'warning',
                title: 'Aviso!',
                text: "{{ session('warning') }}",
                showConfirmButton: false,
                timer: 1500
            });
        @endif
    </script>
    @yield('javascript')
</body>

</html>
