@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')
    <div class="container mt-5">
    <h2>Editar Visita</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('visitas.update', $visita->id_visita) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="nombre">Nombre del Visitante</label>
            <input type="text" class="form-control" id="nombre" name="nombre"
                value="{{ old('nombre', $visita->nombreDelVisitante) }}" required>
        </div>
        <div class="form-group">
            <label for="parentesco">Parentesco</label>
            <input type="text" class="form-control" id="parentesco" name="parentesco"
                value="{{ old('parentesco', $visita->relacionConElPreso) }}" required>
        </div>
        <div class="form-group">
            <label for="fecha_visita">Fecha de Visita</label>
            <input type="date" class="form-control" id="fecha_visita" name="fecha_visita"
                value="{{ old('fecha_visita', $visita->fechaDeVisita) }}" min="{{ date('Y-m-d') }}" required>
        </div>
        <div class="form-group">
            <label for="hora_visita">Hora de Visita</label>
            <input type="time" class="form-control" id="hora_visita" name="hora_visita"
                value="{{ old('hora_visita', $visita->horaDeVisita) }}" min="08:00" max="16:00" required>
        </div>
        <div class="form-group">
            <label for="dui_preso">DUI del Preso</label>
            <input type="text" class="form-control @error('dui_preso') is-invalid @enderror" id="dui_preso" name="dui_preso"
                value="{{ old('dui_preso', $presos->firstWhere('id_preso', $visita->id_preso)->numeroIdentificacion ?? '') }}" required>
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
                    <option value="{{ $preso->id_preso }}" {{ old('id_preso', $visita->id_preso) == $preso->id_preso ? 'selected' : '' }}>
                        {{ $preso->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const horaVisita = document.getElementById('hora_visita');

            // Validar que la hora esté entre 08:00 y 16:00
            horaVisita.addEventListener('change', function () {
                const horaSeleccionada = this.value;
                const horaMinima = "08:00";
                const horaMaxima = "16:00";

                if (horaSeleccionada < horaMinima || horaSeleccionada > horaMaxima) {
                    alert("Las horas de visita son entre las 8:00 AM y las 4:00 PM.");
                    this.value = ""; // Limpiar el campo si no cumple
                }
            });
        });
    </script>
@endsection
