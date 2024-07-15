<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use App\Models\admin;
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



//es en el modelo de role
Route::get('/create-roles', function () {
    Role::createRoles();
    return 'Roles creados correctamente';
});

//PARA CREAR EL USUARIO
Route::get('/createAdmin', function () {
    Admin::createAdmin();
    return 'Usuario Administrador creado correctamente';
});


    //RUTAS PARA GENERAR ARCHIVOS PDF Y EXCEL//

    Route::get('/exportarEmpleados', [App\Http\Controllers\EmpleadosController::class, 'export']);
    Route::get('/exportArea', [App\Http\Controllers\EmpleadosController::class, 'exportArea'])->name('exportArea');
    Route::get('/exportar', [App\Http\Controllers\VacacionesController::class, 'export']);
    Route::get('/exportAreaVacaciones', [App\Http\Controllers\VacacionesController::class, 'exportAreaVacaciones'])->name('exportAreaVacaciones');
    Route::get('/exportAreaIncapacidad', [App\Http\Controllers\IncapacidadesController::class, 'exportAreaIncapacidad'])->name('exportAreaIncapacidad');
    Route::get('/exportarIncapacidad', [App\Http\Controllers\IncapacidadesController::class, 'export']);

    Route::get('/exportHoras', [App\Http\Controllers\HorasController::class, 'exportHoras'])->name('exportHoras');
    Route::get('/exportHorasArea', [App\Http\Controllers\HorasController::class, 'exportHorasArea'])->name('exportHorasArea');
    Route::get('/imprimirExcelHoras', [App\Http\Controllers\HorasController::class, 'imprimirExcelHoras'])->name('imprimirExcelHoras');
    Route::get('/imprimir-pdfHoras', [App\Http\Controllers\HorasController::class, 'imprimirPdfHoras'])->name('imprimirHoras.pdf');
    Route::get('/imprimir-pdfHorasArea', [App\Http\Controllers\HorasController::class, 'imprimirPdfHorasPorArea'])->name('imprimirHorasArea.pdf');

    Route::get('/imprimir-pdf', [App\Http\Controllers\EmpleadosController::class, 'imprimirPdf'])->name('imprimir.pdf');

    Route::get('/imprimirpdfArea', [App\Http\Controllers\IncapacidadesController::class, 'imprimirPdfAreaIncapacidad'])->name('imprimirAreaIncapacidad.pdf');
    Route::get('/imprimir-pdfArea', [App\Http\Controllers\VacacionesController::class, 'imprimirPdfArea'])->name('imprimirArea.pdf');


Route::get('/error-permiso', function () {
    return view('error-permiso');
})->name('error-permiso');



