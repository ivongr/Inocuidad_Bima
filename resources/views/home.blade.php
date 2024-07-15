@extends('layouts.app')


@section('content' )
 <!-- CSS de Bootstrap (CDN) -->

 <!-- jQuery -->
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

 <!-- DataTables CSS -->
 <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
 <!-- DataTables JS -->
 <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <div class="container" >
        <div class="row">
            @include('navbar.navbar')

            <div class="col-md-9 col-lg-10">
                @if(auth()->user()->hasRole('administrador'))
                <div class="container mt-4">
                    <div class="col mb-5">
                        <a href="{{ route('usuarios.view') }}" class="text-decoration-none text-dark">
                            <div class="rounded bg-light p-3 text-center">
                                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAACfElEQVR4nO2azUvDMBjGd/KfXU/e/ICBHpzaIAOZ6GFTRMQycCirIBp0HhQ/rh78mOA6HSjovHl6JXPV7qP7aJI1zd4HHhhJB3l+S96kXWMxFAqFQqFQqIYSCWuMxDPzZjzzQowsaOKKaWSTLFusl0wjm1RgwFLMsvUEQIxshV1sH9xC8eZVCxfs27+Z0A8AYA570KLt5goEYHUmD2uz+Ui3cQEgGrQhAINjBqzN5mG1ZYpFrY0LQFEDIwBjwBlAImBvlWdVv1u/lgDWTRuealA3+9zan5634e7jt39gALkyhGZaBbj/BNirNLdfvwGUvzq7VAOwX/6v3XcAHj7/+yMDgEoIHxkAVFL4SACgEsMLBbA8V1C3KC7avrCEASAKBO3moQH4flxSygjAGPIMIIpaOoDlZPuJSxVvmEMogjmFt7puDh0ADTF86ABoyOFDBUAVCC8UwOZJGVITVuBCxb57eO60DXBjoRCNIpjiCO96ZdryHaD2J0HiM1C3ffxyN5C7AXiuKQ6gVJMHgIU/flV4CZQaBU8GADe894fjBrB56kBq0uIKf3XttFV70QC84YUCyEna6kQCaA0vFQAVEJ59VxSATuHFLoETvnNAetIC68xpCs8OOaIAdAovFEBKQBFkNcQbXuQ22Gv3UmYb3POEH0kADz7P7ZUGQKtQX8O8SyA9Je8oLA0AbVT77SLfOYCFd88BTTdDHf7bG9TsaZUUAFTQVsd7S+t3yOnHgQFQDcIHBkA1CR8IANUofCAA9xqFHxRAhV24c1FtDv8+3Gd43vBHnOG3zqv9vypravyyNIln5noCSCSssQaE+kwYudflUSgUCoVCxUZFP/7bcdP66/lLAAAAAElFTkSuQmCC"
                                 class="img-fluid"  style="width: 100px; height: 100px;" alt="...">
                                <h1 class="fs-4 fw-bold mt-3">Administrador</h1>
                            </div>
                        </a>
                    </div>
                    @endif
                    <div class="row row-cols-1 row-cols-md-2 g-4">



                        <div class="col mb-5">
                            <a href="{{ route('empleados.view') }}" class="text-decoration-none text-dark">
                                <div class="rounded bg-light p-3 text-center">
                                    <img src="images/empleados.png" class="img-fluid" alt="...">
                                    <h1 class="fs-4 fw-bold mt-3">EMPLEADOS</h1>
                                </div>
                            </a>
                        </div>
                        <div class="col mb-5">
                            <a href="{{ route('horas.view') }}" class="text-decoration-none text-dark">
                                <div class="rounded bg-light p-3 text-center">
                                    <img src="images/relojcolor.png" class="img-fluid" alt="...">
                                    <h1 class="fs-4 fw-bold mt-3">HORAS</h1>
                                </div>
                            </a>
                        </div>
                        <div class="col mb-5">
                            <a href="{{ route('vacaciones.view') }}" class="text-decoration-none text-dark">
                                <div class="rounded bg-light p-3 text-center">
                                    <img src="images/vacacionescolor.png" class="img-fluid" alt="...">
                                    <h1 class="fs-4 fw-bold mt-3">VACACIONES</h1>
                                </div>
                            </a>
                        </div>
                        <div class="col mb-5">
                            <a href="{{ route('incapacidad.view') }}" class="text-decoration-none text-dark">
                                <div class="rounded bg-light p-3 text-center">
                                    <img src="data:image/png;base64,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" class="img-fluid" alt="...">
                                    <h1 class="fs-4 fw-bold mt-3">INCAPACIDAD</h1>
                                </div>
                            </a>
                        </div>
                        <div class="col mb-5">
                            <a href="{{ route('areas.view') }}" class="text-decoration-none text-dark">
                                <div class="rounded bg-light p-3 text-center">
                                    <img src="images/areascolor.png" class="img-fluid" alt="...">
                                    <h1 class="fs-4 fw-bold mt-3">ÁREAS</h1>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
