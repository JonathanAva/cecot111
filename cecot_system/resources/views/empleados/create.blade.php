@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Agregar Empleado</h2>

        <form action="{{ route('empleados.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>

            <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select class="form-select" id="rol" name="rol" required>
                    <option value="admin">Administrador</option>
                    <option value="usuario">Usuario</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="info_contacto" class="form-label">Información de Contacto</label>
                <input type="text" class="form-control" id="info_contacto" name="info_contacto">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
