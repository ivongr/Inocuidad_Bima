<?php

namespace App\Http\Controllers;

use App\Exports\VacacionesExport;
use App\Exports\VacacionesAreaExport;
use App\Models\Empleado;
use App\Models\Area;
use App\Models\Vacaciones;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;

class VacacionesController extends Controller
{
    //
    public function view()
    {
        return view('vacaciones.view');
    }



    public function export()
    {


        return Excel::download(new VacacionesExport, 'Vacaciones.xlsx');
    }


    public function exportAreaVacaciones(Request $request)
    {
        $areaId = $request->input('buscarpor');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $areaNombre = ''; // Inicializamos el nombre del área como vacío
        if ($areaId) {
            $areaNombre = Area::findOrFail($areaId)->Nombre; // Obtenemos el nombre del área
        }

        $fechaDescarga = Carbon::now()->format('Y-m-d_H-i-s'); // Obtenemos la fecha actual

        $fileName = "Vacaciones_{$areaNombre}_{$fechaDescarga}.xlsx"; // Nombre del archivo

        return Excel::download(new VacacionesAreaExport($areaId, $fechaInicio, $fechaFin), $fileName);
    }

    public function create()
    {
        // Consulta para obtener los empleados que no tienen registros en la tabla de bajas
        $empleados = Empleado::query()
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('Bajas')
                    ->whereRaw('Bajas.Id_Empleado = Empleados.Id');
            })
            ->orWhereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('ReIngresos')
                    ->whereColumn('ReIngresos.Id_Empleado', '=', 'Empleados.Id')
                    ->whereRaw('ReIngresos.FechaReIngreso > (SELECT MAX(FechaBaja) FROM Bajas WHERE Bajas.Id_Empleado = Empleados.Id)');
            })
            ->pluck('NumNomina', 'Id');

        return view('vacaciones.create', compact('empleados'));
    }

    public function edit($Id)
    {
        $vacaciones = Vacaciones::find($Id);
        $areas = Area::all();
        $empleados = Empleado::all();
        return view('vacaciones.edit', compact('vacaciones', 'areas', 'empleados'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'numNomina' => 'required',
            'FechaInicio' => 'required',
            'FechaFin' => 'required',

        ]);

        DB::update('UPDATE Vacaciones SET Id_Empleado = ?, FechaInicio = ?, FechaFin = ?, TotalDias = ? WHERE Id = ?', [
            $request->input('numNomina'),
            $request->input('FechaInicio'),
            $request->input('FechaFin'),
            $request->input('TotalDias'),
            $id // El Id del empleado que deseas actualizar
        ]);

        return view("Empleados.message", ['msg' => "Vacaciones actualizado correctamente."]);
    }


    public function destroy($Id)
    {
        DB::table('vacaciones')->where('Id', $Id)->delete();
        return redirect()->route('vacaciones.list')->with('msg', 'Vacaciones Eliminado Correctamente.');
    }

    public function imprimirPdfArea(Request $request)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $areas = Area::pluck('Nombre', 'Id');

        $query = Vacaciones::with('area', 'empleado');

        $areaId = $request->get('buscarpor');
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');

        if ($areaId) {
            $query->whereHas('empleado', function ($query) use ($areaId) {
                $query->where('Id_Area', $areaId);
            });
        }

        if ($fechaInicio && $fechaFin) {
            $query->where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('FechaInicio', [$fechaInicio, $fechaFin])
                    ->whereBetween('FechaFin', [$fechaInicio, $fechaFin]);
            });
        } elseif ($fechaInicio) {
            $query->where(function ($query) use ($fechaInicio) {
                $query->where('FechaInicio', '=', $fechaInicio)
                    ->orWhere('FechaFin', '=', $fechaInicio);
            });
        } elseif ($fechaFin) {
            $query->where(function ($query) use ($fechaFin) {
                $query->where('FechaInicio', '=', $fechaFin)
                    ->orWhere('FechaFin', '=', $fechaFin);
            });
        }

        $vacaciones = $query->get();

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('Vacaciones.list_pdfVacaciones', ['vacaciones' => $vacaciones, 'areas' => $areas, 'buscarpor' => $areaId])->render());

        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $areaSeleccionada = $areas[$areaId] ?? 'General';

        // Crear el nombre del archivo PDF con el nombre del área y la fecha actual
        $nombreArchivo = 'ListaEmpleadosVacaciones_' . $areaSeleccionada . '_' . Carbon::now()->format('YmdHis') . '.pdf';

        return $dompdf->stream($nombreArchivo);
    }

    public function store(Request $request)
    {
        $fechaInicio = Carbon::parse($request->input('FechaInicio'));
        $fechaFin = Carbon::parse($request->input('FechaFin'));
        $totalDias = $fechaInicio->diffInDays($fechaFin) + 1;
        if ($totalDias <= 0) {
            return back()->with('error', 'La fecha de inicio no puede ser mayor a la fecha de fin');
        }
        $vacacion = Vacaciones::create([
            'FechaInicio' => $fechaInicio,
            'FechaFin' => $fechaFin,
            'TotalDias' => $totalDias,
            'Id_Empleado' => $request->input('numNomina')
        ]);

        return view("vacaciones.message", ['msg' => "Registro exitoso de días de vacaciones."]);
    }

    public function list(Request $request)
    {
        // Obtener el valor del filtro por área, fecha de inicio y fecha de fin del request
        $areaId = $request->get('buscarpor');
        $fechaInicio = $request->get('fecha_inicio');
        $fechaFin = $request->get('fecha_fin');

        // Obtener todas las áreas disponibles para mostrar en el filtro
        $areas = Area::pluck('Nombre', 'Id');

        // Obtener los empleados que tienen vacaciones activas
        $empleados = Empleado::whereIn('Id', function ($query) {
            $query->select('Id_Empleado')
                ->from('Bajas')
                ->whereRaw('FechaBaja >= COALESCE(
                          (SELECT MAX(FechaReIngreso) FROM ReIngresos WHERE Id_Empleado = Bajas.Id_Empleado),
                          Empleados.FechaIngreso
                      )');
        })->pluck('NumNomina', 'Id');

        // Crear una consulta base de vacaciones con relaciones precargadas
        $query = Vacaciones::with('area', 'empleado');

        // Aplicar filtro por área si se proporciona un valor
        if ($areaId) {
            $query->whereHas('empleado', function ($query) use ($areaId) {
                $query->where('Id_Area', $areaId);
            });
        }

        // Aplicar filtro por rango de fechas si se proporcionan valores para ambas fechas
        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('FechaInicio', [$fechaInicio, $fechaFin]);
            $query->whereBetween('FechaFin', [$fechaInicio, $fechaFin]);
        } elseif ($fechaInicio) {
            $query->where('FechaInicio', '=', $fechaInicio);
        } elseif ($fechaFin) {
            $query->where('FechaFin', '=', $fechaFin);
        }

        // Obtener las vacaciones que coinciden con los filtros aplicados
        $vacaciones = $query->get();

        // Si no hay vacaciones que coincidan con los filtros, mostrar una vista vacía
        if ($vacaciones->isEmpty()) {
            return view('vacaciones.listvacia'); // Retorna la vista con el mensaje cuando no hay resultados
        }

        // Retornar la vista de lista de vacaciones con las vacaciones y áreas para mostrar en la vista
        return view('vacaciones.list', ['vacaciones' => $vacaciones, 'areas' => $areas, 'buscarpor' => $areaId, 'fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]);
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
            'Rfc' => $empleado->Rfc,
            'FechaIngreso' => $empleado->FechaIngreso
        ]);
    }
}
