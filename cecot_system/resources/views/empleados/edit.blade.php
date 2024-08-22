@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Editar Empleado</h2>

        <form action="{{ route('empleados.update', $empleado->id_usuario) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="nombre_usuario" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="{{ $empleado->nombre_usuario }}" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña (dejar en blanco para no cambiarla)</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>

            <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select class="form-select" id="rol" name="rol" required>
                    <option value="admin" {{ $empleado->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="usuario" {{ $empleado->rol == 'usuario' ? 'selected' : '' }}>Usuario</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="info_contacto" class="form-label">Información de Contacto</label>
                <input type="text" class="form-control" id="info_contacto" name="info_contacto" value="{{ $empleado->info_contacto }}">
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="{{ route('empleados.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
@endsection
