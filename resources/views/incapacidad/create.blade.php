@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            @include('navbar.navbar')
            <div class="col-md-9 col-lg-10">

                <div class="container mt-4">
                    <h2> <img
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEuElEQVR4nO2b+2/bVBTHqwkJCSGEhPhDkJCQkJB4/gKDMUBIiN/4CyYSp2w8SidREKPSQMA0sfgmG21hFJUtvu5aIOuatLRlGzDBNujyaHud2I4d+5qHBh29yE1S4jycZLmO07hX+v5g61w755N7zrmPpK9vp1mbYRgP6IZxCGN81A0NTo3e1+dGI4Ts0jH+BBsGcVMMBDlfBDzYcQAY431uO2/KD8GfDMf+wXChhzoLwDCWuwYABEUQHYJACLlFx3ijmwCUIPgg+3AnANzqtuO1AGyNBB484lkATBGCnws+6lkAzKbYvwKQfczDAABhOHCdgcHd3gUAzXBg//bx7JOeBcAUITCR0FOeBcAUIfg5do9nATClkQDB054FwBQS4z/+SGhvzwAI8CGxJQBFCAGOfaYnAAzPTMRaBlCCwAef2/YAsmou/8b0yA83A8HPgXUfF3p+WwPAhkE0jDcSEkovJH650KqWklfPpzTtzm0NALcpwzDu3gHQSiM7I4DshABuMr4SqTRZTiS3dC2ZIjrGFhvz2rxfbmcnRVWtSVDXq2xqvafjOeCz8a/I43tfqBIbHrHYBY+P1rSrJ9+BNy393xn+oKYdODHmLoDVNUQmIjyZOAX/12lIUukVi515bd632Nno4k+XLP2v/PpbtZ35nhXre3aqgEFpBEgSuV3Tm4uvngSgKModuZw1EXkOgJCRvQ0AIZGoec3bALJZ+1Ew990i6X/tIAlUKHouZrEzryttyjU49B7JKUrV8yOT07b9zs7OOQsANRgF8wtLdQDEewdAVsx5NwRQUfltngvaBpBtkAt6HgBCIlFUzdsAMhnJ2wAQEoksK40XQ03ozPS3m0vc0nPknEIi/JR9vwhP1gTBXQDITIia3nA53Ei7n32RXEuktp4Tm19oqt/4RMTWUSmvyB/NwdlXzxy/+vrU6KUvf4zPaLq+ThVAJiNbNiIqN0SaERIyVR8+vbpm2yeZTts6n1FzUj8MrVVujQ9FT85hjO+iBgDVCIVu0OHZU7P1zgdaPiVSGgDoxnVCPx9GNoemR6kDEASJ6GWJzG0xHFDrAwCj1AGgLiuNrgBASCSSlPM2AIRE0g27R64CQJtT5bzjToqqor0fO33uFT6cDMDQarkYyN6wOSX+3Q9BolwMx170R8C+gYGBXVQAILMyOAhBzCt6rTrfvtjPqQFADkL4MB6Zoe98QT4OPEENgCA4A2E/H152CgDDgWFqAFApJyh0IRyYPHHZKQB+DrxFHQAyp8wUq8On5886FALsjZf58D2OAEBIJKJEZ92Q17X1wa/Hvqf6zUPwrx+CANUkiJpYQbbzWyH+58X4u9Hx2NvRL+bLVfjhdD1H2RUGgpMWceDjAMfeT20egFxKjl0zEULN5gVZoTIaHAUgCOQ2pwAUQkKy7Cx1HQCzISRuOAnBlCSrRMd0AARgiC6ATFYSnAZQyA0SlXXE/slw0qbOH24ZgCwrL3UCwFZYZOW2dplCi9/M1Ct1Pi54c3+/FSVlrJMQSqdQar71/KDq2vWD02NLlZOcmnW+JQhibk82K8dFUb7cScmyEtN1/Vgrf7TWMD4yciE61M+HjjAQHGLgsXvbcr7Pg+0/dgoZb0ZjS+EAAAAASUVORK5CYII="
                            alt="Agregar" style="width: 35px; height: 35px;" />
                        Incapacidad</h2>

                    @if ($errors->any())
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ url('incapacidades') }}" method="post">
                        @csrf

                        <fieldset>


                            <div class="row">
                                <div class="col-md-5">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Número</b></label>
                                    </div>
                                    <select class="form-select text-center" name="numNomina" id="numNomina" required>
                                        <option value="">Seleccionar número de nómina</option>
                                        @foreach ($empleados as $id => $NumNomina)
                                            <option value="{{ $id }}">{{ $NumNomina }}</option>
                                        @endforeach
                                    </select>

                                </div>

                            </div>

                        </fieldset>
                        <fieldset>
                            <legend class="text-center"><b>Periodo Incapacidad</b></legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Empieza</b></label>
                                    </div>
                                    <input type="date" class="form-control text-center" name="FechaInicio"
                                        id="FechaInicio" value="{{ old('FechaInicio') }}" required
                                        onchange="calcularTotalDias()">
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Termina</b></label>
                                    </div>
                                    <input type="date" class="form-control text-center" name="FechaFin" id="FechaFin"
                                        value="{{ old('FechaFin') }}" required onchange="calcularTotalDias()">
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Total de Dias</b></label>
                                    </div>
                                    <input type="text" class="form-control" name="TotalDias" id="TotalDias"
                                        value="{{ old('TotalDias') }}" required readonly>
                                </div>
                            </div>
                        </fieldset>




                        <br>
                        <div class="row mt-4  text-center">
                            <div class="col-md-12">
                                <a href="{{ route('incapacidad.view') }}"
                                    class="btn btn-secondary mx-4">{{ __('Volver') }}</a>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
       function calcularTotalDias() {
    let fechaInicio = new Date(document.getElementById('FechaInicio').value);
    let fechaFin = new Date(document.getElementById('FechaFin').value);

    // Sumar 1 para incluir el día final en el cálculo
    let diffTime = Math.abs(fechaFin - fechaInicio) + (1000 * 60 * 60 * 24);

    let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    document.getElementById('TotalDias').value = diffDays;
}

    </script>
@endsection
