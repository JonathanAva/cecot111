@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')

    <div class="container mt-5">
        <h2>Agregar Expediente</h2>

        <form action="{{ route('expedientes.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="id_preso">Preso</label>
                <select class="form-control" id="id_preso" name="id_preso" required>
                    @foreach($presos as $preso)
                        <option value="{{ $preso->id_preso }}">{{ $preso->nombre }} (DUI: {{ $preso->numeroIdentificacion }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="descripcionDelCaso">Descripción del Caso</label>
                <textarea class="form-control" id="descripcionDelCaso" name="descripcionDelCaso" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="estadoDelCaso">Estado del Caso</label>
                <select class="form-control" id="estadoDelCaso" name="estadoDelCaso" required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
@endsection
