<?php

namespace App\Http\Controllers;

use App\Models\User; // Asegúrate de que estás usando el modelo correcto
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmpleadoController extends Controller
{
    public function index()
    {
        // Obtener todos los empleados, incluyendo tanto admin como usuarios
        $empleados = User::all(); // Elimina la condición de rol
    
        // Pasar los empleados a la vista
        return view('empleados.index', compact('empleados'));
    }
    
    public function create()
    {
        // Muestra el formulario para crear un nuevo empleado
        return view('empleados.create');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre_usuario' => 'required|string|max:255|unique:usuarios',
            'password' => 'required|string|min:6',
            'rol' => 'required|in:admin,usuario',
            'info_contacto' => 'nullable|string',
        ]);

        // Crear el nuevo empleado
        User::create([
            'nombre_usuario' => $request->nombre_usuario,
            'password' => Hash::make($request->password), // Encriptar la contraseña
            'rol' => $request->rol,
            'info_contacto' => $request->info_contacto,
        ]);

        // Redireccionar a la página de índice de empleados con un mensaje de éxito
        return redirect()->route('empleados.index')->with('success', 'Empleado creado exitosamente.');
    }

    public function edit($id)
    {
        // Obtener el empleado por su ID
        $empleado = User::findOrFail($id);

        // Mostrar la vista de edición con los datos del empleado
        return view('empleados.edit', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'nombre_usuario' => 'required|string|max:255|unique:usuarios,nombre_usuario,' . $id . ',id_usuario',
            'password' => 'nullable|string|min:6',
            'rol' => 'required|in:admin,usuario',
            'info_contacto' => 'nullable|string',
        ]);

        // Obtener el empleado por su ID
        $empleado = User::findOrFail($id);

        // Actualizar los datos del empleado
        $empleado->nombre_usuario = $request->nombre_usuario;
        if ($request->filled('password')) {
            $empleado->password = Hash::make($request->password);
        }
        $empleado->rol = $request->rol;
        $empleado->info_contacto = $request->info_contacto;
        $empleado->save();

        // Redireccionar a la página de índice de empleados con un mensaje de éxito
        return redirect()->route('empleados.index')->with('success', 'Empleado actualizado exitosamente.');
    }

    public function destroy($id)
    {
        // Encontrar el empleado por su ID
        $empleado = User::findOrFail($id);

        // Eliminar el empleado
        $empleado->delete();

        // Redireccionar a la página de índice de empleados con un mensaje de éxito
        return redirect()->route('empleados.index')->with('success', 'Empleado eliminado exitosamente.');
    }

}
