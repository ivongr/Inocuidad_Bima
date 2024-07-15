

<?php $__env->startSection('content'); ?>
    <main>
        <div class="container py-4">
            <h2>Editar area</h2>

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

            <?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('areas.update', $areas->Id)); ?>" role="form" enctype="multipart/form-data" >

    <input type="hidden" name="Id" value="<?php echo e($areas->Id); ?>">

    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>
                            
                
                <div class="mb-3 row">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre:</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo e($areas->Nombre); ?>"
                            required>
                    </div>
                </div>

                


       
                <a href="<?php echo e(route('areas.view')); ?>" class="btn btn-secondary">Volver</a>
                <button type="submit" class="btn btn-success ml-3">Guardar</button>

            </form>
        </div>
    </main>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/areas/edit.blade.php ENDPATH**/ ?>