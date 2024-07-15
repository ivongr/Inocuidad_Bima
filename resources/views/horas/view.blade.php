@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('navbar.navbar')

            <div class="col-md-9 col-lg-10">
            
            <div class="container mt-4">

                <div class="row row-cols-1 row-cols-md-2">
                    @if(auth()->user()->hasRole('administrador') || auth()->user()->hasRole('inocuidad'))
                    <div class="col mb-5">
                        <a href="{{ route('horas.horasEntradas') }}">
                            <div class="rounded text-center">
                                <img src="{{ asset('images/entradacolor.png') }}" class="img-fluid" alt="...">
                                <h1 class="fs-5 small fw-bold">REGISTRAR ENTRADAS</h1>
                            </div>
                        </a>

                    </div>
                    <div class="col mb-5">
                        <a href="{{ route('horas.horasSalidas') }}">
                        <div class="rounded text-center">
                            <img src="{{ asset('images/salidascolor.png') }}" class="img-fluid" alt="...">
                            <h1 class="fs-5 small fw-bold">REGISTRAR SALIDAS</h1>
                        </div>
                    </a>

                    </div>
                    <div class="col mb-5">
                        <a href="{{ route('horas.horasExtras') }}">
                        <div class="rounded text-center">
                            <img src="{{ asset('images/horasextracolor.png') }}"class="img-fluid" alt="...">
                            <h1 class="fs-5 small fw-bold" >REGISTRAR HORAS EXTRAS</h1>
                        </div>
                    </a>
                    </div>
                    @endif
                    <div class="col mb-5">
                        <a href="{{ route('horas.list') }}">
                        <div class="rounded text-center">
                            <img src="{{ asset('images/listaasistenciacolor.png') }}" class="img-fluid" alt="...">
                            <h1 class="fs-5 small fw-bold">LISTA DE ASISTENCIA</h1>
                        </div>
                    </a>

                    </div>

                </div>
            </div>

        </div>
       
    </div>
    </div>
@endsection
