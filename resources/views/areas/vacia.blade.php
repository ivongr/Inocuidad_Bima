@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('navbar.navbar')

            <div class="col-md-9 col-lg-10">

                <div class="container mt-4">
                    <div class="row ">
                        <form class="form-inline my-2 my-lg-0 float-right">
                            <label class="form-label">Seleccionar una Área</label>
                            <select name="buscarpor" class="form-control mr-sm-2">

                                <option value="">Restablecer</option>
                                @foreach($areas as $id => $nombre)
                                    <option value="{{ $id }}" {{ $buscarpor == $id ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                        </form>

                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>NumNomina</th>
                                <th>Nombre</th>
                                <th>Apellido Paterno</th>
                                <th>Apellido Materno</th>
                                <th>Número de Seguirdad</th>
                                <th>RFC</th>
                                <th>Área</th>
                                <th>Fecha de ingreso</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($empleados as $empleado)
                                <tr>
                                    <td>{{ $empleado->NumNomina}}</td>
                                    <td>{{ $empleado->Nombre}}</td>
                                    <td>{{ $empleado->ApePat }}</td>
                                    <td>{{ $empleado->ApeMat }}</td>
                                    <td>{{ $empleado->NumSeguridad }}</td>
                                    <td>{{ $empleado->Rfc }}</td>
                                    <td>{{ $empleado->area->Nombre}}</td>


                                    <td>{{ $empleado->fechaingreso }}</td>
                                    <!--concatenar el ID-->
                                    <td>
                                        <a href="{{ url('empleados/' . $empleado->id . '/edit') }}"
                                            class="btn btn-warning btn-sm">Editar</a>
                                        </td>
                                    <td>
                                        <form action="{{ url('empleados/' . $empleado->id) }}" method="post">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
                <a href="{{ route('empleados.view') }}" class="btn btn-secondary">Regresar</a>
            </div>

        </div>
    </div>
@endsection
