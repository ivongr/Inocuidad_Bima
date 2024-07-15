<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Control') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>
<body>
    <div id="app">
        <div class="loader"></div>

        <style>   .loader {
            position: fixed;
            top: 50%;
            left: 50%;
            width: 100vw;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            transition: opacity 0.75s, visibility 0.75s;
        }
        .loader-hidden {
            opacity: 0;
            visibility: hidden;
        }
        .loader::after {
            content: url('spinner\ mini.png');
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 75px;
            height: 75px;
            border: 15px solid #ddd;
            border-top-color: #005208;
            border-radius: 50%;
            animation: loading 0.75s ease infinite;
        }
        .loader img {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 25px !important; /* Ancho de la imagen */
            height: 25px !important; /* Alto de la imagen */
            z-index: 99999;
        }
        @keyframes loading {
            from {
                transform: rotate(0turn);
            }

            to {
                transform: rotate(1turn);
            }
        }</style>
        <!-- CSS de Bootstrap (CDN) -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
     <!-- JavaScript de Bootstrap (CDN) y dependencias -->
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
     <!-- jQuery -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

     <!-- DataTables CSS -->
     <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
     <!-- DataTables JS -->
     <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

        <nav class="navbar navbar-expand-md shadow-sm " >
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <img src="{{ asset('images/bima.png') }}" alt="logo" style="width: 100px; height: 65px;" />  {{ config( 'Control') }}
                </a>
                <script>
                    function obtenerNombreMes(numeroMes) {
                        var meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiembre", "octubre", "noviembre", "diciembre"];
                        return meses[numeroMes];
                    }

                    function mostrarHoraMexicana() {
                        // Obtener la hora actual del sistema del usuario
                        var ahora = new Date();

                        // Crear un objeto de fecha con la zona horaria de México (UTC-6)
                        var horaMexicana = new Date(ahora.toLocaleString("en-US", {timeZone: "America/Mexico_City"}));

                        // Formatear la hora mexicana para mostrarla en la página
                        var horaFormateada = horaMexicana.toLocaleTimeString();

                        // Obtener el día de la semana en español
                        var diasSemana = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
                        var diaSemana = diasSemana[horaMexicana.getDay()];

                        // Formatear la fecha
                        var fecha = horaMexicana.getDate() + " de " + obtenerNombreMes(horaMexicana.getMonth()) + " del " + horaMexicana.getFullYear();

                        // Mostrar la hora, la fecha y el día en la página
                        document.getElementById('hora-mexico').innerText = horaFormateada + " / " + diaSemana + " "+ fecha;
                    }

                    // Actualizar la hora cada segundo
                    setInterval(mostrarHoraMexicana, 1000);
                </script>


                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <b>  <div id="hora-mexico" ></div></b>
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Incio de Sesión') }}</a>
                                </li>
                            @endif


                        @else

                            <li class="nav-item dropdown">

                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{ asset('images/usuario.png') }}" alt="Usuario" style="width: 40px; height: 40px;" />   {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>

                                </div>

                                @if (Route::has('homeuser'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('homeuser') }}">{{ __('homeuser') }}</a>
                                </li>
                                @endif
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
<script>// Mostrar el spinner cuando se inicia la carga de la página
    document.addEventListener("DOMContentLoaded", () => {
        const loader = document.querySelector(".loader");
        loader.classList.add("loader-hidden");
    });

    // Ocultar el spinner cuando se haya cargado completamente la página
    window.addEventListener("load", () => {
        const loader = document.querySelector(".loader");
        loader.classList.add("loader-hidden");
    });</script>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
