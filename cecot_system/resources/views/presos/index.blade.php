@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')

    <div class="container mt-5">
        <h2 class="text-center mb-4">Gestión de Presos</h2>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar por nombre, DUI">
                    <button class="btn btn-outline-secondary" type="button" id="clearFilter">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6 text-end">
                
                <button class="btn btn-primary" style="background-color: #00ADB5;" data-toggle="modal" data-target="#addPresoModal">
                    Agregar Preso
                </button>
            </div>
        </div>

        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-striped table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID Preso</th>
                        <th scope="col">DUI</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Celda</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody id="presosTableBody">
                    @foreach($presos as $preso)
                        <tr id="presoRow{{ $preso->id_preso }}" data-id="{{ $preso->id_preso }}">
                            <td>{{ $preso->id_preso }}</td>
                            <td>{{ $preso->numeroIdentificacion }}</td>
                            <td>{{ $preso->nombre }}</td>
                            <td>{{ $preso->apellido }}</td>
                            <td>{{ $preso->celda->numeroCelda }}</td>
                            <td>{{ $preso->estado ? 'Activo' : 'Inactivo' }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger me-2 deletePresoBtn" data-id="{{ $preso->id_preso }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-dark editPresoBtn" data-id="{{ $preso->id_preso }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-info viewDelitosBtn" data-id="{{ $preso->id_preso }}">
                                    <i class="fas fa-eye"></i> Ver Delitos
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>

        <!-- Tabla para mostrar los delitos del preso seleccionado -->
        <div class="mt-5 mb-5">
            <h3 class="text-center">Delitos por Preso</h3>
            <div class="table-responsive">
                <table class="table table-striped table-bordered text-center">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID Delito</th>
                            <th scope="col">Descripción</th>
                        </tr>
                    </thead>
                    <tbody id="delitosTableBody">
                        <!-- Los delitos se cargarán aquí cuando se seleccione un preso -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para agregar/editar preso -->
    <div class="modal fade" id="addPresoModal" tabindex="-1" role="dialog" aria-labelledby="addPresoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPresoModalLabel">Agregar Preso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="presoForm">
                    <form id="presoForm">
                        <div class="modal-body">
                            <input type="hidden" id="presoId" name="presoId">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="apellido" class="form-label">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fechaN                            acimiento" class="form-label">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" id="fechaNacimiento" name="fechaNacimiento" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="numeroIdentificacion" class="form-label">Número de Identificación (DUI)</label>
                                    <input type="text" class="form-control" id="numeroIdentificacion" name="numeroIdentificacion" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="fechaIngreso" class="form-label">Fecha de Ingreso</label>
                                    <input type="date" class="form-control" id="fechaIngreso" name="fechaIngreso" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="fechaLiberacion" class="form-label">Fecha de Liberación</label>
                                    <input type="date" class="form-control" id="fechaLiberacion" name="fechaLiberacion">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select" id="estado" name="estado" required>
                                        <option value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="condena" class="form-label">Condena</label>
                                    <input type="text" class="form-control" id="condena" name="condena" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="id_celda" class="form-label">Celda</label>
                                <select class="form-select" id="id_celda" name="id_celda" required>
                                    @foreach($celdas as $celda)
                                        <option value="{{ $celda->id_celda }}">{{ $celda->numeroCelda }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" style="background-color: #00ADB5;">Guardar</button>
                        </div>
                    </form>
                </form>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
<script>
    $(document).ready(function () {
        // Filtro de búsqueda por nombre o DUI
        $('#searchInput').on('input', function () {
            let filter = $(this).val().toLowerCase();
            $('#presosTableBody tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(filter) > -1);
            });
        });

        // Limpiar el filtro
        $('#clearFilter').on('click', function () {
            $('#searchInput').val('');
            $('#presosTableBody tr').show();
        });

        // Manejar la selección de un preso para ver sus delitos
        $(document).on('click', '.viewDelitosBtn', function () {
            let presoId = $(this).data('id');

            // Realizar una solicitud AJAX para obtener los delitos del preso seleccionado
            $.ajax({
                url: `/presos/${presoId}/delitos`,
                type: 'GET',
                success: function (response) {
                    // Limpiar la tabla de delitos
                    $('#delitosTableBody').empty();

                    // Llenar la tabla con los delitos recibidos
                    if (response.delitos && response.delitos.length > 0) {
                        response.delitos.forEach(function (delito) {
                            $('#delitosTableBody').append(`
                                <tr>
                                    <td>${delito.id_delito}</td>
                                    <td>${delito.descripcion}</td>
                                </tr>
                            `);
                        });
                    } else {
                        $('#delitosTableBody').append(`
                            <tr>
                                <td colspan="2">No hay delitos asignados a este preso.</td>
                            </tr>
                        `);
                    }
                },
                error: function (response) {
                    console.log('Error al obtener los delitos del preso:', response);
                }
            });
        });

        // Manejar el envío del formulario para agregar o editar un preso
        $('#presoForm').on('submit', function (e) {
            e.preventDefault();

            let formData = {
                id: $('#presoId').val(),
                nombre: $('#nombre').val(),
                apellido: $('#apellido').val(),
                fechaNacimiento: $('#fechaNacimiento').val(),
                numeroIdentificacion: $('#numeroIdentificacion').val(),
                fechaIngreso: $('#fechaIngreso').val(),
                fechaLiberacion: $('#fechaLiberacion').val(),
                estado: $('#estado').val(),
                condena: $('#condena').val(),
                id_celda: $('#id_celda').val(),
            };

            let url = $('#presoId').val() ? `/presos/${$('#presoId').val()}` : "{{ route('presos.store') }}";
            let method = $('#presoId').val() ? 'PUT' : 'POST';

            $.ajax({
                url: url,
                type: method,
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (method === 'POST') {
                        // Agregar el nuevo preso a la tabla sin recargar la página
                        $('#presosTableBody').append(`
                            <tr id="presoRow${response.id_preso}" data-id="${response.id_preso}">
                                <td>${response.id_preso}</td>
                                <td>${response.numeroIdentificacion}</td>  <!-- DUI -->
                                <td>${response.nombre}</td>
                                <td>${response.apellido}</td>
                                <td>${response.celda.numeroCelda}</td>
                                <td>${response.estado ? 'Activo' : 'Inactivo'}</td>
                                <td>
                                    <button class="btn btn-sm btn-danger me-2 deletePresoBtn" data-id="${response.id_preso}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                    <button class="btn btn-sm btn-dark editPresoBtn" data-id="${response.id_preso}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-info viewDelitosBtn" data-id="${response.id_preso}">
                                        <i class="fas fa-eye"></i> Ver Delitos
                                    </button>
                                </td>
                            </tr>
                        `);
                    } else {
                        // Actualizar la fila del preso en la tabla sin recargar la página
                        $(`#presoRow${response.id_preso}`).html(`
                            <td>${response.id_preso}</td>
                            <td>${response.numeroIdentificacion}</td>  <!-- DUI -->
                            <td>${response.nombre}</td>
                            <td>${response.apellido}</td>
                            <td>${response.celda.numeroCelda}</td>
                            <td>${response.estado ? 'Activo' : 'Inactivo'}</td>
                            <td>
                                <button class="btn btn-sm btn-danger me-2 deletePresoBtn" data-id="${response.id_preso}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-dark editPresoBtn" data-id="${response.id_preso}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-info viewDelitosBtn" data-id="${response.id_preso}">
                                    <i class="fas fa-eye"></i> Ver Delitos
                                </button>
                            </td>
                        `);
                    }

                    // Cierra el modal y resetea el formulario
                    $('#addPresoModal').modal('hide');
                    $('#presoForm')[0].reset();
                    $('#presoId').val('');
                },
                error: function (response) {
                    // Manejar errores
                    console.log(response);
                }
            });
        });

        // Manejar la eliminación de presos
        $(document).on('click', '.deletePresoBtn', function () {
            let id = $(this).data('id');

            if (confirm('¿Estás seguro de que deseas eliminar este preso?')) {
                $.ajax({
                    url: `/presos/${id}`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success: function () {
                        $(`#presoRow${id}`).remove();
                        // Limpiar la tabla de delitos si el preso eliminado estaba seleccionado
                        $('#delitosTableBody').empty();
                    },
                    error: function (response) {
                        console.log(response);
                    }
                });
            }
        });

        
        $(document).on('click', '.editPresoBtn', function () {
            let id = $(this).data('id');

            $.get(`/presos/${id}/edit`, function (preso) {
                $('#presoId').val(preso.id_preso);
                $('#nombre').val(preso.nombre);
                $('#apellido').val(preso.apellido);
                $('#fechaNacimiento').val(preso.fechaNacimiento);
                $('#numeroIdentificacion').val(preso.numeroIdentificacion);
                $('#fechaIngreso').val(preso.fechaIngreso);
                $('#fechaLiberacion').val(preso.fechaLiberacion);
                $('#estado').val(preso.estado);
                $('#condena').val(preso.condena);
                $('#id_celda').val(preso.id_celda);

                $('#addPresoModalLabel').text('Editar Preso');
                $('#addPresoModal').modal('show');
            });
        });

      
        $('#addPresoModal').on('hidden.bs.modal', function () {
            $('#presoForm')[0].reset();
            $('#presoId').val('');
            $('#addPresoModalLabel').text('Agregar Preso');
        });
    });
</script>
@endsection

