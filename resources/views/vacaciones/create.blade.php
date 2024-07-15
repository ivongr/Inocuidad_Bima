@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('navbar.navbar')
            <div class="col-md-9 col-lg-10">
                
                <div class="container mt-4">
                    <h2> <img src="{{ asset('images/agregarvacacolor.png') }}" alt="Agregar"
                            style="width: 35px; height: 35px;" />
                        Vacaciones</h2>

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

                    <form action="{{ url('vacaciones') }}" method="post">
                        @csrf

                        <fieldset>


                            <div class="row">
                                <div class="col-md-5">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Número</b></label>
                                    </div>
                                    <select class="form-select text-center" name="numNomina" id="numNomina" required>
                                        <option value="">Seleccionar número de nómina</option>
                                        @foreach ($empleados as $id => $NumNomina)
                                            <option value="{{ $id }}">{{ $NumNomina }}</option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>

                        </fieldset>
                        <fieldset>
                            <legend class="text-center"><b>Periodo Vacacional</b></legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Empieza</b></label>
                                    </div>
                                    <input type="date" class="form-control text-center" name="FechaInicio" id="FechaInicio"
                                        value="{{ old('FechaInicio') }}" required onchange="calcularTotalDias()">
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Termina</b></label>
                                    </div>
                                    <input type="date" class="form-control text-center" name="FechaFin" id="FechaFin"
                                        value="{{ old('FechaFin') }}" required onchange="calcularTotalDias()">
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Total de Dias</b></label>
                                    </div>
                                    <input type="text" class="form-control" name="TotalDias" id="TotalDias" value="{{ old('TotalDias') }}"
                                        required readonly>
                                </div>
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
       /* function calcularTotalDias() {
            let fechaInicio = new Date(document.getElementById('FechaInicio').value);
            let fechaFin = new Date(document.getElementById('FechaFin').value);
            let diffTime = Math.abs(fechaFin - fechaInicio);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            document.getElementById('TotalDias').value = diffDays;
        }*/

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
