@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('navbar.navbar')

            <div class="col-md-9 col-lg-10">
               
                <div class="container mt-4">

                    <div class="container">
                        <div class="row">
                            <h2>  <img src="{{ asset('images/volvercolor.png') }}"
                                alt="Agregar" style="width: 35px; height: 35px;" />
                                <b>ReIngreso Empleados</b></h2>
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
                            <form action="{{ url('/storeReIngreso') }}" method="post">
                                @csrf

                                <fieldset>


                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                                <label class="d-block text-center w-100"> <b>Número de ReIngreso</b></label>
                                            </div>
                                            <select class="form-select" name="numReIngreso" id="numReIngreso" required>
                                                <option value="">Seleccionar</option>
                                                @foreach ($numReIngreso as $id => $Nombre)
                                                    <option value="{{ $id }}">{{ $Nombre }}</option>
                                                @endforeach
                                            </select>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                                <label class="d-block text-center w-100"> <b>Número de Nómina</b></label>
                                            </div>
                                            <select class="form-select" name="numNomina" id="Id_empleado" required>
                                                <option value="">Seleccionar empleado</option>
                                                @foreach ($empleados as $id => $NumNomina)
                                            <option value="{{ $id }}">{{ $NumNomina }}</option>
                                        @endforeach
                                            </select>

                                        </div>


                                        <div class="col-md-3">

                                            <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                                <label class="d-block text-center w-100"> <b>Fecha de ReIngreso</b></label>
                                            </div>
                                            <input type="date" class="form-control text-center" name="FechaReIngreso" id="FechaReIngreso"
                                                value="{{ old('FechaReIngreso') }}" required>
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
                        <a href="{{ route('empleados.view') }}" class="btn btn-secondary mx-4">{{ __('Volver') }}</a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
                </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('Id_empleado').addEventListener('change', function() {
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



               </script>
    </div>


@endsection
