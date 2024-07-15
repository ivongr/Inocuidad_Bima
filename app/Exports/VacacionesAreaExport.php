<?php
namespace App\Exports;

use App\Models\Vacaciones;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class VacacionesAreaExport implements FromCollection, WithHeadings
{
   protected $areaId;
protected $fechaInicio;
protected $fechaFin;

public function __construct($areaId, $fechaInicio, $fechaFin)
{
    $this->areaId = $areaId;
    $this->fechaInicio = $fechaInicio;
    $this->fechaFin = $fechaFin;
}


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
        $query = Vacaciones::query()
            ->join('Empleados', 'Vacaciones.Id_Empleado', '=', 'Empleados.Id')
            ->join('Areas', 'Empleados.Id_Area', '=', 'Areas.Id');
    
        if ($this->areaId) {
            $query->where('Areas.Id', $this->areaId);
        }
        if ($this->fechaInicio && $this->fechaFin) {
            $query->where(function ($query) {
                $query->whereBetween('Vacaciones.FechaInicio', [$this->fechaInicio, $this->fechaFin])
                      ->whereBetween('Vacaciones.FechaFin', [$this->fechaInicio, $this->fechaFin]);
            });
        } elseif ($this->fechaInicio) {
            $query->where(function ($query) {
                $query->where('Vacaciones.FechaInicio', '=', $this->fechaInicio)
                      ->orWhere('Vacaciones.FechaFin', '=', $this->fechaInicio);
            });
        } elseif ($this->fechaFin) {
            $query->where(function ($query) {
                $query->where('Vacaciones.FechaInicio', '=', $this->fechaFin)
                      ->orWhere('Vacaciones.FechaFin', '=', $this->fechaFin);
            });
        }
        
        $vacaciones = $query->select(
            'Empleados.NumNomina as Número de Nómina',
            DB::raw("CONCAT(Empleados.Nombre, ' ', Empleados.ApePat, ' ', Empleados.ApeMat) as 'Nombre Completo'"),
            'Areas.Nombre as Área',
            'Vacaciones.FechaInicio as Fecha de Inicio',
            'Vacaciones.FechaFin as Fecha de Fin',
            'Vacaciones.TotalDias as Días'
        )->get();
    
        return $vacaciones;
    }
    
}
    