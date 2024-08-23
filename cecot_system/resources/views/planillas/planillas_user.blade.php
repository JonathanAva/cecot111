@extends('layouts.app')

@section('content')
    @include('partials.navbar_user')
<div class="container">
    <h2 class="my-4 text-center">Planilla de empleados</h2>
    
    <form action="{{ route('planillas.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Filtro de búsqueda por nombre empleado">
            <div class="input-group-append">
                <button type="submit" class="btn btn-outline-secondary">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
    
    <table class="table table-bordered table-hover">
        <thead class="thead-light">
            <tr>
                <th>id planilla</th>
                <th>Empleado</th>
                <th>turnos asignados</th>
                <th>fechas turno</th>
                <th>actividades asignadas</th>
                <th>acción</th>
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
                <td class="text-center">
                 
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
