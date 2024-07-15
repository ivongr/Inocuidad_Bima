@extends('layouts.app')



@section('content')

    <div class="container">
        <div class="row">
            @include('navbar.navbar')
            <div class="col-md-9 col-lg-10">

                <div class="container mt-4">

                    <h2>  <img src="{{ asset('images/agregarvacacolor.png') }}"
                        alt="Agregar" style="width: 35px; height: 35px;" />
                   Registrar Área</h2>


                   

                    <form action="{{ url('areas') }}" method="post">

                        <!-- GENERAR UN EVENTO OCULTO-->
                        @csrf


                        <div class="mb-3 row">
                            <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                <label class="d-block text-center w-100"> <b>Nombre :</b></label>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="nombre" id="nombre"
                                    value="{{ old('nombre') }}" required>
                                    @error('nombre')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>


                        <br>
                        <div class="row mt-4  text-center">
                            <div class="col-md-12">

                        <a href="{{ route('areas.view') }}" class="btn btn-secondary mx-4">{{ __('Regresar') }}</a>


                        <button type="submit" class="btn btn-success ">Guardar</button>
                    </div>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
