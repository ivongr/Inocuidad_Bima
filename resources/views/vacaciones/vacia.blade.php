@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('navbar.navbar')
            <div class="col-md-9 col-lg-10">
                <h2>   <img src="{{ asset('images/listaasistenciacolor.png') }}"
                    alt="Agregar" style="width: 35px; height: 35px;" />
            <b>Lista Vacaciones</b></h2>
                <div class="container mt-6">
                    <div class="col mb-6 text-center">
                        <img src="{{ asset('images/alerta.png') }}"  class="img-fluid" alt="...">
                        <div class="alert alert-warning" role="alert">
                      <b>SIN INFORMACIÓN</b> Selecciona otra opción, por favor.
                          </div>
                    </div>
                </div>
                <a href="{{ route('vacaciones.view') }}" class="btn btn-secondary ">Volver</a>
            </div>

        </div>

    </div>
   
@endsection
