@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')

    <div class="container mt-5">
        <h2 class="mb-4">Reportes</h2>

        <a href="{{ route('reportes.create') }}" class="btn btn-primary mb-3">Agregar</a>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>ID Reporte</th>
                        <th>ID Usuario</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th style="max-width: 150px;">Descripción</th> <!-- Limitar el ancho de la columna -->
                        <th>ID Preso</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reportes as $reporte)
                        <tr>
                            <td>{{ $reporte->id_reporte }}</td>
                            <td>{{ $reporte->usuario->id_usuario }}</td>
                            <td>{{ $reporte->tipo_reporte }}</td>
                            <td>{{ \Carbon\Carbon::parse($reporte->fecha_reporte)->format('d/m/Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($reporte->hora_reporte)->format('H:i') }}</td>
                            <td class="text-truncate" style="max-width: 150px;">{{ $reporte->descripcion }}</td> <!-- Aplicar truncamiento de texto -->
                            <td>{{ $reporte->preso->id_preso }}</td>
                            <td>
                                <a href="{{ route('reportes.edit', $reporte->id_reporte) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('reportes.destroy', $reporte->id_reporte) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de eliminar este reporte?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <a href="{{ route('reportes.print', $reporte->id_reporte) }}" class="btn btn-info btn-sm">Imprimir</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
