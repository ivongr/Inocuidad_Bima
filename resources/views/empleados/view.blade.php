@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('navbar.navbar')

            <div class="col-md-9 col-lg-10">
               
            <div class="container mt-5">

                <div class="row row-cols-1 row-cols-md-2">
                    @if(auth()->user()->hasRole('administrador') || auth()->user()->hasRole('inocuidad'))
                    <div class="col mb-5">
                        <a href="{{ route('empleados.create') }}">
                            <div class="rounded text-center">
                                <img src="{{ asset('images/agregarcolor.png') }}" class="img-fluid" alt="...">
                                <h1 class="fs-5 small fw-bold">ALTA</h1>
                            </div>
                        </a>
                    </div>
                    <div class="col mb-5">
                        <a href="{{ route('empleados.baja') }}">
                        <div class="rounded text-center">
                            <img src="{{ asset('images/bajacolor.png') }}" class="img-fluid" alt="...">
                            <h1 class="fs-5 small fw-bold">BAJA</h1>
                        </div>
                        </a>
                    </div>
                    <div class="col mb-5">
                        <a href="{{ route('empleados.reingreso') }}">
                        <div class="rounded text-center">
                            <img src="{{ asset('images/volvercolor.png') }}" class="img-fluid" alt="...">
                            <h1 class="fs-5 small fw-bold" >REINGRESO</h1>
                        </div>
                    </a>
                    </div>
                    @endif
                    <div class="col mb-5">
                        <a href="{{ route('empleados.list') }}">
                        <div class="rounded text-center">
                            <img src="{{ asset('images/listacolor.png') }}" class="img-fluid" alt="...">
                            <h1 class="fs-5 small fw-bold">LISTA</h1>
                        </div>
                    </a>

                    </div>

                </div>
            </div>
          
        </div>
    </div>
    </div>
@endsection
