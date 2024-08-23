<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    public function index()
    {
        
        $empleados = User::all(); 
    
       
        return view('empleados.index', compact('empleados'));
    }
    
    public function create()
    {
        
        return view('empleados.create');
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'nombre_usuario' => 'required|string|max:255|unique:usuarios',
            'password' => 'required|string|min:6',
            'rol' => 'required|in:admin,usuario',
            'info_contacto' => 'nullable|string',
        ]);

        
        User::create([
            'nombre_usuario' => $request->nombre_usuario,
            'password' => Hash::make($request->password), 
            'rol' => $request->rol,
            'info_contacto' => $request->info_contacto,
        ]);

        
        return redirect()->route('empleados.index')->with('success', 'Empleado creado exitosamente.');
    }

    public function edit($id)
    {
        
        $empleado = User::findOrFail($id);

       
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
       
        $request->validate([
            'nombre_usuario' => 'required|string|max:255|unique:usuarios,nombre_usuario,' . $id . ',id_usuario',
            'password' => 'nullable|string|min:6',
            'rol' => 'required|in:admin,usuario',
            'info_contacto' => 'nullable|string',
        ]);

       
        $empleado = User::findOrFail($id);

       
        $empleado->nombre_usuario = $request->nombre_usuario;
        if ($request->filled('password')) {
            $empleado->password = Hash::make($request->password);
        }
        $empleado->rol = $request->rol;
        $empleado->info_contacto = $request->info_contacto;
        $empleado->save();

       
        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado exitosamente.');
    }

    public function destroy($id)
    {
        
        $empleado = User::findOrFail($id);

        
        $empleado->delete();

       
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado exitosamente.');
    }

}
