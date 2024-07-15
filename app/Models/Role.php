<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Role extends Model
{
    use HasFactory;

    // Definimos los campos que pueden ser asignados de forma masiva
    protected $fillable = ['name', 'guard_name'];

    // Definimos la relación de muchos a muchos con el modelo User
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    // Método estático para crear un nuevo rol de empleado
    public static function createRoles()
    {
        // Creamos los tres roles: empleado, inocuidad y administrador
        self::create(['name' => 'empleado', 'guard_name' => 'web']);

        ///firstorcreate es que va validar si yta existe un valor sino l
        self::firstOrCreate(['name' => 'inocuidad', 'guard_name' => 'web']);
    self::firstOrCreate(['name' => 'administrador', 'guard_name' => 'web']);

    }
    


}
