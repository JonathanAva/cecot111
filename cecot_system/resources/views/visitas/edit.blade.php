@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')
<div class="container mt-5">
    <h2>Editar Visita</h2>

    <form action="{{ route('visitas.update', $visita->id_visita) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre del Visitante</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $visita->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="parentesco">Parentesco</label>
            <input type="text" class="form-control" id="parentesco" name="parentesco" value="{{ $visita->parentesco }}" required>
        </div>
        <div class="form-group">
            <label for="fecha_visita">Fecha de Visita</label>
            <input type="date" class="form-control" id="fecha_visita" name="fecha_visita" value="{{ $visita->fecha_visita }}" required>
        </div>
        <div class="form-group">
            <label for="hora_visita">Hora de Visita</label>
            <input type="time" class="form-control" id="hora_visita" name="hora_visita" value="{{ $visita->hora_visita }}" required>
        </div>
        <div class="form-group">
            <label for="dui_preso">DUI del Preso</label>
            <input type="text" class="form-control" id="dui_preso" name="dui_preso" value="{{ $visita->dui_preso }}" required>
        </div>
        <div class="form-group">
            <label for="id_preso">Nombre del Preso</label>
            <select class="form-control" id="id_preso" name="id_preso" required>
                @foreach($presos as $preso)
                    <option value="{{ $preso->id_preso }}" {{ $preso->id_preso == $visita->id_preso ? 'selected' : '' }}>
                        {{ $preso->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
