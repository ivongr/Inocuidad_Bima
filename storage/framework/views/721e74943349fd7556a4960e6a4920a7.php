<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <?php echo $__env->make('navbar.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="col-md-9 col-lg-10">
               
            <div class="container mt-5">

                <div class="row row-cols-1 row-cols-md-2">
                    <?php if(auth()->user()->hasRole('administrador') || auth()->user()->hasRole('inocuidad')): ?>
                    <div class="col mb-5">
                        <a href="<?php echo e(route('empleados.create')); ?>">
                            <div class="rounded text-center">
                                <img src="<?php echo e(asset('images/agregarcolor.png')); ?>" class="img-fluid" alt="...">
                                <h1 class="fs-5 small fw-bold">ALTA</h1>
                            </div>
                        </a>
                    </div>
                    <div class="col mb-5">
                        <a href="<?php echo e(route('empleados.baja')); ?>">
                        <div class="rounded text-center">
                            <img src="<?php echo e(asset('images/bajacolor.png')); ?>" class="img-fluid" alt="...">
                            <h1 class="fs-5 small fw-bold">BAJA</h1>
                        </div>
                        </a>
                    </div>
                    <div class="col mb-5">
                        <a href="<?php echo e(route('empleados.reingreso')); ?>">
                        <div class="rounded text-center">
                            <img src="<?php echo e(asset('images/volvercolor.png')); ?>" class="img-fluid" alt="...">
                            <h1 class="fs-5 small fw-bold" >REINGRESO</h1>
                        </div>
                    </a>
                    </div>
                    <?php endif; ?>
                    <div class="col mb-5">
                        <a href="<?php echo e(route('empleados.list')); ?>">
                        <div class="rounded text-center">
                            <img src="<?php echo e(asset('images/listacolor.png')); ?>" class="img-fluid" alt="...">
                            <h1 class="fs-5 small fw-bold">LISTA</h1>
                        </div>
                    </a>

                    </div>

                </div>
            </div>
          
        </div>
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/empleados/view.blade.php ENDPATH**/ ?>