@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('navbar.navbar')
            <div class="col-md-9 col-lg-10">
                <style>
                    .custom-bg-warning {
                    background-color: #FFF3CD; /* Color de fondo amarillo */
                    color: #664D03; /* Color de texto oscuro */
                }
                    .text-info-emphasis {
                    background-color: #CFF4FC; /* Color de fondo amarillo */
                    color: #055160; /* Color de texto oscuro */
                }
                </style>
                <div class="container mt-4">
                    <h2><img src="{{ asset('images/salidascolor.png') }}" alt="Agregar" style="width: 35px; height: 35px;" />
                        <b>Registro de Salidas </b> </h2>

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

                    <form action="{{ url('/storeHorasSalidas') }}" method="post">
                        @csrf
                        <div class="container mt-4">
                            <div class="row">
                                <div class="col-md-4">
                                    <!-- Contenido de la primera sección -->
                                    <fieldset>
                                        <legend><strong>Horas</strong></legend>
                                        <div class="mb-2 custom-bg-warning">
                                        <label class="d-block text-center w-100"> <b>Número de Salida</b></label>
                                    </div>
                                        <select class="form-select" name="numSalida" id="numSalida" required>
                                            <option value="">Seleccionar Número de Salida</option>
                                            @foreach ($numSalida as $id => $nombre)
                                                <option value="{{ $id }}">{{ $nombre }}</option>
                                            @endforeach
                                        </select>

<br>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-2 custom-bg-warning justify-content-center text-center">
                                                    <label for="HoraSalida" class="form-label"><strong>Hora de Salida</strong></label>
                                                </div>
                                                <input type="time" class="form-control" name="HoraSalida" id="HoraSalida" value="{{ old('HoraSalida') }}">
                                            </div>
                                        </div>



<br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-2 custom-bg-warning d-flex align-items-center justify-content-center">
                                                    <label for="Fecha" class="form-label text-center"><strong>Fecha</strong></label>
                                                </div>
                                                <input type="date" class="form-control" name="Fecha" id="Fecha" value="{{ old('Fecha') }}" required>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                <div class="col-md-4">
                                    <!-- Contenido de la segunda sección -->
                                    <fieldset>


                                        <legend class="text-center">  <b>Empleados  </b></legend>

                                    <br>
                                    <div class="mb-2 custom-bg-warning">
                                        <label  class="d-block text-center w-80">
                                            <b>Ausentes</b></label>

                                    </div>

                                    <textarea id="numNominaTextarea" cols="38"  readonly></textarea>
                                    <br>
                                    <div class="mb-2 custom-bg-warning">
                                        <label class="d-block text-center w-100">
                                            <b>Áreas</b></label>

                                    </div>

                                    <div style="overflow-y: scroll; max-height: 200px;">
                                        <select class="form-select" name="area" id="area" required
                                            onchange="updateNumNominaList()">
                                            <option value="">Seleccionar área</option>
                                            @foreach ($areas as $id => $nombre)
                                                <option value="{{ $id }}">{{ $nombre }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                    <br>
                                    <div class="mb-2 custom-bg-warning">
                                        <label for="buscadorNomina" class="d-block text-center w-100"><b>Buscar Nómina</b></label>
                                    </div>
                                    <input type="text" class="form-control" id="buscadorNomina" onkeyup="buscarNomina()" placeholder="Buscar por Nómina">

                                    <div id="numNominaList"></div>
                                </fieldset>
                                </div>
                                <div class="col-md-4" >
                                    <br>
                                    <br>
                                    <!-- Contenido de la tercera sección -->
                                    <div class="row p-3 mb-2 bg-info-subtle text-info-emphasis">
                                        <div class="col-md-12">
                                            <label for="totalEmpleados" class="form-label"> <b>(Total Empleados: <span
                                                    id="totalEmpleados">{{ $totalEmpleados }}</span>)</b></label>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="numAusencias" class="form-label"> <b>Ausencias (Total Empleados: <span
                                                    id="numAusencias">{{ $numAusencias }}</span>)</b></label>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="totalAsistencias"  class="form-label"> <b>  <span
                                                id="labelTotalAsistencias">{{ $numAusencias }}</b> </label>
                                            <input type="hidden" name="totalAsistencias" id="totalAsistencias"
                                                value="{{ $numAusencias }}">
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
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

function buscarNomina() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById('buscadorNomina');
        filter = input.value.toUpperCase();
        ul = document.getElementById('numNominaList');
        li = ul.getElementsByTagName('div');
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByTagName('label')[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = '';
            } else {
                li[i].style.display = 'none';
            }
        }
    }
        // Funciones JavaScript necesarias
        function updateNumNominaList() {
            var areaId = document.getElementById('area').value;

            var numNominaList = document.getElementById('numNominaList');
            numNominaList.innerHTML = ''; // Limpiar contenido anterior

            // Filtrar empleados por área seleccionada
            var empleados = @json($empleados);
            var empleadosFiltrados = empleados.filter(function(empleado) {
                return empleado.Id_Area == areaId;
            });

            // Agregar checkboxes para los empleados filtrados
            empleadosFiltrados.forEach(function(empleado) {
                var checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.name = 'numNominaSelect[]';
                checkbox.id = 'numNominaSelect' + empleado.NumNomina;
                checkbox.value = empleado.NumNomina;
                checkbox.addEventListener('change', updateTextarea);

                var label = document.createElement('label');
                label.htmlFor = 'numNominaSelect' + empleado.NumNomina;
                label.textContent = empleado.NumNomina;

                var div = document.createElement('div');
                div.classList.add('form-check');
                div.appendChild(checkbox);
                div.appendChild(label);

                numNominaList.appendChild(div);
            });
        }

        function updateTextarea() {
            var checkboxes = document.querySelectorAll('input[name="numNominaSelect[]"]:checked');
            var numNominaArray = Array.from(checkboxes).map(function(checkbox) {
                return checkbox.value;
            });
            document.getElementById('numNominaTextarea').value = numNominaArray.join(', ');

            var areaId = document.getElementById('area').value;
            var empleados = @json($empleados);
            var totalEmpleadosArea = empleados.filter(function(empleado) {
                return empleado.Id_Area == areaId;
            }).length;

            var totalEmpleadosGeneral = empleados.length;

            var ausencias = empleados.reduce(function(acc, empleado) {
                if (empleado.Id_Area == areaId && numNominaArray.includes(empleado.NumNomina.toString())) {
                    acc++;
                }
                return acc;
            }, 0);

            var asistencias = totalEmpleadosArea - ausencias;

            document.getElementById('totalEmpleados').textContent = totalEmpleadosGeneral;
            document.getElementById('numAusencias').textContent = ausencias;
            document.getElementById('labelTotalAsistencias').textContent = 'Asistencias (Total de Empleados Hoy: ' +
                asistencias + ')';
            document.getElementById('totalAsistencias').value = asistencias;
        }



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

        // Llama a la función al cargar la página
        updateTextarea();


    </script>
@endsection
