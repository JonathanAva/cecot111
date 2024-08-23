@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')

    <div class="container mt-5">
        <h2>Gestión de Expedientes del Preso</h2>
        <div class="d-flex justify-content-between mb-3">
            <form action="{{ route('expedientes.index') }}" method="GET" class="d-flex">
                <input type="text" name="id_expediente" class="form-control me-2" placeholder="ID de expediente">
                <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
            </form>
            <a href="{{ route('expedientes.create') }}" class="btn btn-primary">Agregar</a>
        </div>
        <div class="scrollable-container" style="max-height: 500px; overflow-y: auto; overflow-x: hidden;">
            <div class="row">
                @foreach($expedientes as $expediente)
                    <div class="col-12">
                        <div class="card mb-3" style="width: 100%; transition: transform 0.2s, box-shadow 0.2s;"> 
                            <div class="card-body">
                                <h5 class="card-title">Expediente {{ $expediente->id_expediente }}</h5>
                                <p class="card-text"><strong>Preso:</strong> {{ $expediente->preso->nombre }} (DUI: {{ $expediente->preso->numeroIdentificacion }})</p>
                                <p class="card-text"><strong>Descripción del Caso:</strong> {{ Str::limit($expediente->descripcionDelCaso, 200) }}</p>
                                <p class="card-text"><strong>Estado del Caso:</strong> {{ $expediente->estadoDelCaso ? 'Activo' : 'Inactivo' }}</p>
                                <a href="{{ route('expedientes.show', $expediente->id_expediente) }}" class="btn btn-info btn-sm">Ver</a>
                                <a href="{{ route('expedientes.edit', $expediente->id_expediente) }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ route('expedientes.destroy', $expediente->id_expediente) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este expediente?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <style>        
        .card:hover {
            transform: scale(1.02); 
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
        }
    </style>
@endsection
