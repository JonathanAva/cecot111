@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Gráfica de Delitos Más Comunes</h1>
    <canvas id="delitosChart" width="400" height="200"></canvas>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        fetch("{{ route('delitos.data') }}")
            .then(response => response.json())
            .then(data => {
                const labels = data.map(item => item.descripcion);
                const values = data.map(item => item.total);

                const ctx = document.getElementById('delitosChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Cantidad de Delitos',
                            data: values,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
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
            });
    });
</script>
@endsection