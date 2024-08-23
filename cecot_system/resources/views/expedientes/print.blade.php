@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Expediente {{ $expediente->id_expediente }}</h2>
            </div>
            <div class="card-body">
                <p><strong>Preso:</strong> {{ $expediente->preso->nombre }} (DUI: {{ $expediente->preso->numeroIdentificacion }})</p>
                <p><strong>Estado del Caso:</strong> {{ $expediente->estadoDelCaso ? 'Activo' : 'Inactivo' }}</p>
                <p><strong>Descripción del Caso:</strong></p>
                <p>{{ $expediente->descripcionDelCaso }}</p>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary" onclick="window.print();">Imprimir</button>
            </div>
        </div>
    </div>
@endsection
