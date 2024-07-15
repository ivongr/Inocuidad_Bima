<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoraSalida extends Model
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

      public function numSalidas()
      {
          return $this->belongsTo(numSalida::class, 'Id_numSalidas', 'Id');
      }

      protected $table = 'Salidas';
         //para desactivar el time at de  migrate
    public $timestamps = false;

    // Definir las columnas que pueden ser asignadas en masa
    protected $fillable = ['Id','HoraSalida', 'TotalAsistencias', 'Fecha','Id_Empleado','Id_Area','Id_numSalidas'];
}

