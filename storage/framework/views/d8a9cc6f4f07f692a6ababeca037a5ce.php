<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <?php echo $__env->make('navbar.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="col-md-9 col-lg-10">
               
                <div class="container mt-4">

                    <div class="container">
                        <div class="row">
                            <h2>  <img src="<?php echo e(asset('images/volvercolor.png')); ?>"
                                alt="Agregar" style="width: 35px; height: 35px;" />
                                <b>ReIngreso Empleados</b></h2>
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
                            <form action="<?php echo e(url('/storeReIngreso')); ?>" method="post">
                                <?php echo csrf_field(); ?>

                                <fieldset>


                                    <div class="row">

                                        <div class="col-md-3">
                                            <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                                <label class="d-block text-center w-100"> <b>Número de ReIngreso</b></label>
                                            </div>
                                            <select class="form-select" name="numReIngreso" id="numReIngreso" required>
                                                <option value="">Seleccionar</option>
                                                <?php $__currentLoopData = $numReIngreso; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $Nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($id); ?>"><?php echo e($Nombre); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>


                                        <div class="col-md-3">
                                            <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                                <label class="d-block text-center w-100"> <b>Número de Nómina</b></label>
                                            </div>
                                            <select class="form-select" name="numNomina" id="Id_empleado" required>
                                                <option value="">Seleccionar empleado</option>
                                                <?php $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $NumNomina): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>"><?php echo e($NumNomina); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                        </div>


                                        <div class="col-md-3">

                                            <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                                <label class="d-block text-center w-100"> <b>Fecha de ReIngreso</b></label>
                                            </div>
                                            <input type="date" class="form-control text-center" name="FechaReIngreso" id="FechaReIngreso"
                                                value="<?php echo e(old('FechaReIngreso')); ?>" required>
                                        </div>


                                    </div>
                                </fieldset>

                                <fieldset>
                                    <br>
                                    <div id="infoEmpleado">
                                        <legend>Información del empleado</legend>
                                    </div>
                                </fieldset>


                <br>
                <div class="row mt-4  text-center">
                    <div class="col-md-12">
                        <a href="<?php echo e(route('empleados.view')); ?>" class="btn btn-secondary mx-4"><?php echo e(__('Volver')); ?></a>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </div>
                </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.getElementById('Id_empleado').addEventListener('change', function() {
               var numNomina = this.value;
               if (numNomina !== '') {
                   // Realizar una solicitud AJAX para obtener los datos del empleado
                   var xhttp = new XMLHttpRequest();
                   xhttp.onreadystatechange = function() {
                       if (this.readyState == 4 && this.status == 200) {
                           // Actualizar el contenido del div con id infoEmpleado con los datos del empleado
                           var empleado = JSON.parse(this.responseText);
                           document.getElementById('infoEmpleado').innerHTML = `
                               <p>Nombre: ${empleado.Nombre} ${empleado.ApePat} ${empleado.ApeMat}</p>

                               <p>Número de Seguridad: ${empleado.NumSeguridad}</p>
                               <p>RFC: ${empleado.Rfc}</p>
                               <p>Fecha de Ingreso: ${empleado.FechaIngreso}</p>
                           `;
                       }
                   };
                   xhttp.open('GET', '<?php echo e(route('getEmpleadoInfo')); ?>?numNomina=' + numNomina, true);
                   xhttp.send();
               } else {
                   // Limpiar el contenido del div infoEmpleado si no se ha seleccionado ningún número de nómina
                   document.getElementById('infoEmpleado').innerHTML = '';
               }
           });



               </script>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/empleados/reingreso.blade.php ENDPATH**/ ?>