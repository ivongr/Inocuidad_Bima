<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">

            <?php echo $__env->make('navbar.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="col-md-9 col-lg-10">
                <h2>  <img src="<?php echo e(asset('images/listacolor.png')); ?>"
                    alt="Agregar" style="width: 35px; height: 35px;" />
                    <b>Lista Incapacidad</b></h2>
                <div class="container mt-6">
                    <div class="col mb-6 text-center">
                        <img src="<?php echo e(asset('images/alerta.png')); ?>"  class="img-fluid" alt="...">
                        <div class="alert alert-warning" role="alert">
                            <b>SIN INFORMACIÓN</b> Selecciona otra opción, por favor.
                        </div>
                    </div>
                </div>
                <a href="<?php echo e(route('incapacidad.list')); ?>" class="btn btn-secondary ">Volver</a>
            </div>

        </div>

    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/incapacidad/listvacia.blade.php ENDPATH**/ ?>