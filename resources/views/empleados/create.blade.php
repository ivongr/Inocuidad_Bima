@extends('layouts.app')

@section('content')
    <div class="container">


        <div class="row">
            @include('navbar.navbar')
            <div class="col-md-9 col-lg-10">
                <div class="container mt-4">
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                    <h2> <img src="{{ asset('images/agregarcolor.png') }}" alt="Agregar" style="width: 35px; height: 35px;" />
                        <b> Alta Empleado</b>
                    </h2>

                    <!---COMENTAR EN UNA PLANTILLA BLADE--->
                    {{-- @if ($errors->any()) --}}
                    {{--    <div class="alert alert-danger alert-dismissible fade show" role="alert"> --}}
                    {{--        <ul> --}}
                    {{--            @foreach ($errors->all() as $error) --}}
                    {{--                <li>{{ $error }}</li> --}}
                    {{--            @endforeach --}}
                    {{--        </ul> --}}
                    {{--    </div> --}}
                    {{-- @endif --}}


                    <form action="{{ url('empleados') }}" method="post">
                        @csrf

                        <fieldset>
                            <legend class="text-center"><b>Datos Personales</b></legend>

                            <div class="row">
                                <div class="col-md-4">

                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Número de Nómina</b></label>
                                    </div>
                                    <input type="text" class="form-control" name="numNomina" id="numNomina"
                                        value="{{ old('NumNomina') }}" required>
                                    @error('numNomina')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Nombre</b></label>
                                    </div>
                                    <input type="text" class="form-control" name="Nombre" id="Nombre"
                                        value="{{ old('Nombre') }}" required>
                                        @error('Nombre')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Apellido Paterno</b></label>
                                    </div>
                                    <!--old es de acuerdo al nombre de la base de datos-->
                                    <input type="text" class="form-control" name="ApePat" id="ApePat"
                                        value="{{ old('ApePat') }}" required>
                                        @error('ApePat')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <br>
                                </div>

                                <div class="col-md-4">

                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">

                                        <label class="d-block text-center w-100"> <b>Apellido Materno</b></label>
                                    </div>
                                    <input type="text" class="form-control" name="ApeMat" id="ApeMat"
                                        value="{{ old('ApeMat') }}" required>
                                        @error('ApeMat')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Número de Seguridad</b></label>
                                    </div>
                                    <input type="text" class="form-control" name="NumSeguridad" id="NumSeguridad"
                                        value="{{ old('NumSeguridad') }}" required>
                                        @error('NumSeguridad')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>RFC</b></label>
                                    </div>
                                    <input type="text" class="form-control" name="Rfc" id="Rfc"
                                        value="{{ old('Rfc') }}" required>
                                        @error('Rfc')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <br>


                            <div class="row">

                                <br>

                                <div class="col-md-5">
                                    <div class="mb-3 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Área</b></label>
                                    </div>
                                    <select class="form-select text-center" name="area" id="area" required>
                                        <option value="">Seleccionar área</option>
                                        @foreach ($areas as $id => $nombre)
                                            <option value="{{ $id }}">{{ $nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-md-5">
                                    <div class="mb-3 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Fecha de Ingreso</b></label>
                                    </div>
                                    <input type="date" class="form-control text-center" name="fechaingreso"
                                        id="fechaingreso" value="{{ old('fechaingreso') }}" required>
                                </div>

                            </div>
                            <br>
                        </fieldset>



                        <br>
                        <div class="row mt-4  text-center">
                            <div class="col-md-12">
                                <a
                                    href="{{ route('empleados.view') }}"class="btn btn-secondary mx-4">{{ __('Volver') }}</a>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!---<script>
            window.setTimeout(function() {
                $(".alert").fadeTo(50000, 0).slideUp(50000, function() {
                    $(this).remove();
                });
            }, 2000);
        </script>----->

        <script></script>

    </div>
@endsection
