@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')
    <div class="container mt-5">
        <h2 class="text-center mb-4">Gestionar Empleados</h2>

        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Buscar por nombre de empleado">
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('empleados.create') }}" class="btn btn-primary">Agregar Empleado</a>
            </div>
        </div>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Usuario</th>
                    <th>Nombre</th>
                    <th>Rol</th>
                    <th>Info Contacto</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado->id_usuario }}</td>
                        <td>{{ $empleado->nombre_usuario }}</td>
                        <td>{{ $empleado->rol }}</td>
                        <td>{{ $empleado->info_contacto }}</td>
                        <td>
                            <a href="{{ route('empleados.edit', $empleado->id_usuario) }}" class="btn btn-sm btn-dark">Editar</a>
                            <form action="{{ route('empleados.destroy', $empleado->id_usuario) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('¿Estás seguro de que deseas eliminar este empleado? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
