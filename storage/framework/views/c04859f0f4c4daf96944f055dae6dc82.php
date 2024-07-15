<html lang="es">
<?php $__env->startSection('content'); ?>
    <div class="container">


        <!-- jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <div class="row">
            <?php echo $__env->make('navbar.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if(session('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?>


            <div class="col-md-9 col-lg-10">


                <div class="container mt-4">
                    <div class="row">
                        <h2> <img src="<?php echo e(asset('images/listacolor.png')); ?>" alt="Agregar"
                                style="width: 55px; height: 55px;" /> Lista Empleados Activos</h2>

                        <form class="form-inline" method="get">
                            <div class="row row-cols-1 row-cols-lg-5 g-2 g-lg-3">

                                <div class="input-group">
                                    <select name="buscarpor" class="form-control form-select-sm mr-sm-6 w-80">
                                        <option value="">Restablecer</option>
                                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>" <?php echo e($buscarpor == $id ? 'selected' : ''); ?>>
                                                <?php echo e($nombre); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Buscar</button>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="d-flex justify-content-between">
                                <style>
                                    .btn-custom {
                                        padding: 0.375rem 0.75rem;
                                        /* Ajusta el padding para cambiar el tamaño del botón */
                                        font-size: 1rem;
                                        /* Ajusta el tamaño de la fuente */
                                        line-height: 1.5;
                                        /* Ajusta el espacio entre líneas */
                                        border-radius: 0.25rem;
                                        /* Ajusta el radio de las esquinas del botón */
                                    }

                                    .btn-custom img {
                                        width: 1.5em;
                                        /* Ajusta el tamaño de la imagen dentro del botón */
                                        height: 1.5em;
                                    }
                                </style>
                                <a href="<?php echo e(route('empleados.listBaja')); ?>"
                                    class="link-success link-underline-success link-underline-opacity-25">
                                    <img src="<?php echo e(asset('images/bajacolor.png')); ?>" alt="Agregar"
                                        style="width: 50px; height: 50px;" /> Lista Baja Empleados
                                </a>

                                <div class="d-flex justify-content-end">


                                    <?php if($buscarpor): ?>
                                        <a href="<?php echo e(route('exportArea', ['buscarpor' => $buscarpor])); ?>"
                                            class="btn btn-success btn-custom me-2" style="background: #22C55E">
                                            <img src="<?php echo e(asset('images/excel.png')); ?>" class="me-2"> Exportar a Excel
                                        </a>
                                    <?php else: ?>
                                        <a href="/exportarEmpleados" class="btn btn-success btn-custom me-2"
                                            style="background: #22C55E">
                                            <img src="<?php echo e(asset('images/excel.png')); ?>" class="me-2"> Exportar a Excel
                                        </a>
                                    <?php endif; ?>

                                    <a href="<?php echo e(route('imprimir.pdf', ['buscarpor' => $buscarpor])); ?>"
                                        class="btn btn-danger btn-custom me-2" style="background: #EF4444">
                                        <img src="<?php echo e(asset('images/pdf.png')); ?>" class="me-2"> Exportar a PDF
                                    </a>
                                </div>
                            </div>
                        </form>



                    </div>
                    <br>
                    <table style="margin-top: 20px;" id="empleadosActivos" class="display" style="width:100% ">
                        <thead class="text-center">
                            <tr class="text-center">
                                <th>Id</th>
                                <th>Número de Nómina</th>
                                <th>Nombre Completo</th>
                                <th>Número de Seguridad</th>
                                <th>RFC</th>
                                <th>Área</th>
                                <th>Fecha de ingreso</th>
                                <th>Historial de Fechas</th> <!-- Nueva columna -->
                                <th>Actualizar</th> <!-- Nueva columna -->
                                <th>Eliminar</th> <!-- Nueva columna -->
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="text-center">
                                    <td><?php echo e($empleado->Id); ?></td>
                                    <td><?php echo e($empleado->NumNomina); ?></td>
                                    <td><?php echo e($empleado->nombre_completo); ?></td>
                                    <td><?php echo e($empleado->NumSeguridad); ?></td>
                                    <td><?php echo e($empleado->Rfc); ?></td>
                                    <td><?php echo e($empleado->nombre_area); ?></td>
                                    <td><?php echo e($empleado->FechaUltimoReingreso); ?></td>


                                    <td> <!-- Nueva columna -->
                                        <button type="button" class="btn"
                                            style="background-color: #ff9c78; color: white;" data-bs-toggle="modal"
                                            data-bs-target="#historialModal<?php echo e($empleado->Id); ?>"><img
                                                src="<?php echo e(asset('images/historial.png')); ?>" alt="Historial"
                                                style="width: 40px; height: 40px;" />
                                            Historial
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="historialModal<?php echo e($empleado->Id); ?>" tabindex="-1"
                                            aria-labelledby="historialModalLabel<?php echo e($empleado->Id); ?>" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="historialModalLabel<?php echo e($empleado->Id); ?>">
                                                            Historial de fechas de Bajas y Reingresos</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <table>
                                                            <thead class="text-center">
                                                                <tr>
                                                                    <th>Fecha de Ingreso</th>
                                                                    <th>Fecha de Baja</th>
                                                                    <th>Fecha de Reingreso</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody class="text-center">
                                                                
                                                                <?php
                                                                    $fechasReingreso = explode(
                                                                        ',',
                                                                        $empleado->FechasReingreso,
                                                                    );
                                                                    $fechasBaja = explode(',', $empleado->FechasBaja);

                                                                    // Obtener el total de fechas para iterar
                                                                    $totalFechas = max(
                                                                        count($fechasReingreso),
                                                                        count($fechasBaja),
                                                                    );
                                                                ?>

                                                                
                                                                <?php for($i = 0; $i < $totalFechas; $i++): ?>
                                                                    <tr>
                                                                        
                                                                        <?php if($i === 0): ?>
                                                                            <td rowspan="<?php echo e($totalFechas); ?>">
                                                                                <?php echo e($empleado->FechaIngreso); ?></td>
                                                                        <?php endif; ?>

                                                                        
                                                                        <td><?php echo e(isset($fechasBaja[$i]) ? $fechasBaja[$i] : ''); ?>

                                                                        </td>

                                                                        
                                                                        <td><?php echo e(isset($fechasReingreso[$i]) ? $fechasReingreso[$i] : ''); ?>

                                                                        </td>
                                                                    </tr>
                                                                <?php endfor; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td> <a href="<?php echo e(route('empleados.edit', ['Id' => $empleado->Id])); ?>"
                                            class="btn btn-warning text-white">Actualizar</a></td>
                                    <td>
                                        <button type="button" class="btn btn-danger"
                                            onclick="confirmDelete(<?php echo e($empleado->Id); ?>)">
                                            Eliminar
                                        </button>
                                    </td>
                                    <!-- Modal de confirmación de eliminación -->
                                    <div class="modal fade" id="confirmDeleteModal<?php echo e($empleado->Id); ?>" tabindex="-1"
                                        role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmación de
                                                        Eliminación</h5>

                                                </div>
                                                <div class="modal-body">
                                                    <div class="text-center">
                                                        <img src="<?php echo e(asset('images/advertencia.png')); ?>" alt="Agregar"
                                                            style="width: 130px; height: 130px;" />

                                                    </div>
                                                    <br>
                                                    <div class="text-center">
                                                        <h4> ¿Estás seguro de que deseas eliminar este empleado?</h4>
                                                    </div>
                                                    <br> Esta acción <strong>eliminará todos</strong> los registros
                                                    relacionados de forma permanente.
                                                </div>
                                                <div class="modal-footer">

                                                    <form action="<?php echo e(route('empleados.destroy', $empleado->Id)); ?>"
                                                        method="POST" id="deleteForm<?php echo e($empleado->Id); ?>">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('DELETE'); ?>
                                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>


                    <div class="d-flex justify-content-between mt-4">
                        <div>
                            <a href="<?php echo e(route('empleados.view')); ?>" class="btn btn-secondary">Volver</a>
                        </div>
                    </div>



                </div>

            </div>
            <script>
                $(document).ready(function() {
                    $('#empleadosActivos').DataTable({
                        "language": {
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros"
                        },
                        "lengthMenu": [
                            [5, 10, 15, 25, 50, -1],
                            [5, 10, 15, 25, 50, "All"]
                        ],
                        "pageLength": 5, // Mostrar 6 registros por página por defecto
                        "columnDefs": [{
                            "targets": 0, // Índice de la columna a ocultar (0-indexed)
                            "visible": false // Ocultar la columna
                        }]
                    });
                });

                function confirmDelete(id) {
                    $('#confirmDeleteModal' + id).modal('show');
                }
            </script>
        </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/empleados/list.blade.php ENDPATH**/ ?>