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
                            <a href="{{ route('incapacidad.create')}}">
                                <div class="rounded text-center">
                                    <img src="{{ asset('images/agregarvacacolor.png') }}" class="img-fluid" alt="...">
                                    <h1 class="fs-5 small fw-bold">REGISTRAR</h1>
                                </div>
                            </a>
                        </div>
                        @endif

                        <div class="col mb-5">
                            <a href="{{ route('incapacidad.list')}}">
                                <div class="rounded text-center">
                                    <img src="{{ asset('images/calendariocolor.png') }}" class="img-fluid" alt="...">
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
