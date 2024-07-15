<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <?php echo $__env->make('navbar.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="col-md-9 col-lg-10 mx-auto">
         
            <div class="container mt-4">
                <div class="text-center">
                    <img src="<?php echo e(asset('images/exito.png')); ?>" class="img-fluid" alt="Exito" style="width: 150px; height: 150px;" />
                    <br>
                    <h2><b>   <br><?php echo e($msg); ?></b></h2>
                    <br>

                    <a href="<?php echo e(route('horas.view')); ?>"  class="link-primary link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">Volver a la página principal</a>
                </div>
            </div>
        </div>
    </div>
   
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/Horas/message.blade.php ENDPATH**/ ?>