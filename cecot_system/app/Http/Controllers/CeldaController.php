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
        $celdas = Celda::with('presos')->get();
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
    public function retirarPreso($celdaId, $presoId)
    {
        // Verifica que el preso esté asignado a la celda usando la columna id_celda
        $presoEnCelda = Preso::where('id_preso', $presoId)
                            ->where('id_celda', $celdaId)
                            ->first();
    
        if (!$presoEnCelda) {
            return response()->json(['error' => 'El preso no está asignado a esta celda.'], 400);
        }
    
        // Mueve el preso a la celda inactiva (id = 17)
        $presoEnCelda->id_celda = 17;
        $presoEnCelda->save();
    
        // Decrementa el número de presos en la celda original solo si es mayor que 0
        $celda = Celda::find($celdaId);
        if ($celda->numeroDePresos > 0) {
            $celda->decrement('numeroDePresos');
        }
    
        return response()->json(['success' => 'Preso movido a la celda inactiva.']);
    }
    
    public function asignarNuevaCelda(Request $request, $presoId)
    {
        // Encuentra al preso por ID
        $preso = Preso::findOrFail($presoId);
    
        // Obtén la nueva celda desde la solicitud
        $nuevaCeldaId = $request->input('id_celda');
    
        // Si el preso ya tiene una celda asignada, decrementa el número de presos en esa celda
        if ($preso->id_celda) {
            $celdaAnterior = Celda::find($preso->id_celda);
            if ($celdaAnterior->numeroDePresos > 0) {
                $celdaAnterior->decrement('numeroDePresos');
            }
        }
    
        // Asigna la nueva celda al preso
        $preso->id_celda = $nuevaCeldaId;
        $preso->save();
    
        // Incrementa el número de presos en la nueva celda
        $nuevaCelda = Celda::find($nuevaCeldaId);
        $nuevaCelda->increment('numeroDePresos');
    
        return response()->json(['success' => 'Preso asignado a la nueva celda.']);
    }
    
    

}
