@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Dar de baja a un empleado</h1>
        @if(isset($empleado))
            <div>
                <h2>Información del Empleado</h2>
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>Número de Nómina:</th>
                            <td>{{ $empleado->NumNomina }}</td>
                        </tr>
                        <!-- Agregar más detalles del empleado aquí -->
                    </tbody>
                </table>
            </div>
            <form action="{{ route('empleados.darDeBaja', ['NumNomina' => $empleado->NumNomina]) }}" method="POST">
                @csrf
                @method('POST')
                <label for="fechaBaja">Fecha de Baja:</label>
                <input type="date" name="fechaBaja" id="fechaBaja" required>

                <button type="submit" class="btn btn-warning">Dar de baja</button>
            </form>
        @endif
    </div>
@endsection
