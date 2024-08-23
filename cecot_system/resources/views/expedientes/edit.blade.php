@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')

    <div class="container mt-5">
        <h2>Editar Expediente</h2>

        <form action="{{ route('expedientes.update', $expediente->id_expediente) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="id_preso">Preso</label>
                <select class="form-control" id="id_preso" name="id_preso" required>
                    @foreach($presos as $preso)
                        <option value="{{ $preso->id_preso }}" {{ $preso->id_preso == $expediente->id_preso ? 'selected' : '' }}>{{ $preso->nombre }} (DUI: {{ $preso->numeroIdentificacion }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="descripcionDelCaso">Descripción del Caso</label>
                <textarea class="form-control" id="descripcionDelCaso" name="descripcionDelCaso" rows="3" required>{{ $expediente->descripcionDelCaso }}</textarea>
            </div>
            <div class="form-group">
                <label for="estadoDelCaso">Estado del Caso</label>
                <select class="form-control" id="estadoDelCaso" name="estadoDelCaso" required>
                    <option value="1" {{ $expediente->estadoDelCaso ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ !$expediente->estadoDelCaso ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
@endsection
