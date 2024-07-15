<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Empleado;
use App\Models\Vacaciones;
use App\Models\Incapacidad;
use App\Models\NumEntrada;
use App\Models\HoraEntrada;
use App\Models\HoraSalida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Exports\HorasExport;
use App\Exports\HorasExportArea;
use App\Exports\HorasExportAreaPDF;
use App\Models\Hora;
use App\Models\NumSalida;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class HorasController extends Controller
{

    //*********/

    public function exportHoras()
    {

        return Excel::download(new HorasExport, 'Horas.xlsx');
    }
    public function edit($Id)
    {
        // Obtiene los datos del empleado con el Id proporcionado y sus relaciones
        $empleado = Empleado::with('entradas', 'salidas', 'horasExtras')->findOrFail($Id);

        // Define la variable $fecha aquí
        $fecha = $empleado->fecha; // Asegúrate de que esto refleje la fecha que deseas mostrar en el formulario

        $hora_inicio = null;
        $hora_fin = null;
        $hora_salida = null;
        $hora_entrada = null;

        if ($empleado->horasExtras->isNotEmpty()) {
            $hora_inicio = $empleado->horasExtras->first()->Hora;
            $hora_fin = $empleado->horasExtras->last()->Hora;
            $hora_salida = $empleado->salidas->last()->Salida;
            $hora_entrada = $empleado->entradas->last()->HoraEntrada;
        }




        // Pasa los datos a la vista
        return view('horas.edit', [
            'empleado' => $empleado,
            'Id' => $Id, // Pasa el Id a la vista
            'fecha' => $fecha,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'hora_entrada' => $hora_entrada,
            'hora_salida' => $hora_salida,
        ]);
    }

    public function update(Request $request, $Id)
    {
        $request->validate([
            'fecha' => 'required|date',
            'hora_inicio' => 'required|date_format:H:i',
            'hora_fin' => 'required|date_format:H:i',
            'hora_entrada' => 'required|date_format:H:i',
            'hora_salida' => 'required|date_format:H:i',
        ]);

        // Actualizar el registro en la tabla Hora
        $hora = Hora::findOrFail($Id);
        $hora->HoraInicio = $request->input('hora_inicio');
        $hora->HoraFin = $request->input('hora_fin');
        $hora->Fecha = $request->input('fecha');
        $hora->save();

        // Actualizar el registro en la tabla HoraEntrada
        $horaEntrada = HoraEntrada::findOrFail($Id);
        $horaEntrada->HoraEntrada = $request->input('hora_entrada');
        $horaEntrada->Fecha = $request->input('fecha');
        $horaEntrada->save();

        // Actualizar el registro en la tabla HoraSalida
        $horaSalida = HoraSalida::findOrFail($Id);
        $horaSalida->HoraSalida = $request->input('hora_salida');
        $horaSalida->Fecha = $request->input('fecha');
        $horaSalida->save();

        return redirect()->route('horas.view')->with('success', 'Empleado actualizado correctamente.');
    }


    //********************************* */
    public function imprimirPdfHoras(Request $request)
    {


        // Obtener la lista de áreas para el select de filtrado
        $areas = Area::pluck('Nombre', 'Id');

        $empleadosQuery = Empleado::leftJoin('Entradas as en', 'Empleados.Id', '=', 'en.Id_Empleado')
            ->whereNotNull('en.Id')
            ->leftJoin('Salidas as s', function ($join) {
                $join->on('empleados.Id', '=', 's.Id_Empleado')
                    ->where('s.Id_numSalidas', '=', 1)
                    ->whereColumn('s.Fecha', 'en.Fecha');
            })
            ->leftJoin('Entradas as e2', function ($join) {
                $join->on('Empleados.Id', '=', 'e2.Id_Empleado')
                    ->where('e2.Id_numEntradas', '=', 2)
                    ->whereColumn('e2.Fecha', 'en.Fecha');
            })
            ->leftJoin('Salidas as s2', function ($join) {
                $join->on('empleados.Id', '=', 's2.Id_Empleado')
                    ->where('s2.Id_numSalidas', '=', 2)
                    ->whereColumn('s2.Fecha', 'en.Fecha');
            })
            ->leftJoin('HorasExtras as he', 'empleados.Id', '=', 'he.Id_Empleado')
            ->leftJoin('Areas as a', 'empleados.Id_Area', '=', 'a.Id')
            ->leftJoin('Vacaciones as v', function ($join) {
                $join->on('empleados.Id', '=', 'v.Id_Empleado')
                    ->where('v.FechaInicio', '<=', DB::raw('DATE(en.Fecha)'))
                    ->where('v.FechaFin', '>=', DB::raw('DATE(en.Fecha)'));
            })
            ->leftJoin('Incapacidad as i', function ($join) {
                $join->on('empleados.Id', '=', 'i.Id_Empleado')
                    ->where('i.FechaInicio', '<=', DB::raw('DATE(en.Fecha)'))
                    ->where('i.FechaFin', '>=', DB::raw('DATE(en.Fecha)'));
            })
            ->select(
                'empleados.NumNomina',
                'en.Fecha as Fecha',
                DB::raw('
            CASE DAYOFWEEK(en.Fecha)
                WHEN 1 THEN "Domingo"
                WHEN 2 THEN "Lunes"
                WHEN 3 THEN "Martes"
                WHEN 4 THEN "Miércoles"
                WHEN 5 THEN "Jueves"
                WHEN 6 THEN "Viernes"
                WHEN 7 THEN "Sábado"
            END AS Dia
            '),
                DB::raw('CONCAT(empleados.Nombre, " ", empleados.ApePat, " ", empleados.ApeMat) as NombreCompleto'),
                DB::raw('MAX(CASE WHEN en.Id_numEntradas = 1 THEN en.HoraEntrada END) AS `Hora de Entrada 1`'),
                DB::raw('MAX(CASE WHEN s.Id_numSalidas = 1 THEN s.HoraSalida END) AS `Hora de Salida 1`'),
                DB::raw('MAX(CASE WHEN en.Id_numEntradas = 2 THEN e2.HoraEntrada END) AS `Hora de Entrada 2`'),
                DB::raw('MAX(CASE WHEN s2.Id_numSalidas = 2 THEN s2.HoraSalida END) AS `Hora de Salida 2`'),
                DB::raw('(SELECT COALESCE(SUM(he.TotalHoras), 0) FROM HorasExtras he WHERE he.Id_Empleado = empleados.Id AND DATE(he.Fecha) = en.Fecha) AS `Horas Extras`'),
                DB::raw('ROUND(
                (
                    TIME_TO_SEC(TIMEDIFF(
                        COALESCE(MAX(CASE WHEN s.Id_numSalidas = 1 THEN s.HoraSalida END), "00:00:00"),
                        COALESCE(MAX(CASE WHEN en.Id_numEntradas = 1 THEN en.HoraEntrada END), "00:00:00")
                    )) +
                    TIME_TO_SEC(TIMEDIFF(
                        COALESCE(MAX(CASE WHEN s2.Id_numSalidas = 2 THEN s2.HoraSalida END), "00:00:00"),
                        COALESCE(MAX(CASE WHEN e2.Id_numEntradas = 2 THEN e2.HoraEntrada END), "00:00:00")
                    )) +
                    COALESCE((SELECT SUM(he.TotalHoras) FROM HorasExtras he WHERE he.Id_Empleado = empleados.Id AND DATE(he.Fecha) = en.Fecha), 0) * 3600
                ) / 3600
            , 2) AS `Total De Horas Laboradas`'),
                'a.Nombre AS Área',
                DB::raw('CASE
                WHEN v.Id IS NOT NULL THEN "Vacaciones"
                WHEN i.Id IS NOT NULL THEN "Incapacidad"
                ELSE ""
            END AS Estado')
            )
            ->groupBy('empleados.Id', 'en.Fecha', 'v.Id', 'i.Id')
            ->orderBy('empleados.NumNomina')
            ->orderBy('en.Fecha');


        // Aplicar filtro por buscarpor
        /* if ($buscarpor) {
            $empleadosQuery->where(function ($query) use ($buscarpor) {
                $query->where('empleados.NumNomina', 'LIKE', "%$buscarpor%")
                    ->orWhere('empleados.Nombre', 'LIKE', "%$buscarpor%")
                    ->orWhere('empleados.ApePat', 'LIKE', "%$buscarpor%")
                    ->orWhere('empleados.ApeMat', 'LIKE', "%$buscarpor%");
            });
        }*/

        $empleados = $empleadosQuery->get();


        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('horas.list_pdfHoras', ['empleados' => $empleados, 'areas' => $areas])->render());

        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Nombre del archivo PDF
        // Envía el archivo PDF como respuesta sin mostrar el nombre del archivo

        // Nombre del archivo PDF
        $nombreArchivo = 'ListaHoras_' . Carbon::now()->format('Ymd') . '.pdf';
        //esto sirve solo para que aparezca el archivo en el naegardor
        /*return $dompdf->stream($nombreArchivo, ['Attachment' => false]);*/

        //descargar archivos
        return $dompdf->stream($nombreArchivo);
    }

    public function imprimirPdfHorasPorArea(Request $request)
    {
        // Obtener el ID de área y la fecha seleccionados del formulario de filtro
        $areaId = $request->input('area');
        $fecha = $request->input('fecha');
        $buscarpor = $request->input('buscarpor');

        // Obtener la lista de áreas para el select de filtrado
        $areas = Area::pluck('Nombre', 'Id');

        $empleadosAreaQuery = Empleado::leftJoin('Entradas as en', 'Empleados.Id', '=', 'en.Id_Empleado')
            ->whereNotNull('en.Id')
            ->leftJoin('Salidas as s', function ($join) {
                $join->on('empleados.Id', '=', 's.Id_Empleado')
                    ->where('s.Id_numSalidas', '=', 1)
                    ->whereColumn('s.Fecha', 'en.Fecha');
            })
            ->leftJoin('Entradas as e2', function ($join) {
                $join->on('Empleados.Id', '=', 'e2.Id_Empleado')
                    ->where('e2.Id_numEntradas', '=', 2)
                    ->whereColumn('e2.Fecha', 'en.Fecha');
            })
            ->leftJoin('Salidas as s2', function ($join) {
                $join->on('empleados.Id', '=', 's2.Id_Empleado')
                    ->where('s2.Id_numSalidas', '=', 2)
                    ->whereColumn('s2.Fecha', 'en.Fecha');
            })
            ->leftJoin('HorasExtras as he', 'empleados.Id', '=', 'he.Id_Empleado')
            ->leftJoin('Areas as a', 'empleados.Id_Area', '=', 'a.Id')
            ->leftJoin('Vacaciones as v', function ($join) {
                $join->on('empleados.Id', '=', 'v.Id_Empleado')
                    ->where('v.FechaInicio', '<=', DB::raw('DATE(en.Fecha)'))
                    ->where('v.FechaFin', '>=', DB::raw('DATE(en.Fecha)'));
            })
            ->leftJoin('Incapacidad as i', function ($join) {
                $join->on('empleados.Id', '=', 'i.Id_Empleado')
                    ->where('i.FechaInicio', '<=', DB::raw('DATE(en.Fecha)'))
                    ->where('i.FechaFin', '>=', DB::raw('DATE(en.Fecha)'));
            })
            ->select(
                'empleados.NumNomina',
                'en.Fecha as Fecha',
                DB::raw('
            CASE DAYOFWEEK(en.Fecha)
                WHEN 1 THEN "Domingo"
                WHEN 2 THEN "Lunes"
                WHEN 3 THEN "Martes"
                WHEN 4 THEN "Miércoles"
                WHEN 5 THEN "Jueves"
                WHEN 6 THEN "Viernes"
                WHEN 7 THEN "Sábado"
            END AS Dia
            '),
                DB::raw('CONCAT(empleados.Nombre, " ", empleados.ApePat, " ", empleados.ApeMat) as NombreCompleto'),
                DB::raw('MAX(CASE WHEN en.Id_numEntradas = 1 THEN en.HoraEntrada END) AS `Hora de Entrada 1`'),
                DB::raw('MAX(CASE WHEN s.Id_numSalidas = 1 THEN s.HoraSalida END) AS `Hora de Salida 1`'),
                DB::raw('MAX(CASE WHEN en.Id_numEntradas = 2 THEN e2.HoraEntrada END) AS `Hora de Entrada 2`'),
                DB::raw('MAX(CASE WHEN s2.Id_numSalidas = 2 THEN s2.HoraSalida END) AS `Hora de Salida 2`'),
                DB::raw('(SELECT COALESCE(SUM(he.TotalHoras), 0) FROM HorasExtras he WHERE he.Id_Empleado = empleados.Id AND DATE(he.Fecha) = en.Fecha) AS `Horas Extras`'),
                DB::raw('ROUND(
                (
                    TIME_TO_SEC(TIMEDIFF(
                        COALESCE(MAX(CASE WHEN s.Id_numSalidas = 1 THEN s.HoraSalida END), "00:00:00"),
                        COALESCE(MAX(CASE WHEN en.Id_numEntradas = 1 THEN en.HoraEntrada END), "00:00:00")
                    )) +
                    TIME_TO_SEC(TIMEDIFF(
                        COALESCE(MAX(CASE WHEN s2.Id_numSalidas = 2 THEN s2.HoraSalida END), "00:00:00"),
                        COALESCE(MAX(CASE WHEN e2.Id_numEntradas = 2 THEN e2.HoraEntrada END), "00:00:00")
                    )) +
                    COALESCE((SELECT SUM(he.TotalHoras) FROM HorasExtras he WHERE he.Id_Empleado = empleados.Id AND DATE(he.Fecha) = en.Fecha), 0) * 3600
                ) / 3600
            , 2) AS `Total De Horas Laboradas`'),
                'a.Nombre AS Área',
                DB::raw('CASE
                WHEN v.Id IS NOT NULL THEN "Vacaciones"
                WHEN i.Id IS NOT NULL THEN "Incapacidad"
                ELSE ""
            END AS Estado')
            )
            ->groupBy('empleados.Id', 'en.Fecha', 'v.Id', 'i.Id')
            ->orderBy('empleados.NumNomina')
            ->orderBy('en.Fecha');
        // Aplicar filtros si se seleccionó un área y una fecha
        if ($areaId) {
            $empleadosAreaQuery->where('empleados.Id_Area', $areaId);
        }
        if ($fecha) {
            $empleadosAreaQuery->whereDate('en.Fecha', $fecha);
        }

        // Aplicar filtro por modo de agrupación
        if ($areaId && $fecha) {
            $empleadosAreaQuery->groupBy('empleados.Id_Area');
        } elseif ($areaId) {
            $empleadosAreaQuery->groupBy('empleados.Id_Area');
        } elseif ($fecha) {
            // Si solo se selecciona una fecha y no un área, no agrupar por área
        }



        // Aplicar filtro por buscarpor numnomi,anombre,apepat,apemat
        /*if ($buscarpor) {
      $empleadosAreaQuery->where(function ($query) use ($buscarpor) {
          $query->where('empleados.NumNomina', 'LIKE', "%$buscarpor%")
              ->orWhere('empleados.Nombre', 'LIKE', "%$buscarpor%")
              ->orWhere('empleados.ApePat', 'LIKE', "%$buscarpor%")
              ->orWhere('empleados.ApeMat', 'LIKE', "%$buscarpor%");
      });
  }*/

        $empleados = $empleadosAreaQuery->paginate(100);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('paper', 'letter'); // Tamaño carta
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(view('horas.list_pdfHoras', ['empleados' => $empleados, 'areas' => $areas])->render());

        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        // Nombre del archivo PDF
        $nombreArchivo = 'ListaHoras_' . Carbon::now()->format('Ymd') . '.pdf';
        return $dompdf->stream($nombreArchivo);
    }

    public function imprimirExcelHoras(Request $request)
    {
        $fecha = $request->get('fecha');
        $area = $request->get('area');

        $horas = Hora::with(['empleado.area', 'entradas', 'salidas'])
            ->when($fecha, function ($query, $fecha) {
                return $query->where('Fecha', $fecha);
            })
            ->when($area, function ($query, $area) {
                return $query->whereHas('empleado', function ($q) use ($area) {
                    $q->where('Id_Area', $area);
                });
            })
            ->get();

        if ($horas->isEmpty()) {
            return back()->with('error', 'No hay registros para mostrar en el archivo Excel.');
        }

        return Excel::download(new HorasExport($horas), 'horas.xlsx');
    }


    public function exportHorasArea(Request $request)
    {


        $areaId = $request->input('area');
        $fecha = $request->input('fecha');
        $fechaFormateada = $fecha ? Carbon::parse($fecha)->format('Y-m-d') : null;

        // Obtener el nombre del área si se ha seleccionado
        $areaNombre = '';
        if ($areaId) {
            $areaNombre = Area::findOrFail($areaId)->nombre;
        }

        // Definir el valor de $buscarpor
        $buscarpor = $areaId;

        // Obtener la fecha actual
        $fechaDescarga = Carbon::now()->format('Y-m-d_H-i-s');

        // Nombre del archivo
        $fileName = "Horas_{$areaNombre}_{$fechaDescarga}.xlsx";

        // Descargar el archivo Excel
        return Excel::download(new HorasExportArea($areaId, $fechaFormateada), $fileName);
    }



    //********************************* */
    public function list(Request $request)
    {   // Obtener el ID de área y la fecha seleccionada del formulario de filtro
        $areaId = $request->input('area');
        $fecha = $request->input('fecha');

        // Obtener la lista de áreas para el select de filtrado
        $areas = Area::pluck('Nombre', 'Id'); // Asegúrate de tener el modelo 'Area' importado

        // Definir el valor de $buscarpor
        $buscarpor = $areaId;

        // Obtener la lista de empleados filtrada por área y fecha
        $query = Empleado::leftJoin('Entradas as en', 'Empleados.Id', '=', 'en.Id_Empleado')
            ->whereNotNull('en.Id')
            ->leftJoin('Salidas as s', function ($join) {
                $join->on('empleados.Id', '=', 's.Id_Empleado')
                    ->where('s.Id_numSalidas', '=', 1)
                    ->whereColumn('s.Fecha', 'en.Fecha');
            })
            ->leftJoin('Entradas as e2', function ($join) {
                $join->on('Empleados.Id', '=', 'e2.Id_Empleado')
                    ->where('e2.Id_numEntradas', '=', 2)
                    ->whereColumn('e2.Fecha', 'en.Fecha');
            })
            ->leftJoin('Salidas as s2', function ($join) {
                $join->on('empleados.Id', '=', 's2.Id_Empleado')
                    ->where('s2.Id_numSalidas', '=', 2)
                    ->whereColumn('s2.Fecha', 'en.Fecha');
            })
            ->leftJoin('HorasExtras as he', 'empleados.Id', '=', 'he.Id_Empleado')
            ->leftJoin('Areas as a', 'empleados.Id_Area', '=', 'a.Id')
            ->leftJoin('Vacaciones as v', function ($join) {
                $join->on('empleados.Id', '=', 'v.Id_Empleado')
                    ->where('v.FechaInicio', '<=', DB::raw('DATE(en.Fecha)'))
                    ->where('v.FechaFin', '>=', DB::raw('DATE(en.Fecha)'));
            })
            ->leftJoin('Incapacidad as i', function ($join) {
                $join->on('empleados.Id', '=', 'i.Id_Empleado')
                    ->where('i.FechaInicio', '<=', DB::raw('DATE(en.Fecha)'))
                    ->where('i.FechaFin', '>=', DB::raw('DATE(en.Fecha)'));
            })
            ->select(
                'empleados.Id as Id',
                'empleados.NumNomina',
                'en.Fecha as Fecha',
                DB::raw('
            CASE DAYOFWEEK(en.Fecha)
                WHEN 1 THEN "Domingo"
                WHEN 2 THEN "Lunes"
                WHEN 3 THEN "Martes"
                WHEN 4 THEN "Miércoles"
                WHEN 5 THEN "Jueves"
                WHEN 6 THEN "Viernes"
                WHEN 7 THEN "Sábado"
            END AS Dia
            '),
                DB::raw('CONCAT(empleados.Nombre, " ", empleados.ApePat, " ", empleados.ApeMat) as NombreCompleto'),
                DB::raw('MAX(CASE WHEN en.Id_numEntradas = 1 THEN en.HoraEntrada END) AS `Hora de Entrada 1`'),
                DB::raw('MAX(CASE WHEN s.Id_numSalidas = 1 THEN s.HoraSalida END) AS `Hora de Salida 1`'),
                DB::raw('MAX(CASE WHEN en.Id_numEntradas = 2 THEN e2.HoraEntrada END) AS `Hora de Entrada 2`'),
                DB::raw('MAX(CASE WHEN s2.Id_numSalidas = 2 THEN s2.HoraSalida END) AS `Hora de Salida 2`'),
                DB::raw('(SELECT COALESCE(SUM(he.TotalHoras), 0) FROM HorasExtras he WHERE he.Id_Empleado = empleados.Id AND DATE(he.Fecha) = en.Fecha) AS `Horas Extras`'),
                DB::raw('ROUND(
                (
                    TIME_TO_SEC(TIMEDIFF(
                        COALESCE(MAX(CASE WHEN s.Id_numSalidas = 1 THEN s.HoraSalida END), "00:00:00"),
                        COALESCE(MAX(CASE WHEN en.Id_numEntradas = 1 THEN en.HoraEntrada END), "00:00:00")
                    )) +
                    TIME_TO_SEC(TIMEDIFF(
                        COALESCE(MAX(CASE WHEN s2.Id_numSalidas = 2 THEN s2.HoraSalida END), "00:00:00"),
                        COALESCE(MAX(CASE WHEN e2.Id_numEntradas = 2 THEN e2.HoraEntrada END), "00:00:00")
                    )) +
                    COALESCE((SELECT SUM(he.TotalHoras) FROM HorasExtras he WHERE he.Id_Empleado = empleados.Id AND DATE(he.Fecha) = en.Fecha), 0) * 3600
                ) / 3600
            , 2) AS `Total De Horas Laboradas`'),
                'a.Nombre AS Área',
                DB::raw('CASE
                WHEN v.Id IS NOT NULL THEN "Vacaciones"
                WHEN i.Id IS NOT NULL THEN "Incapacidad"
                ELSE ""
            END AS Estado')
            )
            ->groupBy('empleados.Id', 'en.Fecha', 'v.Id', 'i.Id')
            ->orderBy('empleados.NumNomina')
            ->orderBy('en.Fecha');


        // Aplicar filtros si se seleccionó un área y una fecha
        if ($areaId) {
            $query->where('empleados.Id_Area', $areaId);
        }
        if ($fecha) {
            $query->whereDate('en.Fecha', $fecha);
        }

        // Continuar con la consulta y paginación
        // $empleados = $query->paginate(6);
        $empleados = $query->get();

        return view('horas.list', compact('empleados', 'areas', 'fecha', 'buscarpor'));
    }




    public function view()
    {
        return view('horas.view');
    }

    /*********************************/
    public function horasEntradas()
    {
        $areas = Area::pluck('Nombre', 'Id');
        $numEntrada = NumEntrada::pluck('Nombre', 'Id');

        $empleados = Empleado::whereIn('Id', function ($query) {
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
        })->get();

        $totalEmpleados = $empleados->count();
        $numAusencias = $empleados->count();

        return view('horas.horasEntradas', [
            'empleados' => $empleados,
            'areas' => $areas,
            'totalEmpleados' => $totalEmpleados,
            'numAusencias' => $numAusencias,
            'numEntrada' => $numEntrada
        ]);
    }

    public function storeHorasEntradas(Request $request)
    {
        // Validar los campos requeridos
        $request->validate([
            'fecha' => 'required|date',
            'area' => 'required|int',
        ]);

        // Obtener el ID del área
        $areaId = $request->input('area');

        // Obtener los números de nómina seleccionados
        $numNominas = $request->input('numNominaSelect', []);

        // Obtener los empleados del área que no tienen registro de baja reciente
        $empleadosArea = Empleado::select('Empleados.*')
            ->where('Id_Area', $areaId)
            ->where(function ($query) {
                $query->whereNotExists(function ($subquery) {
                    $subquery->select(DB::raw(1))
                        ->from('Bajas')
                        ->whereRaw('Bajas.Id_Empleado = Empleados.Id');
                })->orWhereExists(function ($subquery) {
                    $subquery->select(DB::raw(1))
                        ->from('ReIngresos')
                        ->whereColumn('ReIngresos.Id_Empleado', '=', 'Empleados.Id')
                        ->whereRaw('ReIngresos.FechaReIngreso > (SELECT MAX(FechaBaja) FROM Bajas WHERE Bajas.Id_Empleado = Empleados.Id)');
                });
            })
            ->get();

        // Iterar sobre los empleados del área para guardar las horas extras
        foreach ($empleadosArea as $empleado) {
            //verifica que si el empleado no esta seleccionado en la vista
            if (!in_array($empleado->NumNomina, $numNominas)) {
                // Verificar si el empleado está de vacaciones en la fecha seleccionada
                $vacacion = Vacaciones::where('Id_Empleado', $empleado->Id)
                    ->where('FechaInicio', '<=', $request->input('fecha'))
                    ->where('FechaFin', '>=', $request->input('fecha'))
                    ->exists();

                // Verificar si el empleado está de incapacidad en la fecha seleccionada
                $incapacidad = Incapacidad::where('Id_Empleado', $empleado->Id)
                    ->where('FechaInicio', '<=', $request->input('fecha'))
                    ->where('FechaFin', '>=', $request->input('fecha'))
                    ->exists();

                // Si el empleado está de vacaciones o incapacidad, asignar hora de entrada como '0:00'
                $horaEntrada = $vacacion || $incapacidad ? '0:00' : $request->input('horaEntrada');

                // Crear el registro de hora de entrada
                HoraEntrada::create([
                    'Id_numEntradas' => $request->input('numEntrada'),
                    'HoraEntrada' => $horaEntrada,
                    'Fecha' => $request->input('fecha'),
                    'TotalAsistencias' => $request->input('totalAsistencias'),
                    'Id_area' => $areaId,
                    'Id_Empleado' => $empleado->Id,
                ]);
            }
        }

        // Retornar vista de mensaje de éxito
        return view('Horas.message', ['msg' => 'Registro exitoso de horas de entrada']);
    }



    /*********************************/
    public function horasSalidas()
    {

        $areas = Area::pluck('Nombre', 'Id');
        $numSalida = NumSalida::pluck('Nombre', 'Id');
        // Consulta para obtener solo los empleados que no tienen registro en la tabla de bajas
        $empleados = Empleado::whereIn('Id', function ($query) {
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
        })->get();

        $totalEmpleados = $empleados->count();
        $numAusencias = $empleados->count();

        return view('horas.horasSalidas', [
            'empleados' => $empleados,
            'areas' => $areas,
            'totalEmpleados' => $totalEmpleados,
            'numAusencias' => $numAusencias,
            'numSalida' => $numSalida
        ]);
    }
    public function storeHorasSalidas(Request $request)
    {
        $request->validate([
            'Fecha' => 'required|date'
        ]);

        $areaId = $request->input('area');

        // Obtener los empleados seleccionados por su número de nómina
        $numNominas = $request->input('numNominaSelect', []); // Si no hay seleccionados, se asigna un arreglo vacío

        // Obtener todos los empleados de esa área que cumplen con la condición de baja y reingreso
        $empleadosArea = Empleado::select('Empleados.*')
            ->where('Id_Area', $areaId)
            ->where(function ($query) {
                $query->whereNotExists(function ($subquery) {
                    $subquery->select(DB::raw(1))
                        ->from('Bajas')
                        ->whereRaw('Bajas.Id_Empleado = Empleados.Id');
                })->orWhereExists(function ($subquery) {
                    $subquery->select(DB::raw(1))
                        ->from('ReIngresos')
                        ->whereColumn('ReIngresos.Id_Empleado', '=', 'Empleados.Id')
                        ->whereRaw('ReIngresos.FechaReIngreso > (SELECT MAX(FechaBaja) FROM Bajas WHERE Bajas.Id_Empleado = Empleados.Id)');
                });
            })
            ->get();

        // Iterar sobre los empleados del área para guardar las horas extras
        foreach ($empleadosArea as $empleado) {
            if (!in_array($empleado->NumNomina, $numNominas)) {
                // Si el número de nómina no está seleccionado, guardar las horas extras
                // Verificar si el empleado está de vacaciones en la fecha seleccionada
                $vacacion = Vacaciones::where('Id_Empleado', $empleado->Id)
                    ->where('FechaInicio', '<=', $request->input('Fecha'))
                    ->where('FechaFin', '>=', $request->input('Fecha'))
                    ->exists();

                // Verificar si el empleado está de incapacidad en la fecha seleccionada
                $incapacidad = Incapacidad::where('Id_Empleado', $empleado->Id)
                    ->where('FechaInicio', '<=', $request->input('Fecha'))
                    ->where('FechaFin', '>=', $request->input('Fecha'))
                    ->exists();

                // Si el empleado está de vacaciones o incapacidad, asignar hora de entrada como '0:00'
                $HoraSalida = $vacacion || $incapacidad ? '00:00' : $request->input('HoraSalida');

                HoraSalida::create([
                    'HoraSalida' => $HoraSalida, // Usar $HoraSalida en lugar de $request->input('HoraSalida')
                    'Fecha' => $request->input('Fecha'),
                    'TotalAsistencias' => $request->input('totalAsistencias'),
                    'Id_numSalidas' => $request->input('numSalida'), // Obtener el número de entrada del formulario
                    'Id_Area' => $areaId,
                    'Id_Empleado' => $empleado->Id,
                ]);
            }
        }

        return view('Horas.message', ['msg' => 'Registro exitoso de horas de salida.']);
    }



    /*********************************/
    public function horasExtras(Request $request)
    {
        // Obtener todas las áreas para el formulario de selección
        $areas = Area::pluck('Nombre', 'Id');

        // Consulta para obtener solo los empleados que no tienen registro en la tabla de bajas
        $empleados = Empleado::whereIn('Id', function ($query) {
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
        })->get();

        // Contar el total de empleados y ausencias (que en este caso serán los mismos, ya que son los empleados sin bajas)
        $totalEmpleados = $empleados->count();
        $numAusencias = $empleados->count();

        // Retornar la vista con los datos necesarios
        return view('horas.horasExtras', [
            'empleados' => $empleados,
            'areas' => $areas,
            'totalEmpleados' => $totalEmpleados,
            'numAusencias' => $numAusencias
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'horaInicio' => 'required|date_format:H:i',
            'horaFin' => 'required|date_format:H:i',
            'fecha' => 'required|date',
            'area' => 'required|int',
        ]);

        $areaId = $request->input('area');

        // Obtener los empleados seleccionados por su número de nómina
        $numNominas = $request->input('numNominaSelect', []); // Si no hay seleccionados, se asigna un arreglo vacío

        // Obtener todos los empleados del área que no tienen registro en la tabla de bajas
        $empleadosAreaSinBajas = Empleado::select('Empleados.*')
            ->where('Id_Area', $areaId)
            ->where(function ($query) {
                $query->whereNotExists(function ($subquery) {
                    $subquery->select(DB::raw(1))
                        ->from('Bajas')
                        ->whereRaw('Bajas.Id_Empleado = Empleados.Id');
                })->orWhereExists(function ($subquery) {
                    $subquery->select(DB::raw(1))
                        ->from('ReIngresos')
                        ->whereColumn('ReIngresos.Id_Empleado', '=', 'Empleados.Id')
                        ->whereRaw('ReIngresos.FechaReIngreso > (SELECT MAX(FechaBaja) FROM Bajas WHERE Bajas.Id_Empleado = Empleados.Id)');
                });
            })
            ->get();

        // Filtrar los empleados que no están seleccionados
        $empleadosNoSeleccionadosSinBajas = $empleadosAreaSinBajas->whereNotIn('NumNomina', $numNominas);

        // Iterar sobre los empleados no seleccionados y sin bajas para guardar sus horas extras
        foreach ($empleadosNoSeleccionadosSinBajas as $empleado) {
            Hora::create([
                'HoraInicio' => $request->input('horaInicio'),
                'HoraFin' => $request->input('horaFin'),
                'Fecha' => $request->input('fecha'),
                'TotalHoras' => $request->input('totalHoras'),
                'TotalAsistencias' => $request->input('totalAsistencias'),
                'Id_area' => $areaId,
                'Id_Empleado' => $empleado->Id,
            ]);
        }

        return view('Horas.message', ['msg' => 'Registro exitoso de horas extras.']);
    }





    public function getTotalEmpleados()
    {
        $totalEmpleados = Empleado::count();
        return response()->json(['totalEmpleados' => $totalEmpleados]);
    }







    public function editHorasExtras(Request $request)
    {
        // Obtener todas las áreas para el formulario de selección
        $areas = Area::pluck('Nombre', 'Id');

        // Consulta para obtener solo los empleados que no tienen registro en la tabla de bajas
        $empleados = Empleado::whereIn('Id', function ($query) {
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
        })->get();

        // Contar el total de empleados y ausencias (que en este caso serán los mismos, ya que son los empleados sin bajas)
        $totalEmpleados = $empleados->count();
        $numAusencias = $empleados->count();

        // Retornar la vista con los datos necesarios
        return view('horas.editHorasExtras', [
            'empleados' => $empleados,
            'areas' => $areas,
            'totalEmpleados' => $totalEmpleados,
            'numAusencias' => $numAusencias
        ]);
    }






    public function obtenerDatos(Request $request)
    {



        // Obtener la fecha y el área del request
        $fecha = $request->get('fecha');
        $areaId = $request->get('area');

        // Obtener los números de nómina seleccionados por el usuario
        $numNominasSeleccionados = $request->get('numNominaSelect', []);

        // Obtener todos los empleados del área que no tienen registro en la tabla de bajas
        $empleadosAreaSinBajas = Empleado::where('Id_Area', $areaId)
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('Bajas')
                    ->whereRaw('Bajas.Id_Empleado = Empleados.Id');
            })
            ->get();

        // Obtener los datos de las horas extras de los empleados del área y fecha especificados
        $horasExtras = Hora::whereIn('Id_Empleado', $empleadosAreaSinBajas->pluck('Id')->toArray())
            ->where('Fecha', $fecha)
            ->get();

        // Filtrar los empleados que no están seleccionados
        $empleadosNoSeleccionadosSinBajas = $empleadosAreaSinBajas->whereNotIn('NumNomina', $numNominasSeleccionados);

        // Preparar los datos para enviar como respuesta JSON
        $datos = [
            'horaInicio' => $horasExtras->pluck('HoraInicio')->first(),
            'horaFin' => $horasExtras->pluck('HoraFin')->first(),
            'numNomina' => $empleadosNoSeleccionadosSinBajas->pluck('NumNomina')->toArray(),
            'numNominaSeleccionados' => $numNominasSeleccionados
        ];

        // Devolver los datos como respuesta JSON
        return response()->json($datos);
    }



    public function eliminarRegistro($numNomina, $fecha)
    {
        try {
            // Obtener el registro a eliminar
            $empleado = Empleado::where('NumNomina', $numNomina)->firstOrFail();

            // Obtener el ID del empleado
            $idEmpleado = $empleado->Id;

            // Eliminar el registro de HorasExtras
            Hora::where('Id_Empleado', $idEmpleado)->where('Fecha', $fecha)->delete();

            // Eliminar el registro de Entradas
            HoraEntrada::where('Id_Empleado', $idEmpleado)->where('Fecha', $fecha)->delete();

            // Eliminar el registro de Salidas
            HoraSalida::where('Id_Empleado', $idEmpleado)->where('Fecha', $fecha)->delete();

            // Retornar una respuesta exitosa
            return redirect()->route('horas.list')->with('msg', 'Empleado Eliminado Correctamente.');
        } catch (\Exception $e) {
            // Retornar una respuesta de error en caso de que ocurra alguna excepción
            return response()->json(['message' => 'Error al eliminar los registros', 'error' => $e->getMessage()], 500);
        }
    }

// Controller method
public function eliminarTodos(Request $request)
{
    // Eliminar registros de la tabla Hora
    $horasExtras = Hora::query();
    if ($request->has('area') && $request->area != '') {
        $horasExtras->whereHas('empleado', function ($query) use ($request) {
            $query->where('Id_Area', $request->area);
        });
    }
    if ($request->has('fecha') && $request->fecha != '') {
        $horasExtras->where('Fecha', $request->fecha);
    }
    $horasExtrasDeleted = $horasExtras->delete();

    // Eliminar registros de la tabla HoraEntrada
    $horasEntrada = HoraEntrada::query();
    if ($request->has('area') && $request->area != '') {
        $horasEntrada->whereHas('empleado', function ($query) use ($request) {
            $query->where('Id_Area', $request->area);
        });
    }
    if ($request->has('fecha') && $request->fecha != '') {
        $horasEntrada->where('Fecha', $request->fecha);
    }
    $horasEntradaDeleted = $horasEntrada->delete();

    // Eliminar registros de la tabla HoraSalida
    $horasSalida = HoraSalida::query();
    if ($request->has('area') && $request->area != '') {
        $horasSalida->whereHas('empleado', function ($query) use ($request) {
            $query->where('Id_Area', $request->area);
        });
    }
    if ($request->has('fecha') && $request->fecha != '') {
        $horasSalida->where('Fecha', $request->fecha);
    }
    $horasSalidaDeleted = $horasSalida->delete();

    // Responder con éxito si se eliminaron registros de al menos una tabla
    if ($horasExtrasDeleted || $horasEntradaDeleted || $horasSalidaDeleted) {
         // Retornar una respuesta exitosa
         return redirect()->route('horas.list')->with('msg', 'Empleado Eliminado Correctamente.');
    } else {
        return response()->json(['success' => false]);
    }
}

}

