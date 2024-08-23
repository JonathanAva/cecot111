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

        return response()->json($celda); 
    }

    public function edit($id)
    {
        
        $celda = Celda::findOrFail($id);

       
        return response()->json($celda);
    }

    public function update(Request $request, $id)
    {
       
        $celda = Celda::findOrFail($id);
    
       
        $validatedData = $request->validate([
            'numeroCelda' => [
                'required',
                'integer',
                Rule::unique('celdas')->ignore($id, 'id_celda') 
            ],
            'estado' => 'required|boolean',
            'capacidad' => 'required|integer',
        ]);
    
       
        $celda->update($validatedData);
    
        
        return response()->json($celda);
    }
    
    public function destroy($id)
    {
        $celda = Celda::findOrFail($id);

        
        $presosAsignados = Preso::where('id_celda', $celda->id_celda)->count();

        if ($presosAsignados > 0) {
           
            return response()->json(['error' => 'No se puede eliminar la celda porque tiene presos asignados.'], 400);
        }

      
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
       
        $presoEnCelda = Preso::where('id_preso', $presoId)
                            ->where('id_celda', $celdaId)
                            ->first();
    
        if (!$presoEnCelda) {
            return response()->json(['error' => 'El preso no está asignado a esta celda.'], 400);
        }
    
        
        $presoEnCelda->id_celda = 18;
        $presoEnCelda->save();
    
       
        $celda = Celda::find($celdaId);
        if ($celda->numeroDePresos > 0) {
            $celda->decrement('numeroDePresos');
        }
    
        return response()->json(['success' => 'Preso movido a la celda inactiva.']);
    }
    
    public function asignarNuevaCelda(Request $request, $presoId)
    {
       
        $preso = Preso::findOrFail($presoId);
    
        
        $nuevaCeldaId = $request->input('id_celda');
    
        
        if ($preso->id_celda) {
            $celdaAnterior = Celda::find($preso->id_celda);
            if ($celdaAnterior->numeroDePresos > 0) {
                $celdaAnterior->decrement('numeroDePresos');
            }
        }
    
       
        $preso->id_celda = $nuevaCeldaId;
        $preso->save();
    
       
        $nuevaCelda = Celda::find($nuevaCeldaId);
        $nuevaCelda->increment('numeroDePresos');
    
        return response()->json(['success' => 'Preso asignado a la nueva celda.']);
    }
    
    

}
