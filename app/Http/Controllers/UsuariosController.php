<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Importar la clase DB
use Illuminate\Support\Facades\DB;
// Importar el modelo User
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuariosController extends Controller
{
    //
    public function list()
    {
        $users = DB::table('users as u')
    ->select('u.id', 'u.name as user_name', 'u.email as user_email', 'u.password as user_password', 'r.name as role_name')
    ->join('model_has_roles', 'u.id', '=', 'model_has_roles.model_id')
    ->join('roles as r', 'model_has_roles.role_id', '=', 'r.id')
    ->get();



        return view('usuarios.list', ['users' => $users]);
    }


    public function view()
    {


        return view('usuarios.view');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return view("Usuarios.message", ['msg' => "Usuario Eliminado Correctamente."]);
    }



    public function updatePassword(Request $request, $id)
    {
        $user = User::find($id);
        if (!$user) {
            return redirect()->back()->with('error', 'Usuario no encontrado.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Contraseña actualizada correctamente.');
    }


}
