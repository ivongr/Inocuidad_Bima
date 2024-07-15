@extends('layouts.app')

@section('content')
    <main>
        <div class="container py-4">
            <h2>Editar area</h2>

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

            @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form method="POST" action="{{ route('areas.update', $areas->Id) }}" role="form" enctype="multipart/form-data" >

    <input type="hidden" name="Id" value="{{ $areas->Id }}">

    @csrf
    @method('PUT')


                <div class="mb-3 row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="nombre" id="nombre" value="{{ $areas->Nombre }}"
                            required>
                    </div>
                </div>





                <a href="{{ route('areas.view') }}" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-success ml-3">Guardar</button>

            </form>
        </div>
    </main>
@endsection
