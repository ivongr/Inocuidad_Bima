<?php

namespace App\Exports;

use App\Empleado;

use Illuminate\Support\Facades\DB;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EmpleadosExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
   
     public function headings(): array
     {
         return [
             'Número de Nómina',
             'Nombre Completo',
             'Número de Seguridad',
             'RFC',
             'Área',
             'Fecha de ingreso',
         
         ];
     }
 
     public function collection()
     {
        $empleadosQuery = DB::table('Empleados as empleados')
        ->select( 
            DB::raw('empleados.NumNomina'),
            DB::raw('CONCAT(empleados.Nombre, " ", empleados.ApePat, " ", empleados.ApeMat) AS nombre_completo'),
            DB::raw('empleados.NumSeguridad'),
            DB::raw('empleados.Rfc'),
            DB::raw('areas.Nombre AS nombre_area'),
            DB::raw('COALESCE((SELECT FechaReIngreso FROM ReIngresos WHERE Id_Empleado = empleados.Id ORDER BY FechaReIngreso DESC LIMIT 1),
            (SELECT FechaBaja FROM Bajas WHERE Id_Empleado = empleados.Id ORDER BY FechaBaja DESC LIMIT 1), empleados.FechaIngreso) AS FechaUltimoReingreso'),
            DB::raw('MAX(b.FechaBaja) AS FechaBaja'))
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
        })
        ->groupBy('empleados.Id');
 
    $empleados = $empleadosQuery->get();
    
    return $empleados;
    
     }
     
 }