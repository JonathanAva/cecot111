@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')

    <div class="container mt-4">
        <h1 class="text-center">Bienvenido al Sistema de Gestión Penitenciario</h1>

        <div class="row mt-5">
            
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4">
                <a href="#" class="card mb-3 text-decoration-none" style="height: 200px;">
                    <div class="row g-0 h-100">
                        <div class="col-md-4 bg-custom d-flex align-items-center justify-content-center">
                            <img src="{{ asset('images/gestionar_visitas.png') }}" class="img-fluid icon" alt="Gestionar Visitas">
                        </div>
                        <div class="col-md-8 d-flex align-items-center">
                            <div class="card-body text-dark">
                                <h5 class="card-title">Gestionar Visitas</h5>
                                <p class="card-text">Administra y organiza las visitas a los internos.</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="#" class="card mb-3 text-decoration-none" style="height: 200px;">
                    <div class="row g-0 h-100">
                        <div class="col-md-4 bg-custom d-flex align-items-center justify-content-center">
                            <img src="{{ asset('images/gestionar_presos.png') }}" class="img-fluid icon" alt="Gestionar Presos">
                        </div>
                        <div class="col-md-8 d-flex align-items-center">
                            <div class="card-body text-dark">
                                <h5 class="card-title">Gestionar Presos</h5>
                                <p class="card-text">Gestión completa de los internos.</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="{{ route('celdas.index') }}" class="card mb-3 text-decoration-none" style="height: 200px;">
                    <div class="row g-0 h-100">
                        <div class="col-md-4 bg-custom d-flex align-items-center justify-content-center">
                            <img src="{{ asset('images/gestionar_celdas.png') }}" class="img-fluid icon" alt="Gestionar Celdas">
                        </div>
                        <div class="col-md-8 d-flex align-items-center">
                            <div class="card-body text-dark">
                                <h5 class="card-title">Gestionar Celdas</h5>
                                <p class="card-text">Organiza y controla la disposición de las celdas.</p>
                            </div>
                        </div>
                    </div>
                </a>
                
            </div>

           
            <div class="col-lg-6 col-md-6 col-sm-12 mb-4 mt-5">
                <a href="#" class="card mb-3 text-decoration-none" style="height: 250px;">
                    <div class="row g-0 h-100">
                        <div class="col-md-4 bg-custom-large d-flex align-items-center justify-content-center">
                            <img src="{{ asset('images/generar_reportes.png') }}" class="img-fluid icon-large" alt="Generar Reportes">
                        </div>
                        <div class="col-md-8 d-flex align-items-center">
                            <div class="card-body text-dark">
                                <h5 class="card-title">Generar Reportes</h5>
                                <p class="card-text">Crea y visualiza reportes detallados.</p>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="#" class="card mb-3 text-decoration-none" style="height: 250px;">
                    <div class="row g-0 h-100">
                        <div class="col-md-4 bg-custom-large d-flex align-items-center justify-content-center">
                            <img src="{{ asset('images/ver_planillas.png') }}" class="img-fluid icon-large" alt="Ver Planillas">
                        </div>
                        <div class="col-md-8 d-flex align-items-center">
                            <div class="card-body text-dark">
                                <h5 class="card-title">Ver Planillas</h5>
                                <p class="card-text">Consulta las planillas actualizadas.</p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
