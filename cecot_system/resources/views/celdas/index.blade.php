@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')

    <div class="container mt-5">
        <h2 class="text-center mb-4">Datos de la celdas</h2>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Filtro de busqueda por celda" aria-label="Filtro de búsqueda">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('celdas.create') }}" class="btn btn-primary" style="background-color: #00ADB5;">Agregar</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID Celda</th>
                        <th scope="col">Celda</th>
                        <th scope="col">Capacidad</th>
                        <th scope="col">Número Presos</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Aquí agregarías los datos dinámicos de las celdas desde la base de datos -->
                    <tr>
                        <td>C001</td>
                        <td>24</td>
                        <td>100</td>
                        <td>65</td>
                        <td>Activo</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-danger me-2"><i class="fas fa-trash-alt"></i></a>
                            <a href="#" class="btn btn-sm btn-dark"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <td>C002</td>
                        <td>45</td>
                        <td>100</td>
                        <td>0</td>
                        <td>Inactiva</td>
                        <td>
                            <a href="#" class="btn btn-sm btn-danger me-2"><i class="fas fa-trash-alt"></i></a>
                            <a href="#" class="btn btn-sm btn-dark"><i class="fas fa-edit"></i></a>
                        </td>
                    </tr>
                    <!-- Fin de los datos dinámicos -->
                </tbody>
            </table>
        </div>
    </div>
@endsection
