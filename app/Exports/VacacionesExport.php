<?php

namespace App\Exports;


use App\Models\Vacaciones;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VacacionesExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
   
     public function headings(): array
     {
         return [
             'Número de Nómina',
             'Nombre Completo',
             'Área',
             'Fecha de Inicio',
             'Fecha de Fin',
             'Días',
         ];
     }
 
     public function collection()
     {
        $vacaciones = DB::table('Vacaciones as v')
        ->select(
            'e.NumNomina as Número de Nómina',
            DB::raw('CONCAT(e.Nombre, " ", e.ApePat, " ", e.ApeMat) as NombreCompleto'),
            'a.Nombre as Área',
            'v.FechaInicio as Fecha de Inicio',
            'v.FechaFin as Fecha de Fin',
            'v.TotalDias as Días'
        )
        ->join('Empleados as e', 'v.Id_Empleado', '=', 'e.Id')
        ->join('Areas as a', 'e.Id_Area', '=', 'a.Id')
        ->get();

    return $vacaciones;
}
}