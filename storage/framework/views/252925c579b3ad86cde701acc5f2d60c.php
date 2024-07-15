<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <?php echo $__env->make('navbar.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="col-md-9 col-lg-10">
                
                <div class="container mt-4">
                    <h2> <img src="<?php echo e(asset('images/agregarvacacolor.png')); ?>" alt="Agregar"
                            style="width: 35px; height: 35px;" />
                        Vacaciones</h2>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    <?php endif; ?>

                    <form action="<?php echo e(url('vacaciones')); ?>" method="post">
                        <?php echo csrf_field(); ?>

                        <fieldset>


                            <div class="row">
                                <div class="col-md-5">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Número</b></label>
                                    </div>
                                    <select class="form-select text-center" name="numNomina" id="numNomina" required>
                                        <option value="">Seleccionar número de nómina</option>
                                        <?php $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $NumNomina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>"><?php echo e($NumNomina); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                </div>

                            </div>

                        </fieldset>
                        <fieldset>
                            <legend class="text-center"><b>Periodo Vacacional</b></legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Empieza</b></label>
                                    </div>
                                    <input type="date" class="form-control text-center" name="FechaInicio" id="FechaInicio"
                                        value="<?php echo e(old('FechaInicio')); ?>" required onchange="calcularTotalDias()">
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Termina</b></label>
                                    </div>
                                    <input type="date" class="form-control text-center" name="FechaFin" id="FechaFin"
                                        value="<?php echo e(old('FechaFin')); ?>" required onchange="calcularTotalDias()">
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100"> <b>Total de Dias</b></label>
                                    </div>
                                    <input type="text" class="form-control" name="TotalDias" id="TotalDias" value="<?php echo e(old('TotalDias')); ?>"
                                        required readonly>
                                </div>
                            </div>
                        </fieldset>
                        



                <br>
                <div class="row mt-4  text-center">
                    <div class="col-md-12">
                        <a href="<?php echo e(route('vacaciones.view')); ?>" class="btn btn-secondary mx-4"><?php echo e(__('Volver')); ?></a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <script>
       /* function calcularTotalDias() {
            let fechaInicio = new Date(document.getElementById('FechaInicio').value);
            let fechaFin = new Date(document.getElementById('FechaFin').value);
            let diffTime = Math.abs(fechaFin - fechaInicio);
            let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            document.getElementById('TotalDias').value = diffDays;
        }*/

    function calcularTotalDias() {
        let fechaInicio = new Date(document.getElementById('FechaInicio').value);
        let fechaFin = new Date(document.getElementById('FechaFin').value);
    // Sumar 1 para incluir el día final en el cálculo
        let diffTime = Math.abs(fechaFin - fechaInicio) + (1000 * 60 * 60 * 24);
        let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        document.getElementById('TotalDias').value = diffDays;
    }

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/vacaciones/create.blade.php ENDPATH**/ ?>