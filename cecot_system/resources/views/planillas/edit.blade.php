@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')
<div class="container mt-5">
    <h2>Editar Planilla</h2>
    <form action="{{ route('planillas.update', $planilla->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="id_usuario">Usuario</label>
            <select class="form-control" id="id_usuario" name="id_usuario" required>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ $usuario->id == $planilla->id_usuario ? 'selected' : '' }}>
                        {{ $usuario->nombre_usuario }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="turnos_asignados">Turnos Asignados</label>
            <input type="text" class="form-control" id="turnos_asignados" name="turnos_asignados" value="{{ $planilla->turnos_asignados }}" required>
        </div>
        <div class="form-group">
            <label for="fechas_turno">Fechas Turno</label>
            <input type="date" class="form-control" id="fechas_turno" name="fechas_turno" value="{{ $planilla->fechas_turno }}" required>
        </div>
        <div class="form-group">
            <label for="actividades_asignadas">Actividades Asignadas</label>
            <textarea class="form-control" id="actividades_asignadas" name="actividades_asignadas" required>{{ $planilla->actividades_asignadas }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
