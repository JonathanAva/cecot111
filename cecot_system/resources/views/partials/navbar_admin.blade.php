<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #222831; padding: 1rem;">
  <div class="container-fluid">
   
    <a class="navbar-brand" href="{{ route('dashboard') }}" style="font-size: 1.5rem;">CECOT</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('delitos.index') }}" style="font-size: 1.2rem;">Gestionar Delitos</a>
        </li>        
        <li class="nav-item">
          <a class="nav-link" href="{{ route('expedientes.index') }}" style="font-size: 1.2rem;">Gestionar Expediente</a>
        </li>
        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="nav-link btn btn-link" style="color: white; font-size: 1.2rem;">Cerrar sesión</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</nav>
