<?php

namespace App\Http\Controllers;

use App\Exports\EmpleadosExport;
use App\Exports\EmpleadosAreaExport;
use App\Exports\EmpleadosAreaExportPDF;
use App\Http\Requests\DarDeBajaRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\EmpleadoDadoDeBaja;
use App\Models\Area;
use App\Models\Empleado;
use App\Models\Baja;
use App\Models\ReIngreso;
use App\Models\NumBaja;
use App\Models\NumReIngreso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;


class EmpleadosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function export()
    {

        return Excel::download(new EmpleadosExport, 'Empleados.xlsx');
    }

    public function edit($Id)
    {
      $empleado = Empleado::find($Id);
      $areas = Area::all();
      return view('empleados.edit', compact('empleado', 'areas'));
    }


    public function destroy($Id)
    {
        DB::table('empleados')->where('Id', $Id)->delete();
        return redirect()->route('empleados.list')->with('msg', 'Empleado Eliminado Correctamente.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'NumNomina' => 'required',
            'Nombre' => 'required',
            'ApePat' => 'required',
            'ApeMat' => 'required',
            'NumSeguridad' => 'required',
            'Rfc' => 'required',
            'area' => 'required',
        ]);
    
        DB::update('UPDATE empleados SET NumNomina = ?, Nombre = ?, ApePat = ?, ApeMat = ?, NumSeguridad = ?, Rfc = ?, Id_area = ? , FechaIngreso = ? WHERE Id = ?', [
            $request->input('NumNomina'),
            $request->input('Nombre'),
            $request->input('ApePat'),
            $request->input('ApeMat'),
            $request->input('NumSeguridad'),
            $request->input('Rfc'),
            $request->input('area'),
            $request->input('fechaingreso'),
            $id // El Id del empleado que deseas actualizar
        ]);
    
        return view("Empleados.message", ['msg' => "Empleado actualizado correctamente."]);
    }


    public function imprimirPdf(Request $request)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $areas = Area::pluck('Nombre', 'Id');

        $empleadosQuery = DB::table('Empleados as empleados')
        ->select(
            'empleados.NumNomina',
            DB::raw('CONCAT(empleados.Nombre, " ", empleados.ApePat, " ", empleados.ApeMat) AS nombre_completo'),
            'empleados.NumSeguridad',
            'empleados.Rfc',
            'areas.Nombre AS nombre_area',
            DB::raw('COALESCE((SELECT FechaReIngreso FROM ReIngresos WHERE Id_Empleado = empleados.Id ORDER BY FechaReIngreso DESC LIMIT 1),
            (SELECT FechaBaja FROM Bajas WHERE Id_Empleado = empleados.Id ORDER BY FechaBaja DESC LIMIT 1), empleados.FechaIngreso) AS FechaUltimoReingreso'),
            DB::raw('MAX(Bajas.FechaBaja) AS FechaBaja')
        )
        ->leftJoin('Areas', 'empleados.Id_Area', '=', 'Areas.Id')
        ->leftJoin('Bajas', 'empleados.Id', '=', 'Bajas.Id_Empleado')
        ->leftJoin('ReIngresos', 'empleados.Id', '=', 'ReIngresos.Id_Empleado')
        ->where(function ($query) {
            $query->whereNotExists(function ($subquery) {
                $subquery->from('Bajas')
                    ->whereRaw('Bajas.Id_Empleado = Empleados.Id');
            })->orWhereExists(function ($subquery) {
                $subquery->from('ReIngresos')
                    ->whereRaw('ReIngresos.Id_Empleado = Empleados.Id')
                    ->whereRaw('ReIngresos.FechaReIngreso > (
                        SELECT MAX(FechaBaja) FROM Bajas WHERE Bajas.Id_Empleado = Empleados.Id)');
            });
        })
        ->groupBy('empleados.Id');


        $buscarpor = $request->input('buscarpor');
        if ($buscarpor) {
            $empleadosQuery->where('Id_Area', $buscarpor);
        }
        $empleados = $empleadosQuery->get();


        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('empleados.list_pdf', ['empleados' => $empleados, 'areas' => $areas])->render());

        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Obtener el nombre del área seleccionada
        $areaSeleccionada = $areas[$buscarpor] ?? 'General';

        // Crear el nombre del archivo PDF con el nombre del área y la fecha actual
        $nombreArchivo = 'ListaEmpleados_' . $areaSeleccionada . '_' . Carbon::now()->format('Ymd') . '.pdf';

        return $dompdf->stream($nombreArchivo);
    }


