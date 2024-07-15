<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrada extends Model
{
    use HasFactory;

    public function numEntradas()
    {
        return $this->hasMany(NumEntrada::class, 'Id_numEntradas', 'Id');
    }
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

       //para desactivar el time at de  migrate
    public $timestamps = false;

        // Definir las columnas que pueden ser asignadas en masa
    protected $fillable = ['Id', 'HoraEntrada', 'Fecha', 'TotalAsistencias', 'Id_Empleado', 'Id_Area', 'Id_numEntradas'];
}
