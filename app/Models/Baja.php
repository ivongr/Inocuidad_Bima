<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Baja extends Model
{
    use HasFactory;
    protected $table = 'Bajas';

    protected $fillable = ['Id','FechaBaja','Id_Empleado','Id_NumBaja'];
    //para desactivar el time at de  migrate
    public $timestamps = false;

    public function empleado()
    {
        return $this->belongsTo(Empleado::class, 'Id_Empleado');
    }

    public function NumBaja()
    {
        return $this->hasMany(\App\Models\NumBaja::class, 'Id', 'Id_NumBaja');
    }



}