Route::group(['middleware' => ['auth']], function () {





        Route::get('/admin-dashboard', function () {
            return view('usuarios.list');
        })->middleware(['auth', 'role:administrador'])->name('admin.dashboard');


        Route::get('/usuarios/list', [App\Http\Controllers\UsuariosController::class, 'list'])->name('usuarios.list');

        Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'create'])->name('register.create');
        Route::get('/register',  [App\Http\Controllers\Auth\RegisterController::class,'view'])->name('register');

        Route::get('/usuarios/view', [App\Http\Controllers\UsuariosController::class, 'view'])->name('usuarios.view');
        Route::delete('/usuarios/{id}', [App\Http\Controllers\UsuariosController::class, 'destroy'])->name('usuarios.destroy');
        Route::patch('/usuarios/{id}/update-password', [App\Http\Controllers\UsuariosController::class, 'updatePassword'])->name('usuarios.updatePassword');


        Route::delete('/empleados/{Id}', [App\Http\Controllers\EmpleadosController::class, 'destroy'])->name('empleados.destroy');

        Route::get('/empleados/view', [App\Http\Controllers\EmpleadosController::class, 'view'])->name('empleados.view');
        Route::post('/empleados', [App\Http\Controllers\EmpleadosController::class, 'store'])->name('empleados.store');
        Route::get('/empleados/list', [App\Http\Controllers\EmpleadosController::class, 'list'])->name('empleados.list');
        Route::get('/empleados/create', [App\Http\Controllers\EmpleadosController::class, 'create'])->name('empleados.create');
        Route::get('/empleados/baja', [App\Http\Controllers\EmpleadosController::class, 'baja'])->name('empleados.baja');
        Route::get('/empleados/listBaja', [App\Http\Controllers\EmpleadosController::class, 'listBaja'])->name('empleados.listBaja');
        Route::get('/empleados/list_pdf', [App\Http\Controllers\EmpleadosController::class, 'list_pdf'])->name('empleados.list_pdf');
        Route::get('/empleados/message', [App\Http\Controllers\EmpleadosController::class, 'message'])->name('empleados.message');
        Route::get('/empleados/vacia', [App\Http\Controllers\EmpleadosController::class, 'vacia'])->name('empleados.vacia');
        Route::get('/empleados/listvacia', [App\Http\Controllers\EmpleadosController::class, 'listvacia'])->name('empleados.listvacia');
        Route::post('/storeBaja', [App\Http\Controllers\EmpleadosController::class, 'storeBaja'])->name('empleados.storeBaja');
        Route::get('/empleados/reingreso', [App\Http\Controllers\EmpleadosController::class, 'reingreso'])->name('empleados.reingreso');
        Route::post('/storeReIngreso', [App\Http\Controllers\EmpleadosController::class, 'storeReIngreso'])->name('empleados.storeReIngreso');
        Route::get('/getEmpleadoInfo', [App\Http\Controllers\EmpleadosController::class, 'getEmpleadoInfo'])->name('getEmpleadoInfo');
        Route::get('/empleados/{Id}/edit', [App\Http\Controllers\EmpleadosController::class, 'edit'])->name('empleados.edit');
        Route::put('/empleados/{Id}', [App\Http\Controllers\EmpleadosController::class, 'update'])->name('empleados.update');

        Route::get('/horas/view', [App\Http\Controllers\HorasController::class, 'view'])->name('horas.view');
        Route::get('/horas/gettotalempleados', [App\Http\Controllers\HorasController::class, 'getTotalEmpleados']);
        Route::get('/horas/create', [App\Http\Controllers\HorasController::class, 'create'])->name('horas.create');
        Route::post('/horas', [App\Http\Controllers\HorasController::class, 'store'])->name('horas.store');
        Route::get('/horas/createEntradas', [App\Http\Controllers\HorasController::class, 'createEntradas'])->name('horas.createEntradas');
        Route::get('/horas/horasEntradas', [App\Http\Controllers\HorasController::class, 'horasEntradas'])->name('horas.horasEntradas');
        Route::get('/horas/horasSalidas', [App\Http\Controllers\HorasController::class, 'horasSalidas'])->name('horas.horasSalidas');
        Route::post('/horasEntradas', [App\Http\Controllers\HorasController::class, 'storeHorasEntradas'])->name('horas.storeEntradas');
        Route::get('/horas/createSalidas', [App\Http\Controllers\HorasController::class, 'createSalida'])->name('horas.createSalidas');
        Route::post('/storeHorasSalidas', [App\Http\Controllers\HorasController::class, 'storeHorasSalidas'])->name('horas.storeHorasSalidas');
        Route::get('/horas/list', [App\Http\Controllers\HorasController::class, 'list'])->name('horas.list');
        Route::get('/horas/horasExtras', [App\Http\Controllers\HorasController::class, 'horasExtras'])->name('horas.horasExtras');
        Route::delete('/eliminar/{numNomina}/{fecha}',  [App\Http\Controllers\HorasController::class, 'eliminarRegistro'])->name('eliminar.registro');

        
        Route::delete('/eliminar-todos', [App\Http\Controllers\HorasController::class, 'eliminarTodos'])->name('eliminar.todos');



        Route::delete('/incapacidades/{Id}', [App\Http\Controllers\IncapacidadesController::class, 'destroy'])->name('incapacidad.destroy');
        Route::get('/incapacidades/create', [App\Http\Controllers\IncapacidadesController::class, 'create'])->name('incapacidad.create');
        Route::get('/incapacidades/view', [App\Http\Controllers\IncapacidadesController::class, 'view'])->name('incapacidad.view');
        Route::post('/incapacidades', [App\Http\Controllers\IncapacidadesController::class, 'store'])->name('incapacidad.store');
        Route::get('/incapacidades/list', [App\Http\Controllers\IncapacidadesController::class, 'list'])->name('incapacidad.list');
        Route::get('/incapacidades/{Id}/edit', [App\Http\Controllers\IncapacidadesController::class, 'edit'])->name('incapacidad.edit');
        Route::put('/incapacidades/{Id}', [App\Http\Controllers\IncapacidadesController::class, 'update'])->name('incapacidad.update');
    Route::get('/empleados/list_pdf', [App\Http\Controllers\EmpleadosController::class, 'list_pdf'])->name('empleados.list_pdf');


        Route::get('/vacaciones/editHorasExtras', [App\Http\Controllers\HorasController::class, 'editHorasExtras'])->name('horas.editHorasExtras');
        Route::post('/vacaciones/actualizarHorasExtras', [App\Http\Controllers\HorasController::class, ' actualizarHorasExtras'])->name('horas.actualizarHorasExtras');
        Route::get('/vacaciones/datos', [App\Http\Controllers\HorasController::class, 'obtenerDatos']);



        Route::get('/vacaciones/create', [App\Http\Controllers\VacacionesController::class, 'create'])->name('vacaciones.create');
        Route::get('/vacaciones/view', [App\Http\Controllers\VacacionesController::class, 'view'])->name('vacaciones.view');
        Route::post('/vacaciones', [App\Http\Controllers\VacacionesController::class, 'store'])->name('vacaciones.store');
        Route::get('/vacaciones/list', [App\Http\Controllers\VacacionesController::class, 'list'])->name('vacaciones.list');
        Route::get('/vacaciones/listvacia', [App\Http\Controllers\VacacionesController::class,'listvacia'])->name('vacaciones.listvacia');
        Route::get('/vacaciones/{Id}/edit', [App\Http\Controllers\VacacionesController::class, 'edit'])->name('vacaciones.edit');
        Route::put('/vacaciones/{Id}', [App\Http\Controllers\VacacionesController::class, 'update'])->name('vacaciones.update');
        Route::delete('/vacaciones/{Id}', [App\Http\Controllers\VacacionesController::class, 'destroy'])->name('vacaciones.destroy');


        Route::get('/areas/view', [App\Http\Controllers\AreasController::class, 'view'])->name('areas.view');
        Route::get('/areas/create', [App\Http\Controllers\AreasController::class, 'create'])->name('areas.create');
        Route::post('/areas', [App\Http\Controllers\AreasController::class, 'store'])->name('areas.store');
        Route::get('/areas/menssage', [App\Http\Controllers\AreasController::class, 'menssage'])->name('areas.menssage');
        Route::get('/areas/list', [App\Http\Controllers\AreasController::class, 'list'])->name('areas.list');
        Route::get('/areas/{Id}/edit', [App\Http\Controllers\AreasController::class, 'edit'])->name('areas.edit');
        Route::put('/areas/{Id}', [App\Http\Controllers\AreasController::class, 'update'])->name('areas.update');
        Route::delete('/areas/{Id}', [App\Http\Controllers\AreasController::class, 'destroy'])->name('areas.destroy');


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/empleados/view', [App\Http\Controllers\EmpleadosController::class, 'view'])->name('empleados.view');
    Route::get('/empleados/list', [App\Http\Controllers\EmpleadosController::class, 'list'])->name('empleados.list');
    Route::get('/empleados/listBaja', [App\Http\Controllers\EmpleadosController::class, 'listBaja'])->name('empleados.listBaja');
    Route::get('/empleados/list_pdf', [App\Http\Controllers\EmpleadosController::class, 'list_pdf'])->name('empleados.list_pdf');
    Route::get('/empleados/vacia', [App\Http\Controllers\EmpleadosController::class, 'vacia'])->name('empleados.vacia');
    Route::get('/empleados/listvacia', [App\Http\Controllers\EmpleadosController::class, 'listvacia'])->name('empleados.listvacia');

    Route::get('/horas/view', [App\Http\Controllers\HorasController::class, 'view'])->name('horas.view');
    Route::get('/horas/list', [App\Http\Controllers\HorasController::class, 'list'])->name('horas.list');
    Route::get('/horas/{Id}/edit', [App\Http\Controllers\HorasController::class, 'edit'])->name('horas.edit');
    Route::put('/horas/{Id}', [App\Http\Controllers\HorasController::class, 'update'])->name('horas.update');
// Route definition
    Route::get('/vacaciones/list', [App\Http\Controllers\VacacionesController::class, 'list'])->name('vacaciones.list');
    Route::get('/vacaciones/view', [App\Http\Controllers\VacacionesController::class, 'view'])->name('vacaciones.view');





    Route::get('/areas/view', [App\Http\Controllers\AreasController::class, 'view'])->name('areas.view');
    Route::get('/areas/menssage', [App\Http\Controllers\AreasController::class, 'menssage'])->name('areas.menssage');
    Route::get('/areas/list', [App\Http\Controllers\AreasController::class, 'list'])->name('areas.list');




    // Ruta de error de permiso
    Route::get('/error-permiso', function () {
        return view('error-permiso');
    })->name('error-permiso');

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Otras rutas públicas o accesibles para todos los usuarios