public function exportArea(Request $request)
{
    $areaId = $request->input('buscarpor');
    $areaNombre = ''; // Inicializamos el nombre del área como vacío

    // Obtenemos el nombre del área si se proporcionó un ID de área
    if ($areaId) {
        $area = DB::table('Areas')->where('Id', $areaId)->value('Nombre');
        if ($area) {
            $areaNombre = $area;
        }
    }

    $fechaDescarga = Carbon::now()->format('Y-m-d_H-i-s'); // Obtenemos la fecha actual

    $fileName = "empleados_{$areaNombre}_{$fechaDescarga}.xlsx"; // Nombre del archivo

    return Excel::download(new EmpleadosAreaExport($areaId), $fileName);
}

    public function view()
    {
        return view('empleados.view');
    }






//obtener en el select los números de nóminas de acuerdo
//a validar la fecha ingreso y reingreso, con la fecha baja
    public function baja()
    {

        $numBaja = NumBaja::pluck('Nombre', 'Id');

        $empleados = Empleado::whereIn('Id', function($query) {
            $query->select('Id')
                ->from('Empleados')
                ->whereRaw('NOT EXISTS (
                    SELECT 1 FROM Bajas WHERE Bajas.Id_Empleado = Empleados.Id
                ) OR EXISTS (
                    SELECT 1 FROM ReIngresos
                    WHERE ReIngresos.Id_Empleado = Empleados.Id
                    AND ReIngresos.FechaReIngreso > (
                        SELECT MAX(FechaBaja) FROM Bajas WHERE Bajas.Id_Empleado = Empleados.Id
                    )
                )');
        })->pluck('NumNomina', 'Id');



        // Obtener todas las áreas para el formulario de baja
        $areas = Area::pluck('Nombre', 'Id');

        return view('empleados.baja', compact('empleados', 'areas','numBaja'));
    }


    public function storeBaja(Request $request)
    {
        $FechaBaja = Carbon::parse($request->input('FechaBaja'));


        $Bajas = Baja::create([
            'FechaBaja' => $FechaBaja,
            'Id_Empleado' => $request->input('numNomina'),
            'Id_NumBaja' => $request->input('numBaja'),

        ]);


        return view("Empleados.message", ['msg' => "Baja de empleado procesada correctamente."]);
    }



    public function reingreso()
    {
        // Obtiene un array asociativo de los nombres de los reingresos con sus IDs
        $numReIngreso = NumReIngreso::pluck('Nombre', 'Id');

        // Obtiene los números de nómina de los empleados que tienen una baja registrada
        // y cuya fecha de baja es mayor o igual a la fecha de último reingreso o ingreso
        $empleados = Empleado::whereIn('Id', function($query) {
            $query->select('Id_Empleado')
                  ->from('Bajas')
                  ->whereRaw('FechaBaja >= COALESCE(
                          (SELECT MAX(FechaReIngreso) FROM ReIngresos WHERE Id_Empleado = Bajas.Id_Empleado),
                          Empleados.FechaIngreso
                      )');
        })->pluck('NumNomina', 'Id');

        // Obtiene todos los nombres de las áreas con sus IDs para el formulario de baja
        $areas = Area::pluck('Nombre', 'Id');

        // Devuelve la vista con los datos necesarios
        return view("empleados.reingreso", compact('empleados', 'areas','numReIngreso'));
    }
    public function storeReIngreso(Request $request)
    {
        $FechaReIngreso = Carbon::parse($request->input('FechaReIngreso'));

        // Insertar el registro en la tabla ReIngresos
        $ReIngresos = ReIngreso::create([
            'FechaReIngreso' => $FechaReIngreso,
            'Id_Empleado' => $request->input('numNomina'),
            'Id_NumReIngreso' => $request->input('numReIngreso')
        ]);

        return view("Empleados.message", ['msg' => "Reingreso de empleado completado."]);
    }


    public function getEmpleadoInfo(Request $request)
    {
        $numNomina = $request->input('numNomina');
        $empleado = Empleado::where('Id', $numNomina)->first();

        return response()->json([
            'NumNomina' => $empleado->NumNomina,
            'Nombre' => $empleado->Nombre,
            'ApePat' => $empleado->ApePat,
            'ApeMat' => $empleado->ApeMat,
            'NumSeguridad' => $empleado->NumSeguridad,
            'Rfc'=> $empleado->Rfc,
            'FechaIngreso'=> $empleado->FechaIngreso
        ]);
    }


    public function create()
    {
        $areas = Area::pluck('Nombre', 'Id');
        return view('empleados.create', compact('areas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numNomina' => 'required|unique:empleados|max:4|regex:/^[a-zA-Z0-9\s\-]+$/',
                ####Solo permitir letras y -, acentos La u al final de la expresión regular
                ## (/regex/) es para indicar que se deben interpretar los caracteres como UTF-8,
                ## lo que permite el uso de letras acentuadas. #########
                'Nombre' => 'required|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/u',
            ####Solo permitir letras y - #########
            'ApePat' => 'required|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/u',
            'ApeMat' => 'required|max:255|regex:/^[a-zA-ZáéíóúÁÉÍÓÚ\s]+$/u',
                 ####Solo permitir números y - #########
            'NumSeguridad' => 'required|min:10|unique:empleados|numeric|regex:/^[0-9]+$/',
             ####Solo permitir números, letras y -. NO caracteres especiales #########
            'Rfc' => 'required|regex:/^[a-zA-Z0-9\s\-]+$/|max:13|min:13|unique:empleados'
        ], [
            'numNomina.required' => 'El campo de número de nómina es obligatorio.',
            'numNomina.unique' => 'El número de nómina ya está en uso.',
            'numNomina.max' => 'El número de nómina no debe tener más de :max caracteres.',

            'Nombre.required' => 'El campo de nombre es obligatorio.',
            'Nombre.regex' => 'El campo de nombre no debe contener caracteres especiales y ni numeros.',
            'Nombre.max' => 'El nombre no debe tener más de :max caracteres.',
            'ApePat.required' => 'El campo de apellido paterno es obligatorio.',
            'ApePat.regex' => 'El campo de apellido paterno no debe contener caracteres especiales y ni numeros.',
            'ApeMat.required' => 'El campo de apellido materno es obligatorio.',
            'ApeMat.regex' => 'El campo de apellido materno no debe contener caracteres especiales y ni numeros.',
            'NumSeguridad.required' => 'El campo de número de seguridad social es obligatorio.',
            'NumSeguridad.min' => 'El Número de Seguridad debe de tener minimo :min caracteres.',
            'NumSeguridad.max' => 'El número de seguridad no debe tener más de :max caracteres.',
            'NumSeguridad.numeric' => 'El número de seguridad debe ser un valor numérico.',
            'NumSeguridad.regex' => 'El número de seguridad no debe contener caracteres especiales ni letras.',
            'NumSeguridad.unique' => 'El número de seguridad ya está en uso.',

            'Rfc.required' => 'El campo de RFC es obligatorio.',
            'Rfc.max' => 'El RFC no debe tener más de :max caracteres.',
            'Rfc.min' => 'El RFC debe de tener minimo :min caracteres.',
            'Rfc.unique' => 'El RFC ya está en uso.'
        ]);


        $empleado = Empleado::create([
            'NumNomina' => $request->input('numNomina'),
            'Nombre' => $request->input('Nombre'),
            'ApePat' => $request->input('ApePat'),
            'ApeMat' => $request->input('ApeMat'),
            'NumSeguridad' => $request->input('NumSeguridad'),
            'Rfc' => $request->input('Rfc'),
            'Id_area' => $request->input('area'),
            'FechaIngreso' => $request->input('fechaingreso'),
        ]);

        return view("empleados.message", ['msg' => "Nuevo empleado registrado con éxito."]);
    }

    public function list(Request $request)
    {
        // Obtener todas las áreas para el filtro
        $areas = Area::pluck('Nombre', 'Id');

        // Obtener el valor del filtro por área
        $buscarpor = $request->get('buscarpor');

        // Iniciar la consulta de empleados activos
        $empleadosActivosQuery = Empleado::query();

        // Seleccionar campos y calcular la fecha de último reingreso
        $empleadosActivosQuery->selectRaw('empleados.*, CONCAT(empleados.Nombre, " ", empleados.ApePat, " ", empleados.ApeMat) AS nombre_completo,
        COALESCE((SELECT FechaReIngreso FROM ReIngresos WHERE Id_Empleado = empleados.Id ORDER BY FechaReIngreso DESC LIMIT 1),
        (SELECT FechaBaja FROM Bajas WHERE Id_Empleado = empleados.Id ORDER BY FechaBaja DESC LIMIT 1), empleados.FechaIngreso) AS FechaUltimoReingreso,
        MAX(b.FechaBaja) AS FechaBaja, areas.Nombre AS nombre_area,
        GROUP_CONCAT(DISTINCT COALESCE(ReIngresos.FechaReIngreso) SEPARATOR ", ") AS FechasReingreso,
        GROUP_CONCAT(DISTINCT b.FechaBaja ORDER BY b.FechaBaja SEPARATOR ", ") AS FechasBaja
    ')
        ->leftJoin('bajas as b', 'empleados.Id', '=', 'b.Id_Empleado')
        ->leftJoin('ReIngresos', 'empleados.Id', '=', 'ReIngresos.Id_Empleado')
        ->leftJoin('Areas', 'empleados.Id_Area', '=', 'Areas.Id')
        ->where(function ($query) {
            $query->whereNotExists(function ($subquery) {
                $subquery->from('Bajas')
                    ->whereRaw('Bajas.Id_Empleado = Empleados.Id');
            })->orWhereExists(function ($subquery) {
                $subquery->from('ReIngresos')
                    ->whereRaw('ReIngresos.Id_Empleado = Empleados.Id')
                    ->whereRaw('ReIngresos.FechaReIngreso > (
                        SELECT MAX(FechaBaja) FROM Bajas WHERE Bajas.Id_Empleado = Empleados.Id)');
            });
        })->groupBy('empleados.Id');


        // Aplicar filtro por área si se especifica
        if ($buscarpor) {
            $empleadosActivosQuery->where('empleados.Id_Area', $buscarpor);
        }

        // Paginar resultados
        $empleadosActivos = $empleadosActivosQuery->get();

        // Verificar si no hay resultados
        if ($empleadosActivos->isEmpty()) {
            return view('empleados.vacia'); // Vista para cuando no hay empleados
        } else {
            // Vista para mostrar la lista de empleados activos
            return view('empleados.list', ['empleados' => $empleadosActivos, 'areas' => $areas, 'buscarpor' => $buscarpor]);
        }
    }




    public function listBaja(Request $request)
    {
        $areas = Area::pluck('Nombre', 'Id');
        $buscarpor = $request->get('buscarpor');
        $empleadosBajaQuery = Baja::query();
        $empleadosBajaQuery->selectRaw('empleados.*, CONCAT(empleados.Nombre, " ", empleados.ApePat, " ", empleados.ApeMat) AS nombre_completo,
                COALESCE((SELECT FechaReIngreso FROM ReIngresos WHERE Id_Empleado = empleados.Id ORDER BY FechaReIngreso DESC LIMIT 1),
                (SELECT FechaBaja FROM Bajas WHERE Id_Empleado = empleados.Id ORDER BY FechaBaja DESC LIMIT 1), empleados.FechaIngreso) AS FechaUltimoReingreso,
                MAX(Bajas.FechaBaja) AS FechaBaja,
                 GROUP_CONCAT(DISTINCT COALESCE(ReIngresos.FechaReIngreso) SEPARATOR ", ") AS FechasReingreso,
                GROUP_CONCAT(DISTINCT Bajas.FechaBaja ORDER BY Bajas.FechaBaja SEPARATOR ", ") AS FechasBaja,
                areas.Nombre AS nombre_area')
            ->leftJoin('empleados', 'empleados.Id', '=', 'Bajas.Id_Empleado')
            ->leftJoin('ReIngresos', 'empleados.Id', '=', 'ReIngresos.Id_Empleado')
            ->leftJoin('Areas', 'empleados.Id_Area', '=', 'Areas.Id')
            ->where(function ($query) {
                $query->whereNull('Bajas.FechaBaja')
                    ->orWhere('Bajas.FechaBaja', '>=', DB::raw('(SELECT COALESCE(MAX(FechaReIngreso), empleados.FechaIngreso) FROM ReIngresos WHERE Id_Empleado = empleados.Id)'));
            })
            ->groupBy('empleados.Id');

        if ($buscarpor) {
            $empleadosBajaQuery->where('empleados.Id_Area', $buscarpor);
        }

        $empleadosBaja = $empleadosBajaQuery->paginate(6); // Paginar resultados

        if ($empleadosBaja->isEmpty()) {
            return view('empleados.listvacia');
        } else {
            return view('empleados.listBaja', ['bajas' => $empleadosBaja, 'areas' => $areas, 'buscarpor' => $buscarpor]);
        }
    }


}
