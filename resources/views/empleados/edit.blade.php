@extends('layouts.app')

@section('content')
<div class="container">

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
                <h2> <img src="{{ asset('images/editar.png') }}"
                        alt="Agregar" style="width: 55px; height: 55px;" /> Editar Empleado</h2>

        
            <!-- PARA PONER LAS ALERTAS EN EL FORMULARIO  -->

            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <ul>
                        <!--QUE IMPRIMA UNA LISTA DE LOS ERRORES-->
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('empleados.update', $empleado->Id) }}" method="post"  enctype="multipart/form-data">
                <input type="hidden" name="Id" value="{{ $empleado->Id }}">

                @csrf
                @method('PUT')
                <div class="mb-3 row">
                    <label for="NumNomina" class="col-sm-2 col-form-label">Número de Nómina:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="NumNomina" id="NumNomina"
                            value="{{ $empleado->NumNomina }}" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="Nombre" class="col-sm-2 col-form-label">Nombre:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="Nombre" id="Nombre" value="{{ $empleado->Nombre }}"
                            required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="ApePat" class="col-sm-2 col-form-label">Apellido Paterno:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="ApePat" id="ApePat" value="{{ $empleado->ApePat }}"
                            required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="ApeMat" class="col-sm-2 col-form-label">Apellido Materno:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="ApeMat" id="ApeMat"
                            value="{{ $empleado->ApeMat}}" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="NumSeguridad" class="col-sm-2 col-form-label">Número de Seguridad:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="NumSeguridad" id="NumSeguridad"
                            value="{{ $empleado->NumSeguridad}}">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="Rfc" class="col-sm-2 col-form-label">RFC:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="Rfc" id="Rfc"
                            value="{{ $empleado->Rfc}}">
                    </div>
                </div>

                <!-- SELECT -->
                <!-- SELECT -->
<div class="mb-3 row">
    <label for="area" class="col-sm-2 col-form-label">Área:</label>
    <div class="col-sm-5">
        <select class="form-select" name="area" id="area" required>
            <option value="">Seleccionar área</option>
            @foreach ($areas as $area)
                <option value="{{ $area->Id }}" @if($empleado->area->Id == $area->Id) {{ 'selected' }} @endif>{{ $area->Nombre }}</option>
            @endforeach
        </select>
        
    </div>
</div>


                <div class="mb-3 row">
                    <label for="fechaingreso" class="col-sm-2 col-form-label">Fecha de Ingreso:</label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" name="fechaingreso" id="fechaingreso"
                            value="{{$empleado->FechaIngreso}}">
                    </div>
                </div>
<div class="text-center">
                <a href="{{ route('empleados.view') }}" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-success ml-3">Guardar</button>

            </div>
            </form>
        </div>
    </main>
@endsection
