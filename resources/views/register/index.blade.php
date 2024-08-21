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
    <div class="container d-flex justify-content-center align-items-center" style="height: 100vh;">
        <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px; border-radius: 15px;">
            <div class="card-header text-center bg-white border-0">
                <img src="{{ asset('assets/img/logo_preta.png') }}" alt="Logo do Plan Finance" class="mb-3"
                    height="45" />
                <h4>Criar Conta</h4>
            </div>
            <div class="card-body">
                <form action="{{ url('register') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nome:</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                        @error('name')
                            <div class="bg-error">
                                <p class="text-danger text-error">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                        @error('email')
                            <div class="bg-error">
                                <p class="text-danger text-error">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Senha:</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                        <small class="form-text text-muted">A senha deve ter mais de 8 caracteres.</small>
                        @error('password')
                            <div class="bg-error">
                                <p class="text-danger text-error">{{ $message }}</p>
                            </div>
                        @enderror
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-4">Registrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/dist/js/jquery.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="{{ asset('assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
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
</body>

</html>
