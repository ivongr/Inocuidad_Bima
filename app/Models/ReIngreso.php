<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReIngreso extends Model
{
    use HasFactory;
    protected $table = 'ReIngresos';

    protected $fillable = ['Id','FechaReIngreso','Id_Empleado','Id_NumReIngreso'];
    //para desactivar el time at de  migrate
    public $timestamps = false;

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'Id_Empleado');
    }

    public function NumReIngreso()
    {
        return $this->hasMany(\App\Models\Entrada::class, 'Id', 'Id_NumReIngreso');
    }


}
