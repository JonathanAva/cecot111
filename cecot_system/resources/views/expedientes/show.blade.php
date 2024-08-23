@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')

    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Expediente {{ $expediente->id_expediente }}</h2>
            </div>
            <div class="card-body">
                <p><strong>Preso:</strong> {{ $expediente->preso->nombre }} (DUI: {{ $expediente->preso->numeroIdentificacion }})</p>
                <p><strong>Descripción del Caso:</strong> {{ $expediente->descripcionDelCaso }}</p>
                <p><strong>Estado del Caso:</strong> {{ $expediente->estadoDelCaso ? 'Activo' : 'Inactivo' }}</p>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">Volver</a>
                <button class="btn btn-primary" onclick="window.print();">Imprimir</button>
            </div>
        </div>
    </div>
@endsection
