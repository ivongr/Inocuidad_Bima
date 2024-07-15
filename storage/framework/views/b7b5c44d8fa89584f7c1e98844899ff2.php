<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <?php echo $__env->make('navbar.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="col-md-9 col-lg-10">
            
            <div class="container mt-4">

                <div class="row row-cols-1 row-cols-md-2">
                    <?php if(auth()->user()->hasRole('administrador') || auth()->user()->hasRole('inocuidad')): ?>
                    <div class="col mb-5">
                        <a href="<?php echo e(route('horas.horasEntradas')); ?>">
                            <div class="rounded text-center">
                                <img src="<?php echo e(asset('images/entradacolor.png')); ?>" class="img-fluid" alt="...">
                                <h1 class="fs-5 small fw-bold">REGISTRAR ENTRADAS</h1>
                            </div>
                        </a>

                    </div>
                    <div class="col mb-5">
                        <a href="<?php echo e(route('horas.horasSalidas')); ?>">
                        <div class="rounded text-center">
                            <img src="<?php echo e(asset('images/salidascolor.png')); ?>" class="img-fluid" alt="...">
                            <h1 class="fs-5 small fw-bold">REGISTRAR SALIDAS</h1>
                        </div>
                    </a>

                    </div>
                    <div class="col mb-5">
                        <a href="<?php echo e(route('horas.horasExtras')); ?>">
                        <div class="rounded text-center">
                            <img src="<?php echo e(asset('images/horasextracolor.png')); ?>"class="img-fluid" alt="...">
                            <h1 class="fs-5 small fw-bold" >REGISTRAR HORAS EXTRAS</h1>
                        </div>
                    </a>
                    </div>
                    <?php endif; ?>
                    <div class="col mb-5">
                        <a href="<?php echo e(route('horas.list')); ?>">
                        <div class="rounded text-center">
                            <img src="<?php echo e(asset('images/listaasistenciacolor.png')); ?>" class="img-fluid" alt="...">
                            <h1 class="fs-5 small fw-bold">LISTA DE ASISTENCIA</h1>
                        </div>
                    </a>

                    </div>

                </div>
            </div>

        </div>
       
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/horas/view.blade.php ENDPATH**/ ?>