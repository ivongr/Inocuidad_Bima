<?php

namespace App\Exports;
use App\Models\Empleado;

use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class HorasExportArea implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

     protected $area;
     protected $fecha;

     public function __construct($area, $fecha)
     {
         $this->area = $area;
         $this->fecha = $fecha;
     }

     public function headings(): array
     {
         return [
             'Número de Nómina',
             'Fecha',
             'Día',
             'Nombre Completo',
             'Hora de Entrada',
             'Hora de Salida',
             'Hora de Entrada',
             'Hora de Salida',
             'Horas Extras',
             'Total De Horas Laboradas',
             'Área',
             'Descripción',
             'Firma'


         ];
     }

     public function collection()
     {
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
            DB::raw('MAX(CASE WHEN v.Id IS NOT NULL THEN "Vacaciones" WHEN i.Id IS NOT NULL THEN "Incapacidad" ELSE "" END) AS Estado')

        );

         // Aplicar filtros
         if ($this->area) {
             $query->where('empleados.Id_Area', $this->area);
         }
         if ($this->fecha) {
             $query->whereDate('en.Fecha', $this->fecha);
         }

         $query->groupBy('empleados.Id', 'en.Fecha')
             ->orderBy('empleados.NumNomina')
             ->orderBy('Estado')
             ->orderBy('en.Fecha');

         return $query->get();
     }

    }
