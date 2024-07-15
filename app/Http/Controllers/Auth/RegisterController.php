<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    
    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
 
  
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    
        // Asignar roles según la selección del formulario
        if ($data['role'] === 'administrador') {
            $user->assignRole('administrador');
           // dd('Rol asignado correctamente');
        } else if ($data['role'] === 'inocuidad') {
            $user->assignRole('inocuidad');
        } else {
            $user->assignRole('empleado');
        }
        
    
        return $user;
    }
    protected function registered($request, $user)
{
    if ($user->hasRole('administrador')) {
        return redirect('/perfil-administrador'); // Ruta del perfil del administrador
    } else {
        return redirect('/home'); // Otra ruta a la que desees redirigir
    }
}

    

}
