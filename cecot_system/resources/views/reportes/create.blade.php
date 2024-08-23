@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')

    <div class="container mt-5">
        <h2>Agregar Reporte</h2>

        <form action="{{ route('reportes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="id_usuario">ID Usuario</label>
                <select class="form-control" id="id_usuario" name="id_usuario" required>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id_usuario }}">{{ $usuario->id_usuario }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="id_preso">ID Preso</label>
                <select class="form-control" id="id_preso" name="id_preso" required>
                    @foreach($presos as $preso)
                        <option value="{{ $preso->id_preso }}">{{ $preso->id_preso }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tipo_reporte">Tipo de Reporte</label>
                <input type="text" class="form-control" id="tipo_reporte" name="tipo_reporte" required>
            </div>
            <div class="form-group">
                <label for="fecha_reporte">Fecha de Reporte</label>
                <input type="date" class="form-control" id="fecha_reporte" name="fecha_reporte" required>
            </div>
            <div class="form-group">
                <label for="hora_reporte">Hora de Reporte</label>
                <input type="time" class="form-control" id="hora_reporte" name="hora_reporte" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
