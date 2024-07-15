@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Empleado dado de baja</h1>
        @if(isset($empleado))
            <div class="alert alert-success" role="alert">
                El empleado con número de nómina {{ $empleado->NumNomina }} ha sido dado de baja correctamente.
            </div>
            <table id="tabla-empleado" class="table table-hover">
                <label for="numNomina" class="form-label fs-4"><b>Información del Empleado</b></label>
                <tbody>
                    <tr>
                        <th>Número de Nómina:</th>
                        <td id="numNominaInfo">{{ $empleado->NumNomina }}</td>
                    </tr>
                    <tr>
                        <th>Fecha baja:</th>
                        <td>{{ $empleado->FechaBaja ? $empleado->FechaBaja->format('Y-m-d') : 'Sin fecha de baja' }}</td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
@endsection
