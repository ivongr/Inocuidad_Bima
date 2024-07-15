@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('navbar.navbar')
            <div class="col-md-9 col-lg-10">
                <div class="container mt-4">
                    <h2> <img src="{{ asset('images/agregarvacacolor.png') }}" alt="Agregar"
                            style="width: 35px; height: 35px;" />
                        Editar Vacaciones</h2>

                    @if ($errors->any())
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('vacaciones.update', $vacaciones->Id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-5">
                                <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                    <label class="d-block text-center w-100"> <b>Número de Nómina</b></label>
                                </div>
                                <select class="form-select text-center" name="numNomina" id="numNomina" required>
                                    <option value="">Seleccionar número de nómina</option>
                                    @foreach ($empleados as $empleado)
                                        <option value="{{ $empleado->Id }}" {{ $vacaciones->Id_Empleado == $empleado->Id ? 'selected' : '' }}>
                                            {{ $empleado->NumNomina }}
                                        </option>
                                    @endforeach
                                </select>
                                
                                
                            </div>
                        </div>

                        <fieldset>
                            <legend class="text-center"><b>Periodo Vacacional</b></legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Empieza</b></label>
                                    </div>
                                    <input type="date" class="form-control text-center" name="FechaInicio" id="FechaInicio"
                                        value="{{ $vacaciones->FechaInicio }}" required onchange="calcularTotalDias()">
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Termina</b></label>
                                    </div>
                                    <input type="date" class="form-control text-center" name="FechaFin" id="FechaFin"
                                        value="{{ $vacaciones->FechaFin }}" required onchange="calcularTotalDias()">
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Total de Dias</b></label>
                                    </div>
                                    <input type="text" class="form-control" name="TotalDias" id="TotalDias"
                                        value="{{ $vacaciones->TotalDias }}" required readonly>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <br>
                            <div id="infoEmpleado">
                                <legend>Información del empleado</legend>
                            </div>
                        </fieldset>
                        <br>
                        <div class="row mt-4  text-center">
                            <div class="col-md-12">
                                <a href="{{ route('vacaciones.view') }}" class="btn btn-secondary mx-4">{{ __('Volver') }}</a>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
       
 document.getElementById('numNomina').addEventListener('change', function() {
    var numNomina = this.value;
    if (numNomina !== '') {
        // Realizar una solicitud AJAX para obtener los datos del empleado
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Actualizar el contenido del div con id infoEmpleado con los datos del empleado
                var empleado = JSON.parse(this.responseText);
                document.getElementById('infoEmpleado').innerHTML = `
                    <p>Nombre: ${empleado.Nombre} ${empleado.ApePat} ${empleado.ApeMat}</p>

                    <p>Número de Seguridad: ${empleado.NumSeguridad}</p>
                    <p>RFC: ${empleado.Rfc}</p>
                    <p>Fecha de Ingreso: ${empleado.FechaIngreso}</p>
                `;
            }
        };
        xhttp.open('GET', '{{ route('getEmpleadoInfo') }}?numNomina=' + numNomina, true);
        xhttp.send();
    } else {
        // Limpiar el contenido del div infoEmpleado si no se ha seleccionado ningún número de nómina
        document.getElementById('infoEmpleado').innerHTML = '';
    }
});
function calcularTotalDias() {
        let fechaInicio = new Date(document.getElementById('FechaInicio').value);
        let fechaFin = new Date(document.getElementById('FechaFin').value);
    // Sumar 1 para incluir el día final en el cálculo
        let diffTime = Math.abs(fechaFin - fechaInicio) + (1000 * 60 * 60 * 24);
        let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        document.getElementById('TotalDias').value = diffDays;
    }
    </script>

    
@endsection
