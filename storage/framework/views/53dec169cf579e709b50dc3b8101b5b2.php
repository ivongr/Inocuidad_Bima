<html lang="es">
<?php $__env->startSection('content'); ?>
    <div class="container">
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

        <div class="row">
            <?php echo $__env->make('navbar.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="col-md-9 col-lg-10">

                <div class="container mt-4">
                    <div class="row">
                        <h2>
                            <img src="<?php echo e(asset('images/listaasistenciacolor.png')); ?>" alt="Agregar"
                                style="width: 35px; height: 35px;" />
                            Lista Incapacidades
                        </h2>

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

                                <div class="form-group">
                                    <label for="fecha_inicio">Fecha de inicio:</label>
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                                </div>
                                <div class="form-group">
                                    <label for="fecha_fin">Fecha de fin:</label>
                                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                                </div>

                            </div>
                            <div class="d-flex justify-content-end mt-2">
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
                                <?php if($buscarpor || $fecha_inicio || $fecha_fin): ?>
                                    <a href="<?php echo e(route('exportAreaIncapacidad', ['buscarpor' => $buscarpor, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin])); ?>"
                                        class="btn btn-success btn-custom me-2" style="background: #22C55E">
                                        <img src="<?php echo e(asset('images/excel.png')); ?>" class="me-2"> Exportar a Excel
                                    </a>
                                <?php else: ?>
                                    <a href="/exportarIncapacidad" class="btn btn-success btn-custom me-2" style="background: #22C55E">
                                        <img src="<?php echo e(asset('images/excel.png')); ?>" class="me-2"> Exportar a Excel
                                    </a>
                                <?php endif; ?>

                                <a href="<?php echo e(route('imprimirAreaIncapacidad.pdf', ['buscarpor' => $buscarpor, 'fecha_inicio' => $fecha_inicio, 'fecha_fin' => $fecha_fin])); ?>"
                                    class="btn btn-danger btn-custom me-2" style="background: #EF4444">
                                    <img src="<?php echo e(asset('images/pdf.png')); ?>" class="me-2"> Exportar a PDF
                                </a>


                            </div>
                        </form>
                    </div>

                    <table style="margin-top: 20px;" id="incapacidades" class="display" style="width:100% ">
                        <br>
                        <thead class="text-center">

                            <tr>
                                <th>Id</th>
                                <th>Número de Nómina</th>
                                <th>Nombre Completo</th>
                                <th>Área</th>
                                <th>Fecha de Inicio</th>
                                <th>Fecha de Fin</th>
                                <th>Días</th>
                                <th>Actualizar</th>
                                <th>Eliminar</th>

                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php $__currentLoopData = $incapacidades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $incapacidad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>

                                    <td><?php echo e($incapacidad->Id); ?></td>
                                    <td><?php echo e(optional($incapacidad->empleado)->NumNomina); ?></td>
                                    <td><?php echo e(optional($incapacidad->empleado)->Nombre); ?>

                                        <?php echo e(optional($incapacidad->empleado)->ApePat); ?>

                                        <?php echo e(optional($incapacidad->empleado)->ApeMat); ?></td>

                                    <td><?php echo e(optional($incapacidad->empleado->area)->Nombre); ?></td>

                                    <td><?php echo e($incapacidad->FechaInicio); ?></td>
                                    <td><?php echo e($incapacidad->FechaFin); ?></td>
                                    <td><?php echo e($incapacidad->TotalDias); ?></td>

                                    <td> <a href="<?php echo e(route('incapacidad.edit', ['Id' => $incapacidad->Id])); ?>"
                                            class="btn btn-warning text-white">Actualizar</a></td>
                                    <td>
                                        <button type="button" class="btn btn-danger"
                                            onclick="confirmDelete(<?php echo e($incapacidad->Id); ?>)">
                                            Eliminar
                                        </button>
                                    </td>
                                    <!-- Modal de confirmación de eliminación -->
                                    <div class="modal fade" id="confirmDeleteModal<?php echo e($incapacidad->Id); ?>" tabindex="-1"
                                        role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmación de
                                                        Eliminación</h5>

                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que deseas eliminar este registró?
                                                    <br> Esta acción <strong>eliminará el </strong> registró de forma
                                                    permanente.
                                                </div>
                                                <div class="modal-footer">

                                                    <form action="<?php echo e(route('incapacidad.destroy', $incapacidad->Id)); ?>"
                                                        method="POST" id="deleteForm<?php echo e($incapacidad->Id); ?>">
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
                            <a href="<?php echo e(route('incapacidad.view')); ?>" class="btn btn-secondary">Volver</a>
                        </div>

                    </div>
                </div>

            </div>
            <script>
                $(document).ready(function() {
                    $('#incapacidades').DataTable({
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
                        }],
                        "pageLength": 5 // Mostrar 6 registros por página por defecto
                    });
                });
                // Espera a que el DOM esté completamente cargado
                document.addEventListener("DOMContentLoaded", function() {
                    // Obtener los elementos de los campos de fecha
                    const fechaInicioInput = document.getElementById('fecha_inicio');
                    const fechaFinInput = document.getElementById('fecha_fin');

                    // Verificar si hay valores guardados en el localStorage y establecerlos en los campos de fecha
                    if (localStorage.getItem('fecha_inicio')) {
                        fechaInicioInput.value = localStorage.getItem('fecha_inicio');
                    }
                    if (localStorage.getItem('fecha_fin')) {
                        fechaFinInput.value = localStorage.getItem('fecha_fin');
                    }

                    // Escuchar cambios en los campos de fecha y guardar los valores en el localStorage
                    fechaInicioInput.addEventListener('change', function() {
                        localStorage.setItem('fecha_inicio', fechaInicioInput.value);
                    });

                    fechaFinInput.addEventListener('change', function() {
                        localStorage.setItem('fecha_fin', fechaFinInput.value);
                    });
                });


                function confirmDelete(id) {
                    $('#confirmDeleteModal' + id).modal('show');
                }
            </script>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/incapacidad/list.blade.php ENDPATH**/ ?>