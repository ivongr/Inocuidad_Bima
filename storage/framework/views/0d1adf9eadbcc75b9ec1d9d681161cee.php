<?php $__env->startSection('content'); ?>
    <div class="container">

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
                        <h2> <img src="<?php echo e(asset('images/editar.png')); ?>" alt="Agregar" style="width: 55px; height: 55px;" />
                            Editar Empleado</h2>


                        <!-- PARA PONER LAS ALERTAS EN EL FORMULARIO  -->

                        <?php if($errors->any()): ?>
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <ul>
                                    <!--QUE IMPRIMA UNA LISTA DE LOS ERRORES-->
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <form action="<?php echo e(route('horas.update', ['Id' => $Id])); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <!-- Campos comunes a las tres tablas -->
                            <label for="fecha">Fecha:</label>
                            <input type="date" id="fecha" name="fecha" value="<?php echo e($fecha); ?>" required>
                        
                            <!-- Campos específicos de HorasExtras -->
                            <label for="hora_inicio">Hora de Inicio:</label>
                            <input type="time" id="hora_inicio" name="hora_inicio" value="<?php echo e($hora_inicio); ?>" required>
                            <label for="hora_fin">Hora de Fin:</label>
                            <input type="time" id="hora_fin" name="hora_fin" value="<?php echo e($hora_fin); ?>" required>
                        
                            <!-- Campos específicos de Entradas -->
                            <label for="hora_entrada">Hora de Entrada:</label>
                            <input type="time" id="hora_entrada" name="hora_entrada" value="<?php echo e($hora_entrada); ?>" required>
                        
                            <!-- Campos específicos de Salidas -->
                            <label for="hora_salida">Hora de Salida:</label>
                            <input type="time" id="hora_salida" name="hora_salida" value="<?php echo e($hora_salida); ?>" required>
                        
                        
                        

                        <div class="text-center">
                            <a href="<?php echo e(route('empleados.view')); ?>" class="btn btn-secondary">Volver</a>
                            <button type="submit" class="btn btn-success ml-3">Guardar</button>

                        </div>
                        </form>
                    </div>
                    </main>
                <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/horas/edit.blade.php ENDPATH**/ ?>