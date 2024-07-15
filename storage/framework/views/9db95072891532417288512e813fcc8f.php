<!DOCTYPE html>
<html>
<head>
    <title>Lista de Horas</title>
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
        @media print {
            h1 {
                margin-top: 0;
                margin-bottom: 0.5cm; /* Reducir espacio después del título al imprimir */
            }
            table {
                margin-top: 0;
                margin-bottom: 0.5cm; /* Reducir espacio después de la tabla al imprimir */
            }
        }
    </style>
</head>
<body>
    <h1>Lista de Horas</h1>
    <table>
        <thead>
            <tr>
                <th>Nom. de Nómina</th>
                <th>Fecha</th>
                <th>Día</th>
                <th>Nombre Completo</th>
                <th>Hora de Entrada</th>
                <th>Hora de Salida</th>
                <th>Hora de Entrada</th>
                <th>Hora de Salida</th>
                <th>Horas Extras</th>
                <th>Total Horas</th>
                <th>Área</th>
                <th>Descripción</th>
                <th>Firma</th>
            </tr>
        </thead>
        <tbody class="no-title">
            <?php $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($empleado->NumNomina); ?></td>
                <td><?php echo e($empleado->Fecha); ?></td>
                <td>
                    <?php
                    $dias = [
                        'Sunday' => 'Domingo',
                        'Monday' => 'Lunes',
                        'Tuesday' => 'Martes',
                        'Wednesday' => 'Miércoles',
                        'Thursday' => 'Jueves',
                        'Friday' => 'Viernes',
                        'Saturday' => 'Sábado'
                    ];
                    $diaSemana = date('l', strtotime($empleado->Fecha));
                    echo $dias[$diaSemana];
                    ?>
                </td>
                <td><?php echo e($empleado->NombreCompleto); ?></td>
                <td><?php echo e($empleado->{'Hora de Entrada 1'}); ?></td>
                <td><?php echo e($empleado->{'Hora de Salida 1'}); ?></td>
                <td><?php echo e($empleado->{'Hora de Entrada 2'}); ?></td>
                <td><?php echo e($empleado->{'Hora de Salida 2'}); ?></td>
                <td><?php echo e($empleado->{'Horas Extras'}); ?></td>
                <td><?php echo e(intval($empleado->{'Total De Horas Laboradas'})); ?></td>
                <td><?php echo e($empleado->Área); ?></td>
                <td><?php echo e($empleado->Estado); ?></td> <!-- Mostrar el estado del empleado -->
                <td style="padding: 0.7cm; width: 3cm;"></td>

            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/horas/list_pdfHoras.blade.php ENDPATH**/ ?>