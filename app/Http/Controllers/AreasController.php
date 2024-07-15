<?php


namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Area; // Importar el modelo Area

class AreasController extends Controller
{
    public function view()
    {
        return view('areas.view');
    }

    public function create()
    {
        return view('areas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:25|unique:areas,nombre'], [
                'nombre.unique' => 'Existe un área con el mismo nombre.',
        ]);

        $area = new Area();
        $area->nombre = $request->input('nombre');
        $area->save();


    return view('areas.meNssage', ['msg' => 'Guardado exitoso']);
    }

    public function list()
    {
        $areas = Area::all();
        return view('areas.list', ['areas' => $areas]);
    }

    public function destroy($Id)
    {
        // Verificar si hay empleados asociados al área
        $empleados = DB::table('empleados')->where('Id_Area', $Id)->get();
    
        // Si hay empleados asociados, eliminarlos primero
        if ($empleados->isNotEmpty()) {
            foreach ($empleados as $empleado) {
                DB::table('empleados')->where('Id', $empleado->Id)->delete();
            }
        }
    
        // Luego eliminar el área
        DB::table('areas')->where('Id', $Id)->delete();
    
        return redirect()->route('areas.list')->with('msg', 'Área Eliminado Correctamente.');
    }
    
    public function edit($id)
    {
        $areas = Area::find($id);
        return view('areas.edit', compact('areas'));
    }


    public function update(Request $request, $id)
    {
        

        $request->validate([
            'nombre' => 'required|max:25|unique:areas,nombre,' . $id,
        ]);

        DB::update('UPDATE Areas SET  Nombre = ? WHERE Id = ?', [
           
            $request->input('nombre'),
          
            $id // El Id del empleado que deseas actualizar
        ]);
        return view("Areas.menssage", ['msg' => "Área actualizado correctamente."]);
    }
}
