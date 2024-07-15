<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Area
 *
 * @property $Id
 * @property $Nombre
 *
 * @property Empleado[] $empleados
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Area extends Model
{

    static $rules = [
		'Id' => 'required',
		'Nombre' => 'required|string',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['Id','Nombre'];
       //para desactivar el time at de  migrate
       public $timestamps = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function empleados()
    {
        return $this->hasMany(\App\Models\Empleado::class, 'Id', 'Id_Area');
    }
    


}
