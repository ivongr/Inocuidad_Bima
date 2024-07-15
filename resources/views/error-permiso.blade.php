@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('navbar.navbar')
            <div class="col-md-9 col-lg-10">
                <div class="container mt-4">
                    <div class="row text-center">
                        <div class="col">
                            <img src="{{ asset('images/denegado.png') }}" alt="Denegado" style="width: 120px; height: 120px;" />
                            <h1>Error de permiso</h1>
                            <p>{{ session('error') }}</p>
                            <a href="{{  url('/home') }}"  class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Volver a la página principal</a>
                        
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
