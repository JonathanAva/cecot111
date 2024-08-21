<?php

namespace App\Http\Controllers;

use App\Models\Delito;
use App\Models\Preso;
use Illuminate\Http\Request;

class DelitoController extends Controller
{
    public function index()
    {
        $delitos = Delito::all();
        $presos = Preso::all(); // Obtener todos los presos
        return view('delitos.index', compact('delitos', 'presos')); // Pasar la lista de presos a la vista
    }
    

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);
    
        // Crear el delito y devolverlo
        $delito = Delito::create($validatedData);
    
        return response()->json($delito); // Asegúrate de devolver el delito como JSON
    }
    

    public function edit(Delito $delito)
    {
        return response()->json($delito); // Retornar los datos del delito en formato JSON para usar en el frontend
    }

    public function update(Request $request, Delito $delito)
    {
        $validatedData = $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);

        $delito->update($validatedData);
        return redirect()->route('delitos.index')->with('success', 'Delito actualizado exitosamente.');
    }

    public function destroy(Delito $delito)
    {
        $delito->delete();
        
        // Retornar una respuesta JSON en lugar de redirigir
        return response()->json(['message' => 'Delito eliminado exitosamente.']);
    }
    
}
