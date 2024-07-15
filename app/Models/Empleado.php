<?php

namespace App\Models;
use App\Models\EmpleadoController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vacaciones;
use App\Models\Hora;
use App\Models\Baja;
class Empleado extends Model
{
    public function entradas()
    {
        return $this->hasMany(HoraEntrada::class, 'Id_Empleado', 'Id');
    }

  
     /*RELACIÓN DE LA TABLA AREA, VACACIONES*/
    /* PASAR EL COMBOBOX */
    public function area()
    {
        //CHECAR EL NOMBRE DEL ID EN LA BASE DE DATOS
        return $this->belongsTo(Area::class,'Id_Area','Id');
    }
    public function vacaciones()
    {
        return $this->hasMany(Vacaciones::class, 'Id_Empleado', 'Id');
    }

    public function Bajas()
    {
        return $this->hasMany(Baja::class, 'Id_Empleado', 'Id');
    }

    public function ReIngreso()
    {
        return $this->hasMany(ReIngreso::class, 'Id_Empleado', 'Id');
    }

   // Empleado.php


public function salidas()
{
    return $this->hasMany(Salida::class, 'Id_Empleado');
}

public function horasExtras()
{
    return $this->hasMany(Hora::class, 'Id_Empleado');
}


    /**/
    //para desactivar el time at de  migrate
    public $timestamps = false;

    // Definir las columnas que pueden ser asignadas en masa
    protected $fillable = ['Id','NumNomina', 'Nombre', 'ApePat', 'ApeMat', 'NumSeguridad', 'Rfc', 'Id_area', 'FechaIngreso'];

}
