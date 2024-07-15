@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('navbar.navbar')

        <div class="col-md-9 col-lg-10 mx-auto">
         
            <div class="container mt-4">
                <div class="text-center">
                    <img src="{{ asset('images/exito.png') }}" class="img-fluid" alt="Exito" style="width: 150px; height: 150px;" />
                    <br>
                    <h2><b>   <br>{{ $msg }}</b></h2>
                    <br>

                    <a href="{{ route('horas.view') }}"  class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Volver a la página principal</a>
                </div>
            </div>
        </div>
    </div>
   
</div>
@endsection
