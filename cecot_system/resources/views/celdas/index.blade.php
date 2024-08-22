@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')

    <div class="container mt-5">
        <h2 class="text-center mb-4">Datos de las celdas</h2>

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="input-group">
                    <input type="text" class="form-control" id="searchInput" placeholder="Buscar por ID de celda, número de celda, o estado">
                    <button class="btn btn-outline-secondary" type="button" id="clearFilter">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <!-- Botón para abrir el modal -->
                <button class="btn btn-primary" style="background-color: #00ADB5;" data-toggle="modal" data-target="#addCeldaModal">
                    Agregar
                </button>
            </div>
        </div>

        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
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
                <tbody id="celdasTableBody">
                    @foreach($celdas as $celda)
                    <tr id="celdaRow{{ $celda->id_celda }}">
                        <td>{{ $celda->id_celda }}</td>
                        <td>{{ $celda->numeroCelda }}</td>
                        <td>{{ $celda->capacidad }}</td>
                        <td>{{ $celda->numeroDePresos }}</td>
                        <td>{{ $celda->estado ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                            <button class="btn btn-sm btn-info me-2 viewPresosBtn" data-id="{{ $celda->id_celda }}">
                                Ver presos
                            </button>
                            <button class="btn btn-sm btn-danger me-2 deleteCeldaBtn" data-id="{{ $celda->id_celda }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-dark editCeldaBtn" data-id="{{ $celda->id_celda }}">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-5 mb-5">
        <h4 class="text-center">Presos en la celda seleccionada</h4>
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-striped table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID Preso</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Fecha de Ingreso</th>
                    </tr>
                </thead>
                <tbody id="presosTableBody">
                    <!-- Los presos se cargarán aquí dinámicamente -->
                </tbody>
            </table>
        </div>
    </div>
    
    

    <!-- Modal para agregar/editar celdas -->
    <div class="modal fade" id="addCeldaModal" tabindex="-1" role="dialog" aria-labelledby="addCeldaModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCeldaModalLabel">Agregar Celda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="celdaForm">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="numeroCelda" class="form-label">Número de Celda</label>
                            <input type="number" class="form-control" id="numeroCelda" name="numeroCelda" required>
                        </div>
                        <div class="mb-3">
                            <label for="capacidad" class="form-label">Capacidad</label>
                            <input type="number" class="form-control" id="capacidad" name="capacidad" required>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado" required>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" style="background-color: #00ADB5;">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
    // Filtro de búsqueda por ID, número de celda o estado
    $('#searchInput').on('input', function () {
        let filter = $(this).val().toLowerCase();
        $('#celdasTableBody tr').filter(function () {
            $(this).toggle($(this).text().toLowerCase().indexOf(filter) > -1);
        });
    });

    // Limpiar el filtro
    $('#clearFilter').on('click', function () {
        $('#searchInput').val('');
        $('#celdasTableBody tr').show();
    });

    // Manejar el envío del formulario para agregar/editar una celda
    $('#celdaForm').on('submit', function (e) {
        e.preventDefault();

        let formData = {
            numeroCelda: $('#numeroCelda').val(),
            capacidad: $('#capacidad').val(),
            estado: $('#estado').val(),
        };

        let url = $(this).attr('action');  // Obtén la URL del formulario
        let method = $(this).find('input[name="_method"]').val() || 'POST';  // Obtén el método (POST o PUT)

        $.ajax({
            url: url,
            type: method,
            data: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function (response) {
                if (method === 'POST') {
                    // Agregar la nueva celda a la tabla sin recargar la página
                    $('#celdasTableBody').append(`
                        <tr id="celdaRow${response.id_celda}">
                            <td>${response.id_celda}</td>
                            <td>${response.numeroCelda}</td>
                            <td>${response.capacidad}</td>
                            <td>${response.numeroDePresos || 0}</td>
                            <td>${response.estado ? 'Activo' : 'Inactivo'}</td>
                            <td>
                                <button class="btn btn-sm btn-info me-2 viewPresosBtn" data-id="{{ $celda->id_celda }}">
                                    Ver presos
                                </button>
                                <button class="btn btn-sm btn-danger me-2 deleteCeldaBtn" data-id="{{ $celda->id_celda }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-dark editCeldaBtn" data-id="{{ $celda->id_celda }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>

                        </tr>
                    `);
                } else {
                    // Actualizar la fila de la celda en la tabla sin recargar la página
                    $(`#celdaRow${response.id_celda}`).html(`
                        <td>${response.id_celda}</td>
                        <td>${response.numeroCelda}</td>
                        <td>${response.capacidad}</td>
                        <td>${response.numeroDePresos || 0}</td>
                        <td>${response.estado ? 'Activo' : 'Inactivo'}</td>
                        <td>
                            <button class="btn btn-sm btn-info me-2 viewPresosBtn" data-id="{{ $celda->id_celda }}">
                                Ver presos
                            </button>
                            <button class="btn btn-sm btn-danger me-2 deleteCeldaBtn" data-id="{{ $celda->id_celda }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <button class="btn btn-sm btn-dark editCeldaBtn" data-id="{{ $celda->id_celda }}">
                                <i class="fas fa-edit"></i>
                            </button>
                        </td>

                    `);
                }

                // Cierra el modal y resetea el formulario
                $('#addCeldaModal').modal('hide');
                $('#celdaForm')[0].reset();
                $('#celdaForm').attr('action', "{{ route('celdas.store') }}");  // Revertir a la URL de creación
                $('input[name="_method"]').remove();  // Eliminar el método PUT si estaba presente
            },
            error: function (response) {
                // Manejar errores
                console.log(response);
            }
        });
    });

    // Manejar la eliminación de celdas
    $(document).on('click', '.deleteCeldaBtn', function () {
        let id = $(this).data('id');

        if (confirm('¿Estás seguro de que deseas eliminar esta celda?')) {
            $.ajax({
                url: `/celdas/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function () {
                    $(`#celdaRow${id}`).remove();
                },
                error: function (response) {
                    console.log(response);
                }
            });
        }
    });

    // Manejar la edición de celdas
    $(document).on('click', '.editCeldaBtn', function () {
        let id = $(this).data('id');

        $.get(`/celdas/${id}/edit`, function (celda) {
            console.log(celda);  // Depuración: Verificar que los datos lleguen correctamente
            $('#numeroCelda').val(celda.numeroCelda);
            $('#capacidad').val(celda.capacidad);
            $('#estado').val(celda.estado);
            $('#celdaForm').attr('action', `/celdas/${id}`);  // Cambiar la URL para la edición
            $('#celdaForm').append('<input type="hidden" name="_method" value="PUT">');  // Agregar el método PUT para la edición
            $('#addCeldaModalLabel').text('Editar Celda');
            $('#addCeldaModal').modal('show');
        }).fail(function(response) {
            console.log("Error al obtener la celda:", response);  // Manejar errores de la solicitud AJAX
        });
    });

    // Limpiar el formulario cuando se cierra el modal
    $('#addCeldaModal').on('hidden.bs.modal', function () {
        $('#celdaForm')[0].reset();
        $('#celdaForm').attr('action', "{{ route('celdas.store') }}");  // Revertir a la URL de creación
        $('input[name="_method"]').remove();  // Eliminar el método PUT si estaba presente
        $('#addCeldaModalLabel').text('Agregar Celda');
    });


    $(document).on('click', '.viewPresosBtn', function () {
        let celdaId = $(this).data('id');
        
        $.get(`/celdas/${celdaId}/presos`, function (presos) {
            let presosTableBody = $('#presosTableBody');
            presosTableBody.empty();  // Limpiar la tabla antes de cargar nuevos datos

            if (presos.length > 0) {
                presos.forEach(preso => {
                    presosTableBody.append(`
                        <tr>
                            <td>${preso.id_preso}</td>
                            <td>${preso.nombre}</td>
                            <td>${preso.apellido}</td>
                            <td>${preso.fechaIngreso}</td>
                        </tr>
                    `);
                });
            } else {
                presosTableBody.append(`
                    <tr>
                        <td colspan="4">No hay presos asignados a esta celda.</td>
                    </tr>
                `);
            }
        }).fail(function(response) {
            console.log("Error al obtener los presos:", response);  // Manejar errores
        });
    });
});


</script>
@endsection
