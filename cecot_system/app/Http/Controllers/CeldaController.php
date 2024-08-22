<?php

namespace App\Http\Controllers;

use App\Models\Celda;
use App\Models\Preso;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


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
        // Busca la celda por su ID
        $celda = Celda::findOrFail($id);
    
        // Valida los datos recibidos
        $validatedData = $request->validate([
            'numeroCelda' => [
                'required',
                'integer',
                Rule::unique('celdas')->ignore($id, 'id_celda') // Ignora la celda actual al validar la unicidad
            ],
            'estado' => 'required|boolean',
            'capacidad' => 'required|integer',
        ]);
    
        // Actualiza la celda con los datos validados
        $celda->update($validatedData);
    
        // Retorna la celda actualizada como respuesta JSON
        return response()->json($celda);
    }
    
    public function destroy($id)
    {
        $celda = Celda::findOrFail($id);

        // Verificar si hay presos asignados a la celda
        $presosAsignados = Preso::where('id_celda', $celda->id_celda)->count();

        if ($presosAsignados > 0) {
            // Si hay presos asignados, retornar un mensaje de error
            return response()->json(['error' => 'No se puede eliminar la celda porque tiene presos asignados.'], 400);
        }

        // Si no hay presos asignados, proceder con la eliminación
        $celda->delete();

        return response()->json(['success' => 'Celda eliminada con éxito.']);
    }
        
    public function getPresosByCelda($id)
    {
        $presos = Preso::where('id_celda', $id)->get();
        return response()->json($presos);
    }

}
