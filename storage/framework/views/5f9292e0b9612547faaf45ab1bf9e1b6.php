<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <?php echo $__env->make('navbar.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="col-md-9 col-lg-10">


            <div class="container mt-4">
                <h2> <img src="<?php echo e(asset('images/horasextracolor.png')); ?>" alt="Agregar" style="width: 35px; height: 35px;" />
                    <b> Registro de Horas Extras  </b> </h2>

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

                <form action="<?php echo e(route('horas.actualizarHorasExtras')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="container mt-4">
                        <div class="row">
                            <div class="col-md-4">
                                <!-- Contenido de la primera sección -->
                                <fieldset>
                                    <legend class="text-center"> <b>Horas </b></legend>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-2 bg-warning-subtle text-warning-emphasis text-center">
                                                <label for="horaInicio" class="form-label d-block text-center w-100"><b>Inicio</b></label>
                                            </div>
                                            <input type="time" class="form-control" name="horaInicio" id="horaInicio" value="<?php echo e(old('horaInicio')); ?>" required onchange="calcularTotalHoras()">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-2 bg-warning-subtle text-warning-emphasis text-center">
                                                <label for="horaFin" class="form-label d-block text-center w-100"><b>Final</b></label>
                                            </div>
                                            <input type="time" class="form-control" name="horaFin" id="horaFin" value="<?php echo e(old('horaFin')); ?>" required onchange="calcularTotalHoras()">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <br>
                                            <div class="mb-2 bg-warning-subtle text-warning-emphasis text-center">
                                                <label for="totalHoras" class="form-label d-block text-center w-100"><b>Total de Horas Extras</b></label>
                                            </div>
                                            <input type="text" class="form-control" name="totalHoras" id="totalHoras" value="<?php echo e(old('totalHoras')); ?>" required readonly>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <br>
                                            <div class="mb-2 bg-warning-subtle text-warning-emphasis text-center">
                                                <label for="fecha" class="form-label  d-block text-center w-100"><b>Fecha</b></label>
                                            </div>
                                            <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo e(old('fecha')); ?>" required onchange="actualizarInfo()">
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-4">
                                <!-- Contenido de la segunda sección -->
                                <fieldset>

                                    <legend class="text-center"> <b>Empleados </b></legend>


                                    <br>
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100">
                                            <b>Ausentes</b></label>
                                    </div>
                                    <textarea id="numNominaTextarea" cols="38"></textarea>
                                    <br>
                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label class="d-block text-center w-100">
                                            <b>Áreas</b></label>

                                    </div>

                                    <div style="overflow-y: scroll; max-height: 200px;">
                                        <select class="form-select" name="area" id="area" required onchange="actualizarInfo()">
                                            <option value="">Seleccionar área</option>
                                            <?php $__currentLoopData = $areas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($id); ?>"><?php echo e($nombre); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>

                                    </div>
                                    <br>

                                    <div class="mb-2 bg-warning-subtle text-warning-emphasis">
                                        <label for="fecha" class="d-block text-center w-100">
                                            <b>Número de Nómina</b></label>

                                    </div>
                                    <div id="numNominaList"></div>
                                </fieldset>
                            </div>

                            <div class="col-md-4">
                                <br>
                                <br>
                                <!-- Contenido de la tercera sección -->
                                <div class="row p-3 mb-2 bg-info-subtle text-info-emphasis">
                                    <div class="col-md-12">
                                        <label for="totalEmpleados" class="form-label"> <b>(Total Empleados: <span
                                                    id="totalEmpleados"><?php echo e($totalEmpleados); ?></span>)</b></label>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="numAusencias" class="form-label"> <b>Ausencias (Total Empleados: <span
                                                    id="numAusencias"><?php echo e($numAusencias); ?></span>)</b></label>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="totalAsistencias" class="form-label"> <b> <span
                                                    id="labelTotalAsistencias"><?php echo e($numAusencias); ?></b> </label>
                                        <input type="hidden" name="totalAsistencias" id="totalAsistencias"
                                            value="<?php echo e($numAusencias); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4  text-center">
                            <div class="col-md-12">
                                <!-- Para separar los botones--->
                                <a href="<?php echo e(route('horas.view')); ?>" class="btn btn-secondary mx-4"><?php echo e(__('Volver')); ?></a>
                                <button type="submit" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
   // Función actualizarInfo
   function actualizarInfo() {
    var fecha = document.getElementById('fecha').value;
    var area = document.getElementById('area').value;

    // Realizar la solicitud AJAX al servidor
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                // Actualizar el formulario con los datos recuperados
                document.getElementById('horaInicio').value = response.horaInicio;
                document.getElementById('horaFin').value = response.horaFin;

                // Actualizar la lista de números de nómina
                document.getElementById('numNominaTextarea').value = response.numNomina.join(', ');

                // Actualizar los checkboxes
                response.numNominaSeleccionados.forEach(function (numNomina) {
                    document.getElementById('numNominaSelect' + numNomina).checked = true;
                });
            } else {
                console.error('Hubo un error al obtener los datos');
            }
        }
    };
    xhr.open('GET', '/vacaciones/datos?fecha=' + fecha + '&area=' + area, true);
    xhr.send();
}

