<?php

namespace App\Http\Controllers;

use App\Exports\IncapacidadAreaExport;
use App\Exports\IncapacidadExport;
use Illuminate\Http\Request;
use App\Models\Empleado;
use App\Models\Area;
use App\Models\Incapacidad;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Support\Facades\DB;

class IncapacidadesController extends Controller
{
    //

    public function view()
    {
        return view('incapacidad.view');
    }
    public function export()
    {


        return Excel::download(new IncapacidadExport, 'Incapacidad.xlsx');
    }

    public function exportAreaIncapacidad(Request $request)
    {
        $areaId = $request->input('buscarpor');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        $areaNombre = ''; // Inicializamos el nombre del área como vacío
        if ($areaId) {
            $areaNombre = Area::findOrFail($areaId)->Nombre; // Obtenemos el nombre del área
        }

        $fechaDescarga = Carbon::now()->format('Y-m-d_H-i-s'); // Obtenemos la fecha actual

        $fileName = "Incapacidad_{$areaNombre}_{$fechaDescarga}.xlsx"; // Nombre del archivo

        return Excel::download(new IncapacidadAreaExport($areaId, $fechaInicio, $fechaFin), $fileName);
    }
    public function imprimirPdfAreaIncapacidad(Request $request)
    {
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $areas = Area::pluck('Nombre', 'Id');

        $query = Incapacidad::with('area', 'empleado');

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

        $incapacidades = $query->get();

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('Incapacidad.list_pdfIncapacidad', ['incapacidades' => $incapacidades, 'areas' => $areas, 'buscarpor' => $areaId])->render());

        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $areaSeleccionada = $areas[$areaId] ?? 'General';

        // Crear el nombre del archivo PDF con el nombre del área y la fecha actual
        $nombreArchivo = 'ListaEmpleadosIncapacidad_' . $areaSeleccionada . '_' . Carbon::now()->format('Ymd') . '.pdf';

        return $dompdf->stream($nombreArchivo);
    }

    public function destroy($Id)
    {
        DB::table('incapacidad')->where('Id', $Id)->delete();
        return redirect()->route('incapacidad.list')->with('msg', 'Incapacidad Eliminado Correctamente.');
    }


    public function edit($Id)
    {
        $incapacidades = Incapacidad::find($Id);
        $areas = Area::all();
        $empleados = Empleado::all();
        return view('incapacidad.edit', compact('incapacidades', 'areas', 'empleados'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'numNomina' => 'required',
            'FechaInicio' => 'required',
            'FechaFin' => 'required',

        ]);

        DB::update('UPDATE Incapacidad SET Id_Empleado = ?, FechaInicio = ?, FechaFin = ?, TotalDias = ? WHERE Id = ?', [
            $request->input('numNomina'),
            $request->input('FechaInicio'),
            $request->input('FechaFin'),
            $request->input('TotalDias'),
            $id // El Id del empleado que deseas actualizar
        ]);

        return view("Incapacidad.message", ['msg' => "Incapacidad actualizado correctamente."]);
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

        return view('incapacidad.create', compact('empleados'));
    }

    public function store(Request $request)
    {
        $fechaInicio = Carbon::parse($request->input('FechaInicio'));
        $fechaFin = Carbon::parse($request->input('FechaFin'));
        $totalDias = $fechaInicio->diffInDays($fechaFin) + 1;
        if ($totalDias <= 0) {
            return back()->with('error', 'La fecha de inicio no puede ser mayor a la fecha de fin');
        }
        $incapacidad = Incapacidad::create([
            'FechaInicio' => $fechaInicio,
            'FechaFin' => $fechaFin,
            'TotalDias' => $totalDias,
            'Id_Empleado' => $request->input('numNomina')
        ]);

        return view("incapacidad.message", ['msg' => "Registro exitoso de días de vacaciones."]);
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
        $query = Incapacidad::with('area', 'empleado');

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
        $incapacidades = $query->get();

        // Si no hay vacaciones que coincidan con los filtros, mostrar una vista vacía
        if ($incapacidades->isEmpty()) {
            return view('incapacidad.listvacia'); // Retorna la vista con el mensaje cuando no hay resultados
        }

        // Retornar la vista de lista de vacaciones con las vacaciones y áreas para mostrar en la vista
        return view('incapacidad.list', ['incapacidades' => $incapacidades, 'areas' => $areas, 'buscarpor' => $areaId, 'fecha_inicio' => $fechaInicio, 'fecha_fin' => $fechaFin]);
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
