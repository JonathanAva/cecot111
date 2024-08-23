@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')
<div class="container mt-5">
    <h2>Agregar Planilla</h2>
    <form action="{{ route('planillas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="id_usuario">Empleado</label>
            <select class="form-control" id="id_usuario" name="id_usuario" required>
                @foreach($empleados as $empleado)
                    <option value="{{ $empleado->id_usuario }}">{{ $empleado->nombre_usuario }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="turnos_Asignados">Turnos Asignados</label>
            <input type="text" class="form-control" id="turnos_Asignados" name="turnos_Asignados" required>
        </div>
        <div class="form-group">
            <label for="fechas_turno">Fechas Turno</label>
            <input type="date" class="form-control" id="fechas_turno" name="fechas_turno" required>
        </div>
        <div class="form-group">
            <label for="actividades_asignadas">Actividades Asignadas</label>
            <textarea class="form-control" id="actividades_asignadas" name="actividades_asignadas" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
