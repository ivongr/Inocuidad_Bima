@extends('layouts.app')
<html lang="es">
@section('content')
    <div class="container">


        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <div class="row">
            @include('navbar.navbar')
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif


            <div class="col-md-9 col-lg-10">


                <div class="container mt-4">
                    <div class="row">
                        <h2> <img src="{{ asset('images/listacolor.png') }}" alt="Agregar"
                                style="width: 55px; height: 55px;" /> Lista Empleados Activos</h2>

                        <form class="form-inline" method="get">
                            <div class="row row-cols-1 row-cols-lg-5 g-2 g-lg-3">

                                <div class="input-group">
                                    <select name="buscarpor" class="form-control form-select-sm mr-sm-6 w-80">
                                        <option value="">Restablecer</option>
                                        @foreach ($areas as $id => $nombre)
                                            <option value="{{ $id }}" {{ $buscarpor == $id ? 'selected' : '' }}>
                                                {{ $nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <style>
                                    .btn-custom {
                                        padding: 0.375rem 0.75rem;
                                        /* Ajusta el padding para cambiar el tamaño del botón */
                                        font-size: 1rem;
                                        /* Ajusta el tamaño de la fuente */
                                        line-height: 1.5;
                                        /* Ajusta el espacio entre líneas */
                                        border-radius: 0.25rem;
                                        /* Ajusta el radio de las esquinas del botón */
                                    }

                                    .btn-custom img {
                                        width: 1.5em;
                                        /* Ajusta el tamaño de la imagen dentro del botón */
                                        height: 1.5em;
                                    }
                                </style>
                                <a href="{{ route('empleados.listBaja') }}"
                                    class="link-success link-underline-success link-underline-opacity-25">
                                    <img src="{{ asset('images/bajacolor.png') }}" alt="Agregar"
                                        style="width: 50px; height: 50px;" /> Lista Baja Empleados
                                </a>

                                <div class="d-flex justify-content-end">


                                    @if ($buscarpor)
                                        <a href="{{ route('exportArea', ['buscarpor' => $buscarpor]) }}"
                                            class="btn btn-success btn-custom me-2" style="background: #22C55E">
                                            <img src="{{ asset('images/excel.png') }}" class="me-2"> Exportar a Excel
                                        </a>
                                    @else
                                        <a href="/exportarEmpleados" class="btn btn-success btn-custom me-2"
                                            style="background: #22C55E">
                                            <img src="{{ asset('images/excel.png') }}" class="me-2"> Exportar a Excel
                                        </a>
                                    @endif

                                    <a href="{{ route('imprimir.pdf', ['buscarpor' => $buscarpor]) }}"
                                        class="btn btn-danger btn-custom me-2" style="background: #EF4444">
                                        <img src="{{ asset('images/pdf.png') }}" class="me-2"> Exportar a PDF
                                    </a>
                                </div>
                            </div>
                        </form>



                    </div>
                    <br>
                    <table style="margin-top: 20px;" id="empleadosActivos" class="display" style="width:100% ">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th>Id</th>
                                <th>Número de Nómina</th>
                                <th>Nombre Completo</th>
                                <th>Número de Seguridad</th>
                                <th>RFC</th>
                                <th>Área</th>
                                <th>Fecha de ingreso</th>
                                <th>Historial de Fechas</th> <!-- Nueva columna -->
                                <th>Actualizar</th> <!-- Nueva columna -->
                                <th>Eliminar</th> <!-- Nueva columna -->
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @foreach ($empleados as $empleado)
                                <tr class="text-center">
                                    <td>{{ $empleado->Id }}</td>
                                    <td>{{ $empleado->NumNomina }}</td>
                                    <td>{{ $empleado->nombre_completo }}</td>
                                    <td>{{ $empleado->NumSeguridad }}</td>
                                    <td>{{ $empleado->Rfc }}</td>
                                    <td>{{ $empleado->nombre_area }}</td>
                                    <td>{{ $empleado->FechaUltimoReingreso }}</td>


                                    <td> <!-- Nueva columna -->
                                        <button type="button" class="btn"
                                            style="background-color: #ff9c78; color: white;" data-bs-toggle="modal"
                                            data-bs-target="#historialModal{{ $empleado->Id }}"><img
                                                src="{{ asset('images/historial.png') }}" alt="Historial"
                                                style="width: 40px; height: 40px;" />
                                            Historial
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="historialModal{{ $empleado->Id }}" tabindex="-1"
                                            aria-labelledby="historialModalLabel{{ $empleado->Id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="historialModalLabel{{ $empleado->Id }}">
                                                            Historial de fechas de Bajas y Reingresos</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table>
                                                            <thead class="text-center">
                                                                <tr>
                                                                    <th>Fecha de Ingreso</th>
                                                                    <th>Fecha de Baja</th>
                                                                    <th>Fecha de Reingreso</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="text-center">
                                                                {{-- Convertir las cadenas de fechas en arrays --}}
                                                                @php
                                                                    $fechasReingreso = explode(
                                                                        ',',
                                                                        $empleado->FechasReingreso,
                                                                    );
                                                                    $fechasBaja = explode(',', $empleado->FechasBaja);

                                                                    // Obtener el total de fechas para iterar
                                                                    $totalFechas = max(
                                                                        count($fechasReingreso),
                                                                        count($fechasBaja),
                                                                    );
                                                                @endphp

                                                                {{-- Iterar sobre las fechas --}}
                                                                @for ($i = 0; $i < $totalFechas; $i++)
                                                                    <tr>
                                                                        {{-- Mostrar la fecha de ingreso solo en la primera fila --}}
                                                                        @if ($i === 0)
                                                                            <td rowspan="{{ $totalFechas }}">
                                                                                {{ $empleado->FechaIngreso }}</td>
                                                                        @endif

                                                                        {{-- Mostrar la fecha de baja (si existe) --}}
                                                                        <td>{{ isset($fechasBaja[$i]) ? $fechasBaja[$i] : '' }}
                                                                        </td>

                                                                        {{-- Mostrar la fecha de reingreso (si existe) --}}
                                                                        <td>{{ isset($fechasReingreso[$i]) ? $fechasReingreso[$i] : '' }}
                                                                        </td>
                                                                    </tr>
                                                                @endfor
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td> <a href="{{ route('empleados.edit', ['Id' => $empleado->Id]) }}"
                                            class="btn btn-warning text-white">Actualizar</a></td>
                                    <td>
                                        <button type="button" class="btn btn-danger"
                                            onclick="confirmDelete({{ $empleado->Id }})">
                                            Eliminar
                                        </button>
                                    </td>
                                    <!-- Modal de confirmación de eliminación -->
                                    <div class="modal fade" id="confirmDeleteModal{{ $empleado->Id }}" tabindex="-1"
                                        role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmación de
                                                        Eliminación</h5>

                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <img src="{{ asset('images/advertencia.png') }}" alt="Agregar"
                                                            style="width: 130px; height: 130px;" />

                                                    </div>
                                                    <br>
                                                    <div class="text-center">
                                                        <h4> ¿Estás seguro de que deseas eliminar este empleado?</h4>
                                                    </div>
                                                    <br> Esta acción <strong>eliminará todos</strong> los registros
                                                    relacionados de forma permanente.
                                                </div>
                                                <div class="modal-footer">

                                                    <form action="{{ route('empleados.destroy', $empleado->Id) }}"
                                                        method="POST" id="deleteForm{{ $empleado->Id }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <a href="{{ route('empleados.view') }}" class="btn btn-secondary">Volver</a>
                        </div>
                    </div>



                </div>

            </div>
            <script>
                $(document).ready(function() {
                    $('#empleadosActivos').DataTable({
                        "language": {
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros"
                        },
                        "lengthMenu": [
                            [5, 10, 15, 25, 50, -1],
                            [5, 10, 15, 25, 50, "All"]
                        ],
                        "pageLength": 5, // Mostrar 6 registros por página por defecto
                        "columnDefs": [{
                            "targets": 0, // Índice de la columna a ocultar (0-indexed)
                            "visible": false // Ocultar la columna
                        }]
                    });
                });

                function confirmDelete(id) {
                    $('#confirmDeleteModal' + id).modal('show');
                }
            </script>
        </div>
    @endsection
