<?php
namespace App\Exports;

use App\Models\Incapacidad;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IncapacidadAreaExport implements FromCollection, WithHeadings
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
        $query = Incapacidad::query()
            ->join('Empleados', 'Incapacidad.Id_Empleado', '=', 'Empleados.Id')
            ->join('Areas', 'Empleados.Id_Area', '=', 'Areas.Id');
    
        if ($this->areaId) {
            $query->where('Areas.Id', $this->areaId);
        }
        if ($this->fechaInicio && $this->fechaFin) {
            $query->where(function ($query) {
                $query->whereBetween('Incapacidad.FechaInicio', [$this->fechaInicio, $this->fechaFin])
                      ->whereBetween('Incapacidad.FechaFin', [$this->fechaInicio, $this->fechaFin]);
            });
        } elseif ($this->fechaInicio) {
            $query->where(function ($query) {
                $query->where('Incapacidad.FechaInicio', '=', $this->fechaInicio)
                      ->orWhere('Incapacidad.FechaFin', '=', $this->fechaInicio);
            });
        } elseif ($this->fechaFin) {
            $query->where(function ($query) {
                $query->where('Incapacidad.FechaInicio', '=', $this->fechaFin)
                      ->orWhere('Incapacidad.FechaFin', '=', $this->fechaFin);
            });
        }
        
        $incapacidad = $query->select(
            'Empleados.NumNomina as Número de Nómina',
            DB::raw("CONCAT(Empleados.Nombre, ' ', Empleados.ApePat, ' ', Empleados.ApeMat) as 'Nombre Completo'"),
            'Areas.Nombre as Área',
            'Incapacidad.FechaInicio as Fecha de Inicio',
            'Incapacidad.FechaFin as Fecha de Fin',
            'Incapacidad.TotalDias as Días'
        )->get();
    
        return $incapacidad;
    }
    
}
    