// Función updateNumNominaList
function updateNumNominaList() {
    var areaId = document.getElementById('area').value;

    var numNominaList = document.getElementById('numNominaList');
    numNominaList.innerHTML = ''; // Limpiar contenido anterior

    // Filtrar empleados por área seleccionada
    var empleados = <?php echo json_encode($empleados, 15, 512) ?>;
    var empleadosFiltrados = empleados.filter(function (empleado) {
        return empleado.Id_Area == areaId;
    });

    // Agregar checkboxes para los empleados filtrados
    empleadosFiltrados.forEach(function (empleado) {
        var checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.name = 'numNominaSelect[]';
        checkbox.id = 'numNominaSelect' + empleado.NumNomina;
        checkbox.value = empleado.NumNomina;
        checkbox.addEventListener('change', updateTextarea);

        var label = document.createElement('label');
        label.htmlFor = 'numNominaSelect' + empleado.NumNomina;
        label.textContent = empleado.NumNomina;

        var div = document.createElement('div');
        div.classList.add('form-check');
        div.appendChild(checkbox);
        div.appendChild(label);

        numNominaList.appendChild(div);

        // Marcar checkbox si ya está seleccionado
        if (response.numNominaSeleccionados.includes(empleado.NumNomina.toString())) {
            checkbox.checked = true;
        }
    });
}


    function updateTextarea() {
        var checkboxes = document.querySelectorAll('input[name="numNominaSelect[]"]:checked');
        var numNominaArray = Array.from(checkboxes).map(function (checkbox) {
            return checkbox.value;
        });
        document.getElementById('numNominaTextarea').value = numNominaArray.join(', ');

        var areaId = document.getElementById('area').value;
        var empleados = <?php echo json_encode($empleados, 15, 512) ?>;
        var totalEmpleadosArea = empleados.filter(function (empleado) {
            return empleado.Id_Area == areaId;
        }).length;

        var totalEmpleadosGeneral = empleados.length;

        var ausencias = empleados.reduce(function (acc, empleado) {
            if (empleado.Id_Area == areaId && numNominaArray.includes(empleado.NumNomina.toString())) {
                acc++;
            }
            return acc;
        }, 0);

        var asistencias = totalEmpleadosArea - ausencias;

        document.getElementById('totalEmpleados').textContent = totalEmpleadosGeneral;
        document.getElementById('numAusencias').textContent = ausencias;
        document.getElementById('labelTotalAsistencias').textContent = 'Asistencias (Total de Empleados Hoy: ' +
            asistencias + ')';
        document.getElementById('totalAsistencias').value = asistencias;
    }
    function calcularTotalHoras() {
    let horaInicioStr = document.getElementById('horaInicio').value;
    let horaFinStr = document.getElementById('horaFin').value;

    // Verificar si las horas son válidas en formato de 24 horas (HH:mm)
    if (!isValidTimeFormat(horaInicioStr) || !isValidTimeFormat(horaFinStr)) {
        document.getElementById('totalHoras').value = 'Hora Invalida';
        return;
    }

    // Convertir las horas a objetos Date
    let horaInicio = parseTimeString(horaInicioStr);
    let horaFin = parseTimeString(horaFinStr);

    // Calcular la diferencia en horas y minutos
    let diffMs = horaFin - horaInicio;
    if (diffMs < 0) {
        document.getElementById('totalHoras').value = 'Hora Invalida';
        return;
    }
    let diffMins = diffMs / (1000 * 60);

    // Calcular las horas y minutos
    let horas = Math.floor(diffMins / 60);
    let minutos = diffMins % 60;

    // Formatear la salida
    let totalHorasStr = `${horas} horas ${minutos} minutos`;
    document.getElementById('totalHoras').value = totalHorasStr;
}

// Función para verificar el formato de hora HH:mm
function isValidTimeFormat(timeStr) {
    let timeRegex = /^(0?[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/;
    return timeRegex.test(timeStr);
}

// Función para convertir una cadena de tiempo HH:mm a un objeto Date
function parseTimeString(timeStr) {
    let [hours, minutes] = timeStr.split(':').map(Number);
    let date = new Date();
    date.setHours(hours);
    date.setMinutes(minutes);
    return date;
}

window.onload = function () {
    calcularTotalHoras();
};
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\Inocuidad_Bima\resources\views/horas/editHorasExtras.blade.php ENDPATH**/ ?>