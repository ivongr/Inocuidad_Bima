<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="row">
            <?php echo $__env->make('navbar.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="col-md-9 col-lg-10">

                <div class="container mt-4">

                    <h2>  <img src="<?php echo e(asset('images/agregarvacacolor.png')); ?>"
                        alt="Agregar" style="width: 35px; height: 35px;" />
                   Registrar Área</h2>


                   

                    <form action="<?php echo e(url('areas')); ?>" method="post">

                        <!-- GENERAR UN EVENTO OCULTO-->
                        <?php echo csrf_field(); ?>


                        <div class="mb-3 row">
                            <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                <label class="d-block text-center w-100"> <b>Nombre :</b></label>
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="nombre" id="nombre"
                                    value="<?php echo e(old('nombre')); ?>" required>
                                    <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                        </div>


                        <br>
                        <div class="row mt-4  text-center">
                            <div class="col-md-12">

                        <a href="<?php echo e(route('areas.view')); ?>" class="btn btn-secondary mx-4"><?php echo e(__('Regresar')); ?></a>


                        <button type="submit" class="btn btn-success ">Guardar</button>
                    </div>
                </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/areas/create.blade.php ENDPATH**/ ?>