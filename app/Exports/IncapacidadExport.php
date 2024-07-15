<?php

namespace App\Exports;


use App\Models\Incapacidad;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IncapacidadExport implements FromCollection, WithHeadings
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
        $incapacidades = DB::table('Incapacidad as i')
        ->select(
            'e.NumNomina as Número de Nómina',
            DB::raw('CONCAT(e.Nombre, " ", e.ApePat, " ", e.ApeMat) as NombreCompleto'),
            'a.Nombre as Área',
            'i.FechaInicio as Fecha de Inicio',
            'i.FechaFin as Fecha de Fin',
            'i.TotalDias as Días'
        )
        ->join('Empleados as e', 'i.Id_Empleado', '=', 'e.Id')
        ->join('Areas as a', 'e.Id_Area', '=', 'a.Id')
        ->get();

    return $incapacidades;
}
}