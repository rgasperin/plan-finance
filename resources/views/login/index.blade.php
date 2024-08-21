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

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link rel="stylesheet" href="{{ url('assets/dist/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/kaiadmin.min.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/css/styles.css') }}">

</head>

<body>
    <div class="container d-flex justify-content-center align-items-center bg-container-login">
        <div class="card shadow-lg p-4 bg-card-login">
            <div class="card-header text-center bg-white border-0">
                <img src="{{ asset('assets/img/logo_preta.png') }}" alt="Logo do Plan Finance" class="mb-3"
                    height="45" />
                <h4>Faça seu Login</h4>
            </div>
            <div class="card-body">

                @if (auth()->check())
                    <div class="text-center mb-3">
                        Você está logado na conta {{ auth()->user()->name }} |
                        <form action="{{ url('logout/' . auth()->user()->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                        </form>
                    </div>
                    <div class="text-center">
                        <p>Clique aqui para ir à página principal</p>
                        <a href="{{ url('/') }}" class="btn btn-link">Página Principal</a>
                    </div>
                @else
                    <form action="{{ url('login') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="email">E-mail:</label>
                            <input type="text" name="email" id="email" class="form-control"
                                placeholder="Seu e-mail" required>
                            @error('email')
                                <div class="bg-error">
                                    <p class="text-danger text-error">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">Senha:</label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Sua senha" required>
                            @error('password')
                                <div class="bg-error">
                                    <p class="text-danger text-error">{{ $message }}</p>
                                </div>
                            @enderror
                        </div>
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>

                    <div class="text-center mt-3">
                        <p class="mb-1">Não tem uma conta?</p>
                        <a href="{{ url('register') }}" class="btn btn-link p-0">Registrar</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/dist/js/jquery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>

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
</body>

</html>
