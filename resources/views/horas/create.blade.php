@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('navbar.navbar')
            <div class="col-md-9 col-lg-10">
              
                <div class="container mt-4">
                    <h2>  <img src="{{ asset('images/horasextracolor.png') }}"
                        alt="Agregar" style="width: 35px; height: 35px;" />
                   Registró de Horas Extras</h2>


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

                    <form action="{{ url('/horas') }}" method="post">
                        @csrf
                        <div class="container mt-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Contenido de la primera sección -->
                                    <fieldset>
                                        <legend>Datos Personales</legend>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="horaInicio" class="form-label">Inicio</label>
                                                <input type="time" class="form-control" name="horaInicio" id="horaInicio" value="{{ old('HoraInicio') }}" required onchange="calcularTotalHoras()">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="horaFin" class="form-label">Final</label>
                                                <input type="time" class="form-control" name="horaFin" id="horaFin" value="{{ old('HoraFin') }}" required onchange="calcularTotalHoras()">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="totalHoras" class="form-label">Total de Horas Extras</label>
                                                <input type="text" class="form-control" name="totalHoras" id="totalHoras" value="{{ old('TotalHoras') }}" required readonly>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="fecha" class="form-label">Fecha</label>
                                                <input type="date" class="form-control" name="fecha" id="fecha" value="{{ old('Fecha') }}" required>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <!-- Contenido de la segunda sección -->
                                    <fieldset>
                                        <legend>Ausente</legend>


                                        <textarea id="numNominaTextarea"></textarea>
                                        <legend>Número de Nómina</legend>
                                        <div style="overflow-y: scroll; max-height: 200px;">
                                            @foreach ($empleados as $empleado)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="numNominaSelect[]" id="numNominaSelect{{ $empleado->NumNomina }}" value="{{ $empleado->NumNomina }}" onchange="updateTextarea()">
                                                    <label class="form-check-label" for="numNominaSelect{{ $empleado->NumNomina }}">{{ $empleado->NumNomina }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <!-- Contenido de la tercera sección -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="totalAsistencias" class="form-label">Asistencias (Total Empleados: <span id="totalEmpleados">{{ $totalEmpleados }}</span>)</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <select class="form-select" name="area" id="area" required>
                                                <option value="">Seleccionar área</option>
                                                @foreach ($areas as $area)
                                                    <option value="{{ $area->id }}">{{ $area->Nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <a href="{{ route('horas.view') }}" class="btn btn-secondary">{{ __('Volver') }}</a>
                                    <button type="submit" class="btn btn-success">Guardar</button>
                                </div>
                            </div>
                        </div>


<script>
function updateTextarea() {
    var checkboxes = document.querySelectorAll('input[name="numNominaSelect[]"]');
    var numNominaArray = Array.from(checkboxes).filter(function(checkbox) {
        return checkbox.checked;
    }).map(function(checkbox) {
        return checkbox.value;
    });
    document.getElementById('numNominaTextarea').value = numNominaArray.join(', ');

    // Actualiza el total de empleados restantes en el formulario
    var totalEmpleadosFormulario = parseInt(document.getElementById('totalEmpleadosFormulario').textContent);
    var totalEmpleadosSeleccionados = numNominaArray.length;
    var diferencia = totalEmpleadosSeleccionados - totalEmpleadosFormulario; // Diferencia entre antes y después de la acción

    var nuevoTotal = totalEmpleadosFormulario + diferencia; // Actualiza el total sumando la diferencia
    document.getElementById('totalEmpleadosFormulario').textContent = nuevoTotal;
}

// Llama a la función al cargar la página
updateTextarea();



function getTotalEmpleados() {
    fetch('get-total-empleados')
        .then(response => response.json())
        .then(data => {
            const totalEmpleados = parseInt(data.totalEmpleados);
            if (!isNaN(totalEmpleados)) {
                document.getElementById('totalEmpleados').textContent = totalEmpleados;
                updateTextarea(); // Llama a la función para actualizar el total de empleados seleccionados
            }
        });
}

// Llama a la función al cargar la página
getTotalEmpleados();

function calcularTotalHoras() {
    let horaInicioStr = document.getElementById('horaInicio').value;
    let horaFinStr = document.getElementById('horaFin').value;

    // Agrega la fecha base para construir objetos Date
    let fechaBase = '1970-01-01T';
    let horaInicio = new Date(fechaBase + horaInicioStr);
    let horaFin = new Date(fechaBase + horaFinStr);

    // Verifica si las horas son válidas
    if (isNaN(horaInicio.getTime()) || isNaN(horaFin.getTime())) {
        document.getElementById('totalHoras').value = 'Hora Invalida';
        return;
    }

    // Calcula la diferencia en horas
    let diffTime = Math.abs(horaFin - horaInicio);
    let diffHours = Math.ceil(diffTime / (1000 * 60 * 60));
    document.getElementById('totalHoras').value = diffHours;
}


</script>





@endsection
