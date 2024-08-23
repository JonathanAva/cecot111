@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')

    <div class="container mt-5">
        <h2>Editar Reporte</h2>

        <form action="{{ route('reportes.update', $reporte->id_reporte) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="id_usuario">ID Usuario</label>
                <select class="form-control" id="id_usuario" name="id_usuario" required>
                    @foreach($usuarios as $usuario)
                        <option value="{{ $usuario->id_usuario }}" {{ $usuario->id_usuario == $reporte->id_usuario ? 'selected' : '' }}>{{ $usuario->id_usuario }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="id_preso">ID Preso</label>
                <select class="form-control" id="id_preso" name="id_preso" required>
                    @foreach($presos as $preso)
                        <option value="{{ $preso->id_preso }}" {{ $preso->id_preso == $reporte->id_preso ? 'selected' : '' }}>{{ $preso->id_preso }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tipo_reporte">Tipo de Reporte</label>
                <input type="text" class="form-control" id="tipo_reporte" name="tipo_reporte" value="{{ $reporte->tipo_reporte }}" required>
            </div>
            <div class="form-group">
                <label for="fecha_reporte">Fecha de Reporte</label>
                <input type="date" class="form-control" id="fecha_reporte" name="fecha_reporte" value="{{ $reporte->fecha_reporte }}" required>
            </div>
            <div class="form-group">
                <label for="hora_reporte">Hora de Reporte</label>
                <input type="time" class="form-control" id="hora_reporte" name="hora_reporte" value="{{ $reporte->hora_reporte }}" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ $reporte->descripcion }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@endsection
