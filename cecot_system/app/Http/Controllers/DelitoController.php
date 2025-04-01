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
        $presos = Preso::all(); 
        return view('delitos.index', compact('delitos', 'presos'));
    }
    

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'descripcion' => 'required|string|max:255',
        ]);
    
       
        $delito = Delito::create($validatedData);
    
        return response()->json($delito);
    }
    

    public function edit(Delito $delito)
    {
        return response()->json($delito); 
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
        
        return response()->json(['message' => 'Delito eliminado exitosamente.']);
    }

    public function getDelitosData()
{
    $data = Delito::withCount('presos') // Cuenta los presos asociados a cada delito
        ->orderBy('presos_count', 'desc') // Ordena por la cantidad de presos
        ->get(['descripcion', 'presos_count']); // Obtiene solo los campos necesarios

    return response()->json($data);
}
    
}
