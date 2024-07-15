

<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <?php echo $__env->make('navbar.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="col-md-9 col-lg-10">
                <div class="container mt-4">
                    <div class="row text-center">
                        <div class="col">
                            <img src="<?php echo e(asset('images/denegado.png')); ?>" alt="Denegado" style="width: 120px; height: 120px;" />
                            <h1>Error de permiso</h1>
                            <p><?php echo e(session('error')); ?></p>
                            <a href="<?php echo e(url('/home')); ?>"  class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Volver a la página principal</a>
                        
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/error-permiso.blade.php ENDPATH**/ ?>