<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumBaja extends Model
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
       protected $table = 'NumBaja';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
 
}
