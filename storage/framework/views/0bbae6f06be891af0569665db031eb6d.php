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
                    <h2> <img src="<?php echo e(asset('images/listaAdmin.png')); ?>"
                            alt="Lista Usuarios" style="width: 55px; height: 55px;" /> Lista Usuarios</h2>
                </div>
                <br>
                <table style="margin-top: 20px;" id="empleadosActivos" class="display" style="width:100% ">
                    <thead class="text-center">
                        <tr class="text-center">
                            <th>Id</th>
                            <th>Nombre de Usuario</th>
                            <th>Correo</th>
                            <th>Contraseña</th>
                            <th>Rol</th>
                            <th>Acciones</th> <!-- Nueva columna para acciones -->
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="text-center">
                            <td><?php echo e($user->id); ?></td>
                            <td><?php echo e($user->user_name); ?></td>
                            <td><?php echo e($user->user_email); ?></td>
                            <td><?php echo e($user->user_password); ?></td>
                            <td><?php echo e($user->role_name); ?></td>
                            <td> <!-- Nueva celda para el botón de eliminar -->
                                <form action="<?php echo e(route('usuarios.destroy', $user->id)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </td>
                     

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
            $(document).ready(function () {
                $('#empleadosActivos').DataTable({
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



        </script>
    </div>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/usuarios/list.blade.php ENDPATH**/ ?>