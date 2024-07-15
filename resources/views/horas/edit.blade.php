@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            @include('navbar.navbar')
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <div class="col-md-9 col-lg-10">


                <div class="container mt-4">
                    <div class="row">
                        
                        <h2> <img src="{{ asset('images/editar.png') }}" alt="Agregar" style="width: 55px; height: 55px;" />
                            Editar Empleado</h2>


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
                        <form action="{{ route('horas.update', ['Id' => $Id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <!-- Campos comunes a las tres tablas -->
                            <label for="fecha">Fecha:</label>
                            <input type="date" id="fecha" name="fecha" value="{{ $fecha }}" required>
                        
                            <!-- Campos específicos de HorasExtras -->
                            <label for="hora_inicio">Hora de Inicio:</label>
                            <input type="time" id="hora_inicio" name="hora_inicio" value="{{ $hora_inicio }}" required>
                            <label for="hora_fin">Hora de Fin:</label>
                            <input type="time" id="hora_fin" name="hora_fin" value="{{ $hora_fin }}" required>
                        
                            <!-- Campos específicos de Entradas -->
                            <label for="hora_entrada">Hora de Entrada:</label>
                            <input type="time" id="hora_entrada" name="hora_entrada" value="{{ $hora_entrada }}" required>
                        
                            <!-- Campos específicos de Salidas -->
                            <label for="hora_salida">Hora de Salida:</label>
                            <input type="time" id="hora_salida" name="hora_salida" value="{{ $hora_salida }}" required>
                        
                        
                        

                        <div class="text-center">
                            <a href="{{ route('empleados.view') }}" class="btn btn-secondary">Volver</a>
                            <button type="submit" class="btn btn-success ml-3">Guardar</button>

                        </div>
                        </form>
                    </div>
                    </main>
                @endsection
