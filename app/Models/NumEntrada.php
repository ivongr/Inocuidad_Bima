<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumEntrada extends Model
{
    use HasFactory;

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

    protected $date = ['Id','Nombre'];
       //para desactivar el time at de  migrate
       public $timestamps = false;

       //PROTEGER BASE DE DATIS
       protected $table = 'numEntradas';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Entradas()
    {
        return $this->hasMany(\App\Models\Entrada::class, 'Id', 'Id_numEntradas');
    }


}
