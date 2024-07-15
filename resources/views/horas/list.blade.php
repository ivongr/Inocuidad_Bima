@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- CSS de Bootstrap (CDN) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- JavaScript de Bootstrap (CDN) y dependencias -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

        <div class="row">
            @include('navbar.navbar')
            <div class="col-md-9 col-lg-10">

                <div class="container mt-4">
                    <div class="row">
                        <h2><img src="{{ asset('images/listacolor.png') }}" alt="Agregar"
                                style="width: 35px; height: 35px;" /> Lista Horas</h2>

                        <form action="{{ route('horas.list') }}" method="GET">
                            <div class="row row-cols-1 row-cols-lg-5 g-2 g-lg-3">
                                <div class="col-md-6">
                                    <select class="form-control" id="area" name="area">
                                        <option value="">Seleccionar Área</option>
                                        @foreach ($areas as $id => $nombre)
                                            <option value="{{ $id }}" {{ $buscarpor == $id ? 'selected' : '' }}>
                                                {{ $nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="date" class="form-control" id="fecha" name="fecha"
                                        value="{{ $fecha }}">
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-outline-success me-2" type="submit">Buscar</button>
                                        <a href="{{ route('horas.list') }}" class="btn btn-outline-warning">Restablecer</a>
                                    </div>
                                </div>
                            </div>
                            <br>

                            <div class="d-flex justify-content-end">
                                <style>
                                    .btn-custom {
                                        padding: 0.375rem 0.75rem;
                                        font-size: 1rem;
                                        line-height: 1.5;
                                        border-radius: 0.25rem;
                                    }

                                    .btn-custom img {
                                        width: 1.5em;
                                        height: 1.5em;
                                    }
                                </style>
                                @if ($buscarpor || $fecha)
                                    <a href="{{ route('exportHorasArea', ['area' => $buscarpor, 'fecha' => $fecha]) }}"
                                        class="btn btn-success btn-custom me-2" style="background: #22C55E">
                                    @else
                                        <a href="{{ route('exportHorasArea', ['fecha' => $fecha]) }}"
                                            class="btn btn-success btn-custom me-2" style="background: #22C55E">
                                @endif
                                <img src="{{ asset('images/excel.png') }}" class="me-2"> Exportar a Excel
                                </a>

                                @if ($buscarpor || $fecha)
                                    <a href="{{ route('imprimirHorasArea.pdf', ['area' => $buscarpor, 'fecha' => $fecha]) }}"
                                        class="btn btn-danger btn-custom me-2" style="background: #EF4444">
                                    @else
                                        <a href="{{ route('imprimirHoras.pdf') }}" class="btn btn-danger btn-custom me-2"
                                            style="background: #EF4444">
                                @endif
                                <img src="{{ asset('images/pdf.png') }}" class="me-2"> Exportar a PDF
                                </a>
                            </div>
                        </form>
                        <!-- Botón para eliminar todos los registros filtrados, solo si hay filtros aplicados -->
                        @if ($buscarpor || $fecha)
                        <div class="d-flex justify-content-end mt-3">
                            <button class="btn btn-danger" onclick="openConfirmDeleteAllModal()">Eliminar Todos</button>
                        </div>
                    @endif
                    </div>
                    <br>
                    <table style="margin-top: 20px;" id="horas" class="display" style="width:100%">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th>Id</th>
                                <th>Número de Nómina</th>
                                <th>Fecha</th>
                                <th>Día</th>
                                <th>Nombre Completo</th>
                                <th>Hora de Entrada</th>
                                <th>Hora de Salida</th>
                                <th>Hora de Entrada</th>
                                <th>Hora de Salida</th>
                                <th>Horas Extras</th>
                                <th>Total De Horas Laboradas</th>
                                <th>Área</th>
                                <th>Descripción</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($empleados as $empleado)
                                <tr class="text-center">
                                    <td>{{ $empleado->Id }}</td>
                                    <td>{{ $empleado->NumNomina }}</td>
                                    <td>{{ $empleado->Fecha }}</td>
                                    <td>
                                        @php
                                            $dias = [
                                                'Sunday' => 'Domingo',
                                                'Monday' => 'Lunes',
                                                'Tuesday' => 'Martes',
                                                'Wednesday' => 'Miércoles',
                                                'Thursday' => 'Jueves',
                                                'Friday' => 'Viernes',
                                                'Saturday' => 'Sábado',
                                            ];
                                            $diaSemana = date('l', strtotime($empleado->Fecha));
                                            echo $dias[$diaSemana];
                                        @endphp
                                    </td>
                                    <td>{{ $empleado->NombreCompleto }}</td>
                                    <td>{{ $empleado->{'Hora de Entrada 1'} }}</td>
                                    <td>{{ $empleado->{'Hora de Salida 1'} }}</td>
                                    <td>{{ $empleado->{'Hora de Entrada 2'} }}</td>
                                    <td>{{ $empleado->{'Hora de Salida 2'} }}</td>
                                    <td>{{ $empleado->{'Horas Extras'} }}</td>
                                    <td>{{ intval($empleado->{'Total De Horas Laboradas'}) }}</td>
                                    <td>{{ $empleado->Área }}</td>
                                    <td>{{ $empleado->Estado }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger"
                                            onclick="openConfirmDeleteModal('{{ $empleado->NumNomina }}', '{{ $empleado->Fecha }}')">Eliminar</button>
                                        <form id="formEliminar{{ $empleado->NumNomina }}"
                                            action="{{ route('eliminar.registro', ['numNomina' => $empleado->NumNomina, 'fecha' => $empleado->Fecha]) }}"
                                            method="POST" style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <a href="{{ route('horas.view') }}" class="btn btn-secondary">Volver</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para confirmar la eliminación de un registro -->
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ¿Estás seguro de que deseas eliminar este registro?
                        </div>
                        <br> Esta acción <strong>eliminará todos</strong> los registros
                        relacionados de forma permanente.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteButton">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de confirmación de eliminación de todos los registros -->
        <div class="modal fade" id="confirmDeleteAllModal" tabindex="-1" aria-labelledby="confirmDeleteAllModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteAllModalLabel">Confirmar Eliminación de Todos los
                            Registros</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center">
                            <img src="{{ asset('images/advertencia.png') }}" alt="Agregar"
                                style="width: 130px; height: 130px;" />
                        </div>
                        <br> ¿Estás seguro de que deseas eliminar todos los registros filtrados?

                        <br> Esta acción <strong>eliminará todos</strong> los registros
                        relacionados de forma permanente.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <form id="formEliminarTodos" action="{{ route('eliminar.todos') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="area" id="modalArea">
                            <input type="hidden" name="fecha" id="modalFecha">
                            <button type="submit" class="btn btn-danger">Eliminar Todos</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Inicializar DataTables
            $(document).ready(function() {
                $('#horas').DataTable({
                    "order": [
                        [0, "desc"]
                    ],
                    "lengthMenu": [
                        [5, 10, 25, 50, -1],
                        [5, 10, 25, 50, "Todos"]
                    ],
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
                    }
                });
            });

            // Función para abrir el modal de confirmación de eliminación de un registro
            function openConfirmDeleteModal(numNomina, fecha) {
                $('#confirmDeleteModal').modal('show');
                $('#confirmDeleteButton').off('click').on('click', function() {
                    $('#formEliminar' + numNomina + fecha).submit();
                });
            }

            // Función para abrir el modal de confirmación de eliminación de todos los registros
            function openConfirmDeleteAllModal() {
                // Obtener los valores de área y fecha seleccionados en el formulario de filtros
                var area = $('#area').val();
                var fecha = $('#fecha').val();

                // Asignar los valores a los campos ocultos en el formulario del modal
                $('#modalArea').val(area);
                $('#modalFecha').val(fecha);

                // Mostrar el modal de confirmación
                $('#confirmDeleteAllModal').modal('show');
            }
        </script>
    </div>
@endsection
