<!-- JavaScript de Bootstrap (CDN) y dependencias -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

<nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
    <div class="position-sticky" style="top: 0;">
        <ul class="nav flex-column">
            <li class="nav-item mb-3">
                <a class="nav-link active" aria-current="page" href="{{ route('home') }}">
                    <img src="{{ asset('images/homecolor.png') }}" alt="Inicio" style="width: 50px; height: 50px;" />
                    Inicio
                </a>
            </li>

            @if(auth()->user()->hasRole('administrador'))
            <li class="nav-item dropdown mb-3">
                <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAACfElEQVR4nO2azUvDMBjGd/KfXU/e/ICBHpzaIAOZ6GFTRMQycCirIBp0HhQ/rh78mOA6HSjovHl6JXPV7qP7aJI1zd4HHhhJB3l+S96kXWMxFAqFQqFQqIYSCWuMxDPzZjzzQowsaOKKaWSTLFusl0wjm1RgwFLMsvUEQIxshV1sH9xC8eZVCxfs27+Z0A8AYA570KLt5goEYHUmD2uz+Ui3cQEgGrQhAINjBqzN5mG1ZYpFrY0LQFEDIwBjwBlAImBvlWdVv1u/lgDWTRuealA3+9zan5634e7jt39gALkyhGZaBbj/BNirNLdfvwGUvzq7VAOwX/6v3XcAHj7/+yMDgEoIHxkAVFL4SACgEsMLBbA8V1C3KC7avrCEASAKBO3moQH4flxSygjAGPIMIIpaOoDlZPuJSxVvmEMogjmFt7puDh0ADTF86ABoyOFDBUAVCC8UwOZJGVITVuBCxb57eO60DXBjoRCNIpjiCO96ZdryHaD2J0HiM1C3ffxyN5C7AXiuKQ6gVJMHgIU/flV4CZQaBU8GADe894fjBrB56kBq0uIKf3XttFV70QC84YUCyEna6kQCaA0vFQAVEJ59VxSATuHFLoETvnNAetIC68xpCs8OOaIAdAovFEBKQBFkNcQbXuQ22Gv3UmYb3POEH0kADz7P7ZUGQKtQX8O8SyA9Je8oLA0AbVT77SLfOYCFd88BTTdDHf7bG9TsaZUUAFTQVsd7S+t3yOnHgQFQDcIHBkA1CR8IANUofCAA9xqFHxRAhV24c1FtDv8+3Gd43vBHnOG3zqv9vypravyyNIln5noCSCSssQaE+kwYudflUSgUCoVCxUZFP/7bcdP66/lLAAAAAElFTkSuQmCC"
                     alt="Administrador" style="width: 50px; height: 50px;"/> Administrador
                </a>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="{{ route('register') }}">
                            <img src="{{ asset('images/agregarAdmin.png') }}" alt="Registrar" style="width: 50px; height: 50px;" />
                            Registrar
                        </a>
                    </li>
                    <li><a class="dropdown-item" href="{{ route('usuarios.list') }}">
                        <img src="{{ asset('images/listaAdmin.png') }}" alt="Lista" style="width: 50px; height: 50px;" />
                        Lista
                    </a></li>
                </ul>
            </li>
            @endif

            <li class="nav-item dropdown mb-3">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/empleados.png') }}" alt="Empleados" style="width: 50px; height: 50px;" /> Empleados
                </a>
                <ul class="dropdown-menu">
                    @if(auth()->user()->hasRole('administrador') || auth()->user()->hasRole('inocuidad'))
                    <li><a class="dropdown-item" href="{{ route('empleados.create') }}"> <img src="{{ asset('images/agregarcolor.png') }}"
                                alt="Alta" style="width: 50px; height: 50px;" />
                            Alta</a></li>
                    <li><a class="dropdown-item" href="{{ route('empleados.baja') }}"> <img src="{{ asset('images/bajacolor.png') }}"
                                alt="Baja" style="width: 50px; height: 50px;" />
                            Baja</a></li>
                    <li><a class="dropdown-item" href="{{ route('empleados.reingreso') }}"> <img src="{{ asset('images/volvercolor.png') }}"
                                alt="Reingreso" style="width: 50px; height: 50px;" />
                            Reingreso</a></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ route('empleados.list') }}"> <img src="{{ asset('images/listacolor.png') }}"
                                alt="Lista" style="width: 50px; height: 50px;" />
                            Lista</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown mb-3">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/relojcolor.png') }}" alt="Horas" style="width: 50px; height: 50px;" /> Horas
                </a>
                <ul class="dropdown-menu">
                    @if(auth()->user()->hasRole('administrador') || auth()->user()->hasRole('inocuidad'))
                    <li><a class="dropdown-item" href="{{ route('horas.horasEntradas') }}"> <img src="{{ asset('images/entradacolor.png') }}"
                                alt="Registrar Entradas" style="width: 50px; height: 50px;" />
                            Registrar Entradas</a></li>
                    <li><a class="dropdown-item" href="{{ route('horas.horasSalidas') }}"> <img src="{{ asset('images/salidascolor.png') }}"
                                alt="Registrar Salidas" style="width: 50px; height: 50px;" />
                            Registrar Salidas</a></li>
                    <li><a class="dropdown-item" href="{{ route('horas.horasExtras') }}"> <img src="{{ asset('images/horasextracolor.png') }}"
                                alt="Registrar Horas Extras" style="width: 50px; height: 50px;" />
                            Registrar Horas Extras</a></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ route('horas.list') }}"> <img src="{{ asset('images/listaasistenciacolor.png') }}"
                                alt="Lista de Asistencia" style="width: 50px; height: 50px;" />
                            Lista de Asistencia</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown mb-3">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/vacacionescolor.png') }}" alt="Vacaciones" style="width: 50px; height: 50px;" /> Vacaciones
                </a>
                <ul class="dropdown-menu">
                    @if(auth()->user()->hasRole('administrador') || auth()->user()->hasRole('inocuidad'))
                    <li><a class="dropdown-item" href="{{ route('vacaciones.create') }}"> <img src="{{ asset('images/agregarvacacolor.png') }}"
                                alt="Registrar" style="width: 50px; height: 50px;" />
                            Registrar</a></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ route('vacaciones.list') }}"> <img src="{{ asset('images/calendariocolor.png') }}"
                                alt="Lista" style="width: 50px; height: 50px;" />
                            Lista</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown mb-3">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="data:image/png;base64,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"
                     alt="Incapacidad" style="width: 40px; height: 40px;" /> Incapacidad

                </a>
                <ul class="dropdown-menu">
                    @if(auth()->user()->hasRole('administrador') || auth()->user()->hasRole('inocuidad'))
                    <li><a class="dropdown-item" href="{{ route('incapacidad.create') }}"> <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAACXBIWXMAAAsTAAALEwEAmpwYAAAEuElEQVR4nO2b+2/bVBTHqwkJCSGEhPhDkJCQkJB4/gKDMUBIiN/4CyYSp2w8SidREKPSQMA0sfgmG21hFJUtvu5aIOuatLRlGzDBNujyaHud2I4d+5qHBh29yE1S4jycZLmO07hX+v5g61w755N7zrmPpK9vp1mbYRgP6IZxCGN81A0NTo3e1+dGI4Ts0jH+BBsGcVMMBDlfBDzYcQAY431uO2/KD8GfDMf+wXChhzoLwDCWuwYABEUQHYJACLlFx3ijmwCUIPgg+3AnANzqtuO1AGyNBB484lkATBGCnws+6lkAzKbYvwKQfczDAABhOHCdgcHd3gUAzXBg//bx7JOeBcAUITCR0FOeBcAUIfg5do9nATClkQDB054FwBQS4z/+SGhvzwAI8CGxJQBFCAGOfaYnAAzPTMRaBlCCwAef2/YAsmou/8b0yA83A8HPgXUfF3p+WwPAhkE0jDcSEkovJH650KqWklfPpzTtzm0NALcpwzDu3gHQSiM7I4DshABuMr4SqTRZTiS3dC2ZIjrGFhvz2rxfbmcnRVWtSVDXq2xqvafjOeCz8a/I43tfqBIbHrHYBY+P1rSrJ9+BNy393xn+oKYdODHmLoDVNUQmIjyZOAX/12lIUukVi515bd632Nno4k+XLP2v/PpbtZ35nhXre3aqgEFpBEgSuV3Tm4uvngSgKModuZw1EXkOgJCRvQ0AIZGoec3bALJZ+1Ew990i6X/tIAlUKHouZrEzryttyjU49B7JKUrV8yOT07b9zs7OOQsANRgF8wtLdQDEewdAVsx5NwRQUfltngvaBpBtkAt6HgBCIlFUzdsAMhnJ2wAQEoksK40XQ03ozPS3m0vc0nPknEIi/JR9vwhP1gTBXQDITIia3nA53Ei7n32RXEuktp4Tm19oqt/4RMTWUSmvyB/NwdlXzxy/+vrU6KUvf4zPaLq+ThVAJiNbNiIqN0SaERIyVR8+vbpm2yeZTts6n1FzUj8MrVVujQ9FT85hjO+iBgDVCIVu0OHZU7P1zgdaPiVSGgDoxnVCPx9GNoemR6kDEASJ6GWJzG0xHFDrAwCj1AGgLiuNrgBASCSSlPM2AIRE0g27R64CQJtT5bzjToqqor0fO33uFT6cDMDQarkYyN6wOSX+3Q9BolwMx170R8C+gYGBXVQAILMyOAhBzCt6rTrfvtjPqQFADkL4MB6Zoe98QT4OPEENgCA4A2E/H152CgDDgWFqAFApJyh0IRyYPHHZKQB+DrxFHQAyp8wUq8On5886FALsjZf58D2OAEBIJKJEZ92Q17X1wa/Hvqf6zUPwrx+CANUkiJpYQbbzWyH+58X4u9Hx2NvRL+bLVfjhdD1H2RUGgpMWceDjAMfeT20egFxKjl0zEULN5gVZoTIaHAUgCOQ2pwAUQkKy7Cx1HQCzISRuOAnBlCSrRMd0AARgiC6ATFYSnAZQyA0SlXXE/slw0qbOH24ZgCwrL3UCwFZYZOW2dplCi9/M1Ct1Pi54c3+/FSVlrJMQSqdQar71/KDq2vWD02NLlZOcmnW+JQhibk82K8dFUb7cScmyEtN1/Vgrf7TWMD4yciE61M+HjjAQHGLgsXvbcr7Pg+0/dgoZb0ZjS+EAAAAASUVORK5CYII="
                                alt="Registrar" style="width: 40px; height: 40px;" />
                            Registrar</a></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ route('incapacidad.list') }}"> <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAACXBIWXMAAAsTAAALEwEAmpwYAAAD40lEQVR4nO2dy04UQRSGe6O+BHZ14yDaNQQNUbyRiboxcQQVfYJxZYw7jKvBF9BINLoBb4kLlQWz0ERBEi5uFHUBuAUThWhiOjBEIdB1TPXMkBFvA2Kqqvv/krMYwmLO+fqcqoZOtWUBAAAAAAAAAAAAAAAAAH+lqrqujrleB3P4GHO9OeZyUhG2w+eZy8/GVlkikdhkO94N5vJAlQT2cwjb9c5ZsZThev2yCDW1O+jSpXZ683qY5vLTJAJfSTCXk1OdjKcU2/VuygI07k3R+NgrZRLECiF3b7XFT0phzeCB7AxdZIiiEPH1YfykMNe7KpOXY6q8IL19j6m55RQltu5Y9exPHTyybkJiJ4W5fFwm//bNix9k7DtwmIaGe2lh/rPSDhFxk8IcnpfJ5/NTy8U41twaytBhZImyuH/vIrlbilKc5HkripTGTHkx5JhS1RniD0JiIeVXQlZ+1kmIiLoUE4WIKEsxVYiIqhSThYgoSjFdiIiaFF2FVCeStJh/ULGUyNyn6CpkV+MBmp7sqlhIZKToKiSTyVCuO7sqIZEYX7oK6ck9otaT6VULMb5TdBWytPiFjqZb6HZnW7yk6CpEBD5NTozT7j1NdKfrQnyk6CxEBD69n3xH6XQLnTxxlHq6s/RxonPNuy8j/kevuxBRHF+5XDedOZOh3Y1N4ZZ4rQ9OWLpjghCxDlHK09IdCNEMCNEMCNGMqApJrXjQAmtIoH4Rh5BAfWfEpkNkgpU8g5X6ze/9z6jkObDICTE9GIT4GFnoEB+LutB4RGFkBepFQEigZ0R+22t6MAjxlUuItBDTbgxTGFm+8i7400UVuQ4xLRiE+MolQEigvvAQokGxBYSoL7CAEPVFFRBSKAJ2WQqJ6o0hw7bXVz6mICRQX3gI0aDYAkLUF1hAiPqiCggpFAHbXoXgr72aASGagRtDzUCHaAaEaAaEaAaEaAaEaAaEGCBEh2NixT/E/LdPVFO708znsmyHz/7qIOXBoWfKCyvWGAODz6j5+Onlz7MzH0IZtsNnLJOPGpeJmdQpC/OfaWDgKe3df4ie9z9Z/vnrkeFChzh81DLlMP729h8P4+97/iS8ytZyGD9TFPK7yu9cLkNGNpstdcgVS3eqqrclmestyddVjI2+VH6Vi3UOmVNiaz3JHG3b8ywTYA6/XnqhS5SkjI2+DHMqdJDXYZmC53kbmcP7Cm1fH7a4nLvlC70pkc9P0cir4TCHQmeEa0dvQ0PDBsskilKuydZWvRawdQuZi9dhnIxyNm/ZzuXiJ3ckpXeLGBUOz8vvbjv8sjFrBgAAAAAAAAAAAAAAAABLLd8BwqvzUwqUPg0AAAAASUVORK5CYII="
                                alt="Lista" style="width: 50px; height: 50px;" />
                            Lista</a></li>
                </ul>
            </li>

            <li class="nav-item dropdown mb-3">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('images/areascolor.png') }}" alt="Áreas" style="width: 50px; height: 50px;" /> Áreas
                </a>
                <ul class="dropdown-menu">
                    @if(auth()->user()->hasRole('administrador') || auth()->user()->hasRole('inocuidad'))
                    <li><a class="dropdown-item" href="{{ route('areas.create') }}"> <img src="{{ asset('images/agregarvacacolor.png') }}"
                                alt="Registrar" style="width: 50px; height: 50px;" />
                            Registrar</a></li>
                    @endif
                    <li><a class="dropdown-item" href="{{ route('areas.list') }}"> <img src="{{ asset('images/listaasistenciacolor.png') }}"
                                alt="Lista" style="width: 50px; height: 50px;" />
                            Lista</a></li>
                </ul>
            </li>

        </ul>
    </div>
</nav>
