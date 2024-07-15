<!DOCTYPE html>
<html>
<head>
    <title>Lista de Empleados</title>
    <style>
        /* Estilos generales */
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            max-height: 80vh; /* Altura máxima del 80% del viewport height */
            overflow-y: auto; /* Scroll vertical si el contenido excede la altura máxima */
        }
        th, td {
            border: 2px solid black;
            padding: 8px;
            text-align: center; /* Centrar contenido en todas las celdas */
        }

        /* Estilos específicos para impresión */
        @media print {
            body {
                transform: rotate(90deg); /* Rotar la página 90 grados para horizontal */
                transform-origin: left top; /* Punto de origen para la rotación */
                width: 100vh; /* Ancho de la página al rotar */
                height: 100vw; /* Altura de la página al rotar */
                margin: 0; /* Eliminar márgenes */
                padding: 0; /* Eliminar padding */
                overflow: hidden; /* Ocultar contenido que desborda */
                page-break-after: always; /* Saltar a una nueva página después de cada tabla */
            }
            table {
                font-size: 12px; /* Tamaño de fuente más pequeño para impresión */
                width: 100%; /* Asegurar que la tabla ocupe todo el ancho */
            }
            th, td {
                padding: 4px; /* Reducir el padding para imprimir más compacto */
            }
        }
    </style>
</head>
<body>
    <h1>Lista de Empleados</h1>
    <table>
        <thead class="text-center">
            <tr>
                <th>Número de Nómina</th>
                <th>Nombre</th>

                <th>Número de Seguridad</th>
                <th>RFC</th>
                <th>Área</th>
                <th>Fecha de ingreso</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @foreach ($empleados as $empleado)
            <tr class="text-center">
                <td>{{ $empleado->NumNomina }}</td>


                <td>{{ $empleado->nombre_completo }}</td>

                <td>{{ $empleado->NumSeguridad }}</td>
                <td>{{ $empleado->Rfc}}</td>
                <td>{{ $empleado->nombre_area}}</td>

                <td>{{ $empleado->FechaUltimoReingreso}}</td>




            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
