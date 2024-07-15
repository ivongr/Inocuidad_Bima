<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacaciones extends Model
{
    use HasFactory;


    public function area()
    {
        //CHECAR EL NOMBRE DEL ID EN LA BASE DE DATOS
        return $this->belongsTo(Area::class,'Id_Area','Id');
    }

      /* PASAR EL COMBOBOX */
      public function empleado()
      {
          return $this->belongsTo(Empleado::class, 'Id_Empleado', 'Id');
      }
      
      protected $table = 'vacaciones';
         //para desactivar el time at de  migrate
    public $timestamps = false;

    // Definir las columnas que pueden ser asignadas en masa
    protected $fillable = ['Id','NumNomina', 'FechaInicio', 'FechaFin', 'TotalDias', 'Id_Empleado'];

}
