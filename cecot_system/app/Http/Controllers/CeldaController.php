<?php

namespace App\Http\Controllers;

use App\Models\Celda;
use Illuminate\Http\Request;

class CeldaController extends Controller
{
    public function index()
    {
        $celdas = Celda::all();
        return view('celdas.index', compact('celdas'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'numeroCelda' => 'required|integer|unique:celdas,numeroCelda',
            'estado' => 'required|boolean',
            'capacidad' => 'required|integer',
        ]);

        $celda = Celda::create($validatedData);

        return response()->json($celda); // Retorna la celda creada como respuesta JSON
    }

    public function edit($id)
    {
        // Encuentra la celda por su ID
        $celda = Celda::findOrFail($id);

        // Devuelve la celda como JSON
        return response()->json($celda);
    }

    public function update(Request $request, $id)
    {
        $celda = Celda::findOrFail($id);

        $validatedData = $request->validate([
            'numeroCelda' => 'required|integer|unique:celdas,numeroCelda,' . $id,
            'estado' => 'required|boolean',
            'capacidad' => 'required|integer',
        ]);

        $celda->update($validatedData);

        return response()->json($celda); // Retorna la celda actualizada como respuesta JSON
    }

    public function destroy(Celda $celda)
    {
        $celda->delete();
        return response()->json(['message' => 'Celda eliminada correctamente']);
    }
}
