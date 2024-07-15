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
                <h2> <img src="<?php echo e(asset('images/editar.png')); ?>"
                        alt="Agregar" style="width: 55px; height: 55px;" /> Editar Empleado</h2>

        
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

            <form action="<?php echo e(route('empleados.update', $empleado->Id)); ?>" method="post"  enctype="multipart/form-data">
                <input type="hidden" name="Id" value="<?php echo e($empleado->Id); ?>">

                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="mb-3 row">
                    <label for="NumNomina" class="col-sm-2 col-form-label">Número de Nómina:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="NumNomina" id="NumNomina"
                            value="<?php echo e($empleado->NumNomina); ?>" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="Nombre" class="col-sm-2 col-form-label">Nombre:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="Nombre" id="Nombre" value="<?php echo e($empleado->Nombre); ?>"
                            required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="ApePat" class="col-sm-2 col-form-label">Apellido Paterno:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="ApePat" id="ApePat" value="<?php echo e($empleado->ApePat); ?>"
                            required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="ApeMat" class="col-sm-2 col-form-label">Apellido Materno:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="ApeMat" id="ApeMat"
                            value="<?php echo e($empleado->ApeMat); ?>" required>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="NumSeguridad" class="col-sm-2 col-form-label">Número de Seguridad:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="NumSeguridad" id="NumSeguridad"
                            value="<?php echo e($empleado->NumSeguridad); ?>">
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="Rfc" class="col-sm-2 col-form-label">RFC:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="Rfc" id="Rfc"
                            value="<?php echo e($empleado->Rfc); ?>">
                    </div>
                </div>

                <!-- SELECT -->
                <!-- SELECT -->
<div class="mb-3 row">
    <label for="area" class="col-sm-2 col-form-label">Área:</label>
    <div class="col-sm-5">
        <select class="form-select" name="area" id="area" required>
            <option value="">Seleccionar área</option>
            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($area->Id); ?>" <?php if($empleado->area->Id == $area->Id): ?> <?php echo e('selected'); ?> <?php endif; ?>><?php echo e($area->Nombre); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        
    </div>
</div>


                <div class="mb-3 row">
                    <label for="fechaingreso" class="col-sm-2 col-form-label">Fecha de Ingreso:</label>
                    <div class="col-sm-5">
                        <input type="date" class="form-control" name="fechaingreso" id="fechaingreso"
                            value="<?php echo e($empleado->FechaIngreso); ?>">
                    </div>
                </div>
<div class="text-center">
                <a href="<?php echo e(route('empleados.view')); ?>" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-success ml-3">Guardar</button>

            </div>
            </form>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/empleados/edit.blade.php ENDPATH**/ ?>