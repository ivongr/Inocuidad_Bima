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
        <?php if(session('error')): ?>
        <div class="alert alert-danger">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

        <div class="col-md-9 col-lg-10">
       

            <div class="container mt-4">
                <div class="row">
                    <h2>  <img src="<?php echo e(asset('images/listacolor.png')); ?>"
                        alt="Agregar" style="width: 35px; height: 35px;" />
                        Lista Empleados  Baja</h2>

                    <form class="form-inline" method="get">

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

                        <?php if($buscarpor): ?>
                        <input type="hidden" name="pdf" value="1">
                        <?php endif; ?>
                    </form>



                </div>
                <table style="margin-top: 20px;" id="empleadosBajas" class="display" style="width:100% ">
                    <thead  class="text-center">
                        <tr class="text-center">
                            <th>Número de Nómina</th>
                            <th>Nombre Completo</th>

                            <th>Número de Seguridad</th>
                            <th>RFC</th>
                            <th>Área</th>
                            <th>Fecha Baja</th>
                            <th>Historial de Fechas</th> <!-- Nueva columna -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $bajas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $baja): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="text-center">
                            <td><?php echo e($baja->NumNomina); ?></td>
                            <td><?php echo e($baja->nombre_completo); ?></td>
                            <td><?php echo e($baja->NumSeguridad); ?></td>
                            <td><?php echo e($baja->Rfc); ?></td>
                            <td><?php echo e($baja->nombre_area); ?></td>
                            <td><?php echo e($baja->FechaBaja); ?></td>
                            <td> <!-- Nueva columna -->
                                <button type="button" class="btn" style="background-color: #ff9c78; color: white;"
                                    data-bs-toggle="modal" data-bs-target="#historialModal<?php echo e($baja->Id); ?>"><img src="<?php echo e(asset('images/historial.png')); ?>"
                                    alt="Historial" style="width: 40px; height: 40px;" />
                                    Historial
                                </button>
                                <!-- Modal -->
                                <div class="modal fade" id="historialModal<?php echo e($baja->Id); ?>" tabindex="-1"
                                    aria-labelledby="historialModalLabel<?php echo e($baja->Id); ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="historialModalLabel<?php echo e($baja->Id); ?>">
                                                    Historial de fechas de Bajas y Reingresos</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                            $fechasReingreso = explode(',', $baja->FechasReingreso);
                                                            $fechasBaja = explode(',', $baja->FechasBaja);

                                                            // Obtener el total de fechas para iterar
                                                            $totalFechas = max(count($fechasReingreso), count($fechasBaja));
                                                        ?>

                                                        
                                                        <?php for($i = 0; $i < $totalFechas; $i++): ?>
                                                            <tr>
                                                                
                                                                <?php if($i === 0): ?>
                                                                    <td rowspan="<?php echo e($totalFechas); ?>"><?php echo e($baja->FechaIngreso); ?></td>
                                                                <?php endif; ?>

                                                                
                                                                <td><?php echo e(isset($fechasBaja[$i]) ? $fechasBaja[$i] : ''); ?></td>

                                                                
                                                                <td><?php echo e(isset($fechasReingreso[$i]) ? $fechasReingreso[$i] : ''); ?></td>
                                                            </tr>
                                                        <?php endfor; ?>
                                                    </tbody>
                                                </table>





                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </td>


                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-end">
                        <?php echo e($bajas->onEachSide(1)->links('pagination::bootstrap-4')); ?>

                    </ul>
                </nav>
                <div class="d-flex justify-content-between mt-4">
                    <div>
                        <a href="<?php echo e(route('empleados.list')); ?>" class="btn btn-secondary">Volver</a>
                    </div>

            </div>
            <script>
                $(document).ready(function() {
                    $('#empleadosBajas').DataTable({
                        "language": {
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros"

                        },
                        "lengthMenu": [
                            [5, 10, 15, 25, 50, -1],
                            [6, 10, 15, 25, 50, "All"]
                        ],
                        "pageLength": 5 // Mostrar 6 registros por página por defecto
                    });
                });

            </script>
        </div>
    </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/empleados/listBaja.blade.php ENDPATH**/ ?>