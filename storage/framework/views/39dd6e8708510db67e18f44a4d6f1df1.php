
<link rel="stylesheet" href="/css/app.css">


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
                    <table style="margin-top: 20px;" id="areas" class="display" style="width:100% ">
                      
                        <thead class="text-center">
                            <tr>
                                <th>Nombre</th>
                                <th>Actualizar</th> <!-- Nueva columna -->
                                <th>Eliminar</th> <!-- Nueva columna -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="text-center">
                                      <!-- Campo oculto para el ID -->
       <!-- <td style="display: none;"><?php echo e($area->Id); ?></td>-->
                                    <td><?php echo e($area->Nombre); ?></td>
                                    <!--concatenar el ID-->
                                 
                                    <td> <a href="<?php echo e(route('areas.edit', ['Id' => $area->Id])); ?>" class="btn btn-warning text-white">Actualizar</a></td>
                                    <td>
                                        <button type="button" class="btn btn-danger" onclick="confirmDelete(<?php echo e($area->Id); ?>)">
                                            Eliminar
                                        </button>
                                    </td>
                                    <!-- Modal de confirmación de eliminación -->
                                    <div class="modal fade" id="confirmDeleteModal<?php echo e($area->Id); ?>" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmación de Eliminación</h5>
        
                                                </div>
                                                <div class="modal-body">
                                                    ¿Estás seguro de que deseas eliminar esta área?
                                                    <br> Esta acción <strong>eliminará todos</strong> los registros relacionados de forma permanente.
                                                </div>
                                                <div class="modal-footer">
        
                                                    <form action="<?php echo e(route('areas.destroy', $area->Id)); ?>" method="POST" id="deleteForm<?php echo e($area->Id); ?>">
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

                </div>
                <a href="<?php echo e(route('areas.view')); ?>" class="btn btn-secondary">Regresar</a>
            </div>
            <script>
                $(document).ready(function () {
                    $('#areas').DataTable({
                        "language": {
                            "sLengthMenu": "Mostrar _MENU_ registros",
                            "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ registros"
    
                        },
                        "lengthMenu": [
                            [5, 10, 15, 25, 50, -1],
                            [5, 10, 15, 25, 50, "All"]
                        ],
                        "pageLength": 5 // Mostrar 6 registros por página por defecto
                    });
                });
    
                
    // Mostrar el spinner cuando se inicia la carga de la página
    document.addEventListener("DOMContentLoaded", () => {
        const loader = document.querySelector(".loader");
        loader.classList.add("loader-hidden");
    });
    
    // Ocultar el spinner cuando se haya cargado completamente la página
    window.addEventListener("load", () => {
        const loader = document.querySelector(".loader");
        loader.classList.add("loader-hidden");
    });
    
    function confirmDelete(id) {
        $('#confirmDeleteModal' + id).modal('show');
    }
            </script>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/areas/list.blade.php ENDPATH**/ ?>