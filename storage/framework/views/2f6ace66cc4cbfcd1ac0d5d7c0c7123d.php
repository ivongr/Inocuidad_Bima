<?php $__env->startSection('content'); ?>
    <div class="container">


        <div class="row">
            <?php echo $__env->make('navbar.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="col-md-9 col-lg-10">
                <div class="container mt-4">
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                    <h2> <img src="<?php echo e(asset('images/agregarcolor.png')); ?>" alt="Agregar" style="width: 35px; height: 35px;" />
                        <b> Alta Empleado</b>
                    </h2>

                    <!---COMENTAR EN UNA PLANTILLA BLADE--->
                    
                    
                    
                    
                    
                    
                    
                    
                    


                    <form action="<?php echo e(url('empleados')); ?>" method="post">
                        <?php echo csrf_field(); ?>

                        <fieldset>
                            <legend class="text-center"><b>Datos Personales</b></legend>

                            <div class="row">
                                <div class="col-md-4">

                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Número de Nómina</b></label>
                                    </div>
                                    <input type="text" class="form-control" name="numNomina" id="numNomina"
                                        value="<?php echo e(old('NumNomina')); ?>" required>
                                    <?php $__errorArgs = ['numNomina'];
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
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Nombre</b></label>
                                    </div>
                                    <input type="text" class="form-control" name="Nombre" id="Nombre"
                                        value="<?php echo e(old('Nombre')); ?>" required>
                                        <?php $__errorArgs = ['Nombre'];
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
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Apellido Paterno</b></label>
                                    </div>
                                    <!--old es de acuerdo al nombre de la base de datos-->
                                    <input type="text" class="form-control" name="ApePat" id="ApePat"
                                        value="<?php echo e(old('ApePat')); ?>" required>
                                        <?php $__errorArgs = ['ApePat'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <br>
                                </div>

                                <div class="col-md-4">

                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">

                                        <label class="d-block text-center w-100"> <b>Apellido Materno</b></label>
                                    </div>
                                    <input type="text" class="form-control" name="ApeMat" id="ApeMat"
                                        value="<?php echo e(old('ApeMat')); ?>" required>
                                        <?php $__errorArgs = ['ApeMat'];
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

                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Número de Seguridad</b></label>
                                    </div>
                                    <input type="text" class="form-control" name="NumSeguridad" id="NumSeguridad"
                                        value="<?php echo e(old('NumSeguridad')); ?>" required>
                                        <?php $__errorArgs = ['NumSeguridad'];
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
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>RFC</b></label>
                                    </div>
                                    <input type="text" class="form-control" name="Rfc" id="Rfc"
                                        value="<?php echo e(old('Rfc')); ?>" required>
                                        <?php $__errorArgs = ['Rfc'];
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
                        </fieldset>

                        <fieldset>
                            <br>


                            <div class="row">

                                <br>

                                <div class="col-md-5">
                                    <div class="mb-3 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Área</b></label>
                                    </div>
                                    <select class="form-select text-center" name="area" id="area" required>
                                        <option value="">Seleccionar área</option>
                                        <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>"><?php echo e($nombre); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>


                                <div class="col-md-5">
                                    <div class="mb-3 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Fecha de Ingreso</b></label>
                                    </div>
                                    <input type="date" class="form-control text-center" name="fechaingreso"
                                        id="fechaingreso" value="<?php echo e(old('fechaingreso')); ?>" required>
                                </div>

                            </div>
                            <br>
                        </fieldset>



                        <br>
                        <div class="row mt-4  text-center">
                            <div class="col-md-12">
                                <a
                                    href="<?php echo e(route('empleados.view')); ?>"class="btn btn-secondary mx-4"><?php echo e(__('Volver')); ?></a>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!---<script>
            window.setTimeout(function() {
                $(".alert").fadeTo(50000, 0).slideUp(50000, function() {
                    $(this).remove();
                });
            }, 2000);
        </script>----->

        <script></script>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/empleados/create.blade.php ENDPATH**/ ?>