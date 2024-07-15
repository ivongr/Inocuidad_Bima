<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class Admin extends Model
{
    use HasFactory;

    public static function createAdminUser($name, $email, $password, $roleName)
    {
        // Crear el usuario
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = Hash::make($password);
        $user->save();

        // Verificar si el usuario se creó correctamente
        if ($user) {
            echo "Usuario creado correctamente.";

            // Asignar el rol al usuario
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $user->assignRole($roleName);
                echo "Rol asignado correctamente.";
            } else {
                echo "El rol no existe.";
            }
        } else {
            echo "Hubo un error al crear el usuario.";
        }
    }

    public static function createAdmin()
    {
        self::createAdminUser('Itzel Ivón García Rosas', 'Ivon2001', '12345678', 'administrador');
    }
}
