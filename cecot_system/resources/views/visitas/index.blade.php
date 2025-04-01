@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')
<div class="container mt-5">
    <div class="row">
        <div class="col-12 text-center">
            <h2 class="mb-4">Gestion de visitas</h2>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-6">
            <form method="GET" action="{{ route('visitas.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Filtro de búsqueda por nombre preso, fecha y DUI de preso" value="{{ request('search') }}">
                <button type="submit" class="btn btn-light ms-2">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('visitas.create') }}" class="btn btn-primary">Agregar</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th>ID Visita</th>
                    <th>Nombre</th>
                    <th>Parentesco</th>
                    <th>Fecha de Visita</th>
                    <th>Hora de Visita</th>
                    <th>DUI Preso</th>
                    <th>Nombre Preso</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($visitas as $visita)
                <tr>
                    <td>{{ $visita->id_visita }}</td>
                    <td>{{ $visita->nombreDelVisitante }}</td>
                    <td>{{ $visita->relacionConElPreso }}</td>
                    <td>{{ \Carbon\Carbon::parse($visita->fechaDeVisita)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($visita->horaDeVisita)->format('h:i A') }}</td>                    
                    <td>{{ $visita->preso->numeroIdentificacion }}</td>
                    <td>{{ $visita->preso->nombre }}</td>
                    <td class="text-center">
                        <a href="{{ route('visitas.edit', $visita->id_visita) }}" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil"></i> 
                        </a>
                        <form action="{{ route('visitas.destroy', $visita->id_visita) }}" method="POST" style="display:inline;" onsubmit="return confirm('¿Estás seguro de que deseas eliminar la visita?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash"></i> 
                            </button>
                        </form>
                        
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Contenedor para la gráfica de visitas -->
    <div class="mt-5">
        <h3 class="text-center">Gráfica de Visitas por Fecha</h3>
        <canvas id="visitasChart" width="400" height="200"></canvas>
    </div>
    </div>

    <div class="d-flex justify-content-center">
        {{ $visitas->links() }}
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    // Generar la gráfica de visitas
    fetch("{{ route('visitas.data') }}")
        .then(response => response.json())
        .then(data => {
            const labels = data.map(item => item.fecha);
            const values = data.map(item => item.total);

            const ctx = document.getElementById('visitasChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Cantidad de Visitas',
                        data: values,
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderColor: 'rgba(153, 102, 255, 1)',
                        borderWidth: 1,
                        tension: 0.4 // Suaviza las líneas
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error al cargar los datos de la gráfica:', error);
        });
});
</script>
@endsection
