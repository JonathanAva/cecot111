<?php

namespace App\Http\Controllers;

use App\Models\Celda;
use Illuminate\Http\Request;

class CeldaController extends Controller
{
    // Mostrar todas las celdas
    public function index()
    {
        $celdas = Celda::all();
        return view('celdas.index', compact('celdas'));
    }

    // Mostrar el formulario para crear una nueva celda
    public function create()
    {
        return view('celdas.create');
    }

    // Guardar una nueva celda
    public function store(Request $request)
    {
        // Validación de los datos ingresados
        $validatedData = $request->validate([
            'numeroCelda' => 'required|integer',
            'estado' => 'required|boolean',
            'capacidad' => 'required|integer',
            'numeroDePresos' => 'nullable|integer',
        ]);

        // Crear la celda con los datos validados
        Celda::create($validatedData);

        // Redirigir a la lista de celdas con un mensaje de éxito
        return redirect()->route('celdas.index')->with('success', 'Celda creada con éxito.');
    }

    // Mostrar el formulario para editar una celda existente
    public function edit(Celda $celda)
    {
        return view('celdas.edit', compact('celda'));
    }

    // Actualizar una celda existente
    public function update(Request $request, Celda $celda)
    {
        // Validación de los datos ingresados
        $validatedData = $request->validate([
            'numeroCelda' => 'required|integer',
            'estado' => 'required|boolean',
            'capacidad' => 'required|integer',
            'numeroDePresos' => 'nullable|integer',
        ]);

        // Actualizar la celda con los datos validados
        $celda->update($validatedData);

        // Redirigir a la lista de celdas con un mensaje de éxito
        return redirect()->route('celdas.index')->with('success', 'Celda actualizada con éxito.');
    }

    // Eliminar una celda
    public function destroy(Celda $celda)
    {
        // Eliminar la celda
        $celda->delete();

        // Redirigir a la lista de celdas con un mensaje de éxito
        return redirect()->route('celdas.index')->with('success', 'Celda eliminada con éxito.');
    }
}
