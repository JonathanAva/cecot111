@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')

    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="mb-0">Reporte {{ $reporte->id_reporte }}</h2>
            </div>
            <div class="card-body">
                <p><strong>numero de identificaion del usuario :</strong> {{ $reporte->usuario->nombre }}  {{ $reporte->usuario->id_usuario }}</p>
                <p><strong>Tipo de Reporte:</strong> {{ $reporte->tipo_reporte }}</p>
                <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($reporte->fecha_reporte)->format('d/m/Y') }}</p>
                <p><strong>Hora:</strong> {{ \Carbon\Carbon::parse($reporte->hora_reporte)->format('H:i') }}</p>
                <p><strong>Descripción:</strong> {{ $reporte->descripcion }}</p>
                <p><strong>Preso:</strong> {{ $reporte->preso->nombre }} (DUI: {{ $reporte->preso->numeroIdentificacion }})</p>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('reportes.index') }}" class="btn btn-secondary">Volver</a>
                <button class="btn btn-primary" onclick="window.print();">Imprimir</button>
            </div>
        </div>
    </div>
@endsection
