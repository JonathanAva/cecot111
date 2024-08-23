@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')
<div class="container">
    <h2 class="my-4 text-center">Planilla de empleados</h2>
    
    <div class="row mb-4">
        <div class="col-md-8">
            <form action="{{ route('planillas.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Filtro de búsqueda por nombre empleado">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('planillas.create') }}" class="btn btn-primary">AGREGAR</a>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="bg-dark text-white">
            <tr>
                <th>ID Planilla</th>
                <th>Empleado</th>
                <th>Turnos Asignados</th>
                <th>Fechas Turno</th>
                <th>Actividades Asignadas</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($planillas as $planilla)
                <tr>
                    <td>{{ $planilla->id_planilla }}</td>
                    <td>{{ $planilla->usuario->nombre_usuario }}</td> 
                    <td>{{ $planilla->turnos_Asignados }}</td>
                    <td>{{ $planilla->fechas_turno }}</td>
                    <td>{{ $planilla->actividades_asignadas }}</td>
                    <td>
                        <a href="{{ route('planillas.edit', $planilla->id_planilla) }}" class="btn btn-primary">Editar</a>
            
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
