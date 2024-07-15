@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('navbar.navbar')

            <div class="col-md-9 col-lg-10">

                <div class="container mt-4">

                    <div class="row row-cols-1 row-cols-md-2">

                        @if(auth()->user()->hasRole('administrador'))
                        <div class="col mb-5">
                            <a href="{{ route('register')}}">
                                <div class="rounded text-center">
                                    <img src="{{ asset('images/agregarAdmin.png')}}" class="img-fluid" alt="..." style="width: 100px; height: 100px;">
                                    <h1 class="fs-5 small fw-bold">REGISTRAR</h1>
                                </div>
                            </a>
                        </div>


                        <div class="col mb-5">
                            <a href="{{ route('usuarios.list')}}">
                                <div class="rounded text-center">
                                    <img src="{{ asset('images/listaAdmin.png') }}" class="img-fluid" alt="...">
                                    <h1 class="fs-5 small fw-bold">LISTA</h1>
                                </div>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
