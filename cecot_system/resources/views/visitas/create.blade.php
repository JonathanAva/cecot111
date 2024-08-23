@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')
<div class="container mt-5">
    <h2>Agregar Visita</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('visitas.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="nombre">Nombre del Visitante</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>
        <div class="form-group">
            <label for="parentesco">Parentesco</label>
            <input type="text" class="form-control" id="parentesco" name="parentesco" value="{{ old('parentesco') }}" required>
        </div>
        <div class="form-group">
            <label for="fecha_visita">Fecha de Visita</label>
            <input type="date" class="form-control" id="fecha_visita" name="fecha_visita" value="{{ old('fecha_visita') }}" required>
        </div>
        <div class="form-group">
            <label for="hora_visita">Hora de Visita</label>
            <input type="time" class="form-control" id="hora_visita" name="hora_visita" value="{{ old('hora_visita') }}" required>
        </div>
        <div class="form-group">
            <label for="dui_preso">DUI del Preso</label>
            <input type="text" class="form-control @error('dui_preso') is-invalid @enderror" id="dui_preso" name="dui_preso" value="{{ old('dui_preso') }}" required>
            @error('dui_preso')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="id_preso">Nombre del Preso</label>
            <select class="form-control" id="id_preso" name="id_preso" required>
                @foreach($presos as $preso)
                    <option value="{{ $preso->id_preso }}" {{ old('id_preso') == $preso->id_preso ? 'selected' : '' }}>
                        {{ $preso->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@endsection
