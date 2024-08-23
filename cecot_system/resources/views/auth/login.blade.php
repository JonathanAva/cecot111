<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/Login.css') }}" rel="stylesheet">
    
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

   
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3 d-flex align-items-center justify-content-start ml-5"> 
                <div class="login-box">
                    <h2 class="text-center" style="color:white">Bienvenido al Sistema Penitenciario</h2>
                    <p class="text-center" style="color:white">Inicia sesión para acceder a tu cuenta</p>
                    
                   
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">
                        @csrf  
                        <div class="form-group">
                            <label for="nombre_usuario" style="color:white">Nombre de usuario</label>
                            <input type="text" name="nombre_usuario" class="form-control" placeholder="Ingresa nombre de usuario" required>
                        </div>
                        <div class="form-group">
                            <label for="password" style="color:white">Contraseña</label>
                            <input type="password" name="password" class="form-control" placeholder="Ingresa tu contraseña" required>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block" style="color:white">Iniciar Sesión</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
