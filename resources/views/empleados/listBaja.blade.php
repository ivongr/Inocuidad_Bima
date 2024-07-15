@extends('layouts.app')
<html lang="es">
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
        @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

        <div class="col-md-9 col-lg-10">
       

            <div class="container mt-4">
                <div class="row">
                    <h2>  <img src="{{ asset('images/listacolor.png') }}"
                        alt="Agregar" style="width: 35px; height: 35px;" />
                        Lista Empleados  Baja</h2>

                    <form class="form-inline" method="get">

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

                        @if ($buscarpor)
                        <input type="hidden" name="pdf" value="1">
                        @endif
                    </form>



                </div>
                <table style="margin-top: 20px;" id="empleadosBajas" class="display" style="width:100% ">
                    <thead  class="text-center">
                        <tr class="text-center">
                            <th>Número de Nómina</th>
                            <th>Nombre Completo</th>

                            <th>Número de Seguridad</th>
                            <th>RFC</th>
                            <th>Área</th>
                            <th>Fecha Baja</th>
                            <th>Historial de Fechas</th> <!-- Nueva columna -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bajas as $baja)
                        <tr class="text-center">
                            <td>{{ $baja->NumNomina }}</td>
                            <td>{{ $baja->nombre_completo }}</td>
                            <td>{{ $baja->NumSeguridad }}</td>
                            <td>{{ $baja->Rfc }}</td>
                            <td>{{ $baja->nombre_area }}</td>
                            <td>{{ $baja->FechaBaja }}</td>
                            <td> <!-- Nueva columna -->
                                <button type="button" class="btn" style="background-color: #ff9c78; color: white;"
                                    data-bs-toggle="modal" data-bs-target="#historialModal{{ $baja->Id }}"><img src="{{ asset('images/historial.png') }}"
                                    alt="Historial" style="width: 40px; height: 40px;" />
                                    Historial
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="historialModal{{ $baja->Id }}" tabindex="-1"
                                    aria-labelledby="historialModalLabel{{ $baja->Id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="historialModalLabel{{ $baja->Id }}">
                                                    Historial de fechas de Bajas y Reingresos</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                            $fechasReingreso = explode(',', $baja->FechasReingreso);
                                                            $fechasBaja = explode(',', $baja->FechasBaja);

                                                            // Obtener el total de fechas para iterar
                                                            $totalFechas = max(count($fechasReingreso), count($fechasBaja));
                                                        @endphp

                                                        {{-- Iterar sobre las fechas --}}
                                                        @for ($i = 0; $i < $totalFechas; $i++)
                                                            <tr>
                                                                {{-- Mostrar la fecha de ingreso solo en la primera fila --}}
                                                                @if ($i === 0)
                                                                    <td rowspan="{{ $totalFechas }}">{{ $baja->FechaIngreso }}</td>
                                                                @endif

                                                                {{-- Mostrar la fecha de baja (si existe) --}}
                                                                <td>{{ isset($fechasBaja[$i]) ? $fechasBaja[$i] : '' }}</td>

                                                                {{-- Mostrar la fecha de reingreso (si existe) --}}
                                                                <td>{{ isset($fechasReingreso[$i]) ? $fechasReingreso[$i] : '' }}</td>
                                                            </tr>
                                                        @endfor
                                                    </tbody>
                                                </table>





                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </td>


                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        {{ $bajas->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </ul>
                </nav>
                <div class="d-flex justify-content-between mt-4">
                    <div>
                        <a href="{{ route('empleados.list') }}" class="btn btn-secondary">Volver</a>
                    </div>

            </div>
            <script>
                $(document).ready(function() {
                    $('#empleadosBajas').DataTable({
                        "language": {
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros"

                        },
                        "lengthMenu": [
                            [5, 10, 15, 25, 50, -1],
                            [6, 10, 15, 25, 50, "All"]
                        ],
                        "pageLength": 5 // Mostrar 6 registros por página por defecto
                    });
                });

            </script>
        </div>
    </div>
    @endsection
