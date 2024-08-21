@extends('layouts.app')

@section('content')
    @include('partials.navbar_admin')
    <div class="container mt-5">
        <h2 class="text-center mb-4">DELITO</h2>

        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" id="descripcionDelito" placeholder="Ingrese descripción del delito">
            </div>
            <div class="col-md-3 text-start">
                <button class="btn btn-primary" id="agregarDelitoBtn" style="background-color: #00ADB5;">AGREGAR</button>
                <button class="btn btn-primary" id="updateDelitoBtn" style="background-color: #00ADB5; display: none;">ACTUALIZAR</button>
            </div>
            <div class="col-md-3 text-end">
                <button class="btn btn-secondary" id="cancelUpdateBtn" style="display: none;">CANCELAR</button>
                <button class="btn btn-primary" id="agregarPresoDelitoBtn" style="background-color: #00ADB5;" data-toggle="modal" data-target="#asignarDelitoModal">AGREGAR PRESO-DELITO</button>
            </div>
        </div>
        
        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
            <table class="table table-striped table-bordered text-center">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">ID Delito</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody id="delitosTableBody">
                    @foreach($delitos as $delito)
                        <tr id="delitoRow{{ $delito->id_delito }}">
                            <td>{{ $delito->id_delito }}</td>
                            <td>{{ $delito->descripcion }}</td>
                            <td>
                                <button class="btn btn-sm btn-danger me-2 deleteDelitoBtn" data-id="{{ $delito->id_delito }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-dark editDelitoBtn" data-id="{{ $delito->id_delito }}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

 <!-- Modal para asignar delito a preso -->
<div class="modal fade" id="asignarDelitoModal" tabindex="-1" role="dialog" aria-labelledby="asignarDelitoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="asignarDelitoModalLabel">Asignar Delito a Preso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="presoDelitoForm">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="presoSelect" class="form-label">Seleccione Preso</label>
                        <select class="form-select" id="presoSelect" name="presoSelect" required>
                            @foreach($presos as $preso)
                                <option value="{{ $preso->id_preso }}">{{ $preso->nombre }} {{ $preso->apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="delitoSelect" class="form-label">Seleccione Delito</label>
                        <select class="form-select" id="delitoSelect" name="delitoSelect" required style="max-height: 100px; overflow-y: auto;">
                            @foreach($delitos as $delito)
                                <option value="{{ $delito->id_delito }}">{{ $delito->descripcion }}</option>
                            @endforeach
                        </select>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" style="background-color: #00ADB5;">Asignar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
    // Manejar el envío del formulario para agregar delito
    $('#agregarDelitoBtn').on('click', function () {
        let descripcion = $('#descripcionDelito').val().trim();

        if (descripcion !== '') {
            $.ajax({
                url: "{{ route('delitos.store') }}",
                type: "POST",
                data: {
                    descripcion: descripcion,
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    // Agregar el nuevo delito a la tabla y al select del modal
                    $('#delitosTableBody').append(`
                        <tr id="delitoRow${response.id_delito}">
                            <td>${response.id_delito}</td>
                            <td>${response.descripcion}</td>
                            <td>
                                <button class="btn btn-sm btn-danger me-2 deleteDelitoBtn" data-id="${response.id_delito}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-dark editDelitoBtn" data-id="${response.id_delito}">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    `);
                    $('#delitoSelect').append(`
                        <option value="${response.id_delito}">${response.descripcion}</option>
                    `);
                    $('#descripcionDelito').val('');
                },
                error: function (response) {
                    console.log('Error al agregar el delito:', response);
                }
            });
        } else {
            alert('La descripción del delito no puede estar vacía.');
        }
    });

    // Manejar la edición de delitos
    $(document).on('click', '.editDelitoBtn', function () {
        let id = $(this).data('id');

        // Obtener datos del delito a editar
        $.ajax({
            url: `/delitos/${id}/edit`,
            type: "GET",
            success: function (response) {
                // Mostrar datos en el formulario de edición
                $('#descripcionDelito').val(response.descripcion);
                $('#agregarDelitoBtn').hide(); // Ocultar botón de agregar
                $('#updateDelitoBtn').show().data('id', id); // Mostrar botón de actualizar con el ID
                $('#cancelUpdateBtn').show(); // Mostrar botón de cancelar
            },
            error: function (response) {
                console.log('Error al obtener los datos del delito:', response);
            }
        });
    });

    // Manejar la actualización de delitos
    $('#updateDelitoBtn').on('click', function () {
        let id = $(this).data('id');
        let descripcion = $('#descripcionDelito').val().trim();

        if (descripcion !== '') {
            $.ajax({
                url: `/delitos/${id}`,
                type: "PUT",
                data: {
                    descripcion: descripcion,
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    // Actualizar la fila del delito en la tabla sin recargar la página
                    $(`#delitoRow${id} td:nth-child(2)`).text(response.descripcion);
                    $(`#delitoSelect option[value='${id}']`).text(response.descripcion);

                    // Resetear formulario
                    $('#descripcionDelito').val('');
                    $('#agregarDelitoBtn').show(); // Mostrar botón de agregar
                    $('#updateDelitoBtn').hide(); // Ocultar botón de actualizar
                    $('#cancelUpdateBtn').hide(); // Ocultar botón de cancelar

                    // Mensaje opcional de éxito
                    alert('Delito actualizado exitosamente.');
                },
                error: function (response) {
                    console.log('Error al actualizar el delito:', response);
                }
            });
        } else {
            alert('La descripción del delito no puede estar vacía.');
        }
    });

    // Manejar la cancelación de la edición
    $('#cancelUpdateBtn').on('click', function () {
        $('#descripcionDelito').val('');
        $('#agregarDelitoBtn').show(); // Mostrar botón de agregar
        $('#updateDelitoBtn').hide(); // Ocultar botón de actualizar
        $('#cancelUpdateBtn').hide(); // Ocultar botón de cancelar
    });

    // Manejar la eliminación de delitos
    $(document).on('click', '.deleteDelitoBtn', function () {
        let id = $(this).data('id');

        if (confirm('¿Estás seguro de que deseas eliminar este delito?')) {
            $.ajax({
                url: `/delitos/${id}`,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    $(`#delitoRow${id}`).remove(); // Eliminar la fila de la tabla
                    $(`#delitoSelect option[value='${id}']`).remove(); // Eliminar del select del modal
                },
                error: function (response) {
                    console.log('Error al eliminar el delito:', response);
                }
            });
        }
    });

    // Manejar la asignación de delito a preso
    $('#presoDelitoForm').on('submit', function (e) {
        e.preventDefault();

        let id_preso = $('#presoSelect').val();
        let id_delito = $('#delitoSelect').val();

        if (id_preso && id_delito) {
            let formData = {
                id_preso: id_preso,
                id_delito: id_delito,
            };

            $.ajax({
                url: "{{ route('preso_delito.store') }}", 
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    alert(response.success); 
                    $('#asignarDelitoModal').modal('hide');
                    $('#presoDelitoForm')[0].reset();
                },
                error: function (response) {
                    console.log('Error al asignar el delito:', response);
                }
            });
        } else {
            alert('Por favor, seleccione un preso y un delito.');
        }
    });

});


</script>
@endsection
