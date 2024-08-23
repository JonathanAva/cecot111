<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Preso;
use App\Models\Celda;
use Illuminate\Http\Request;

class PresoController extends Controller
{
   
    public function index()
    {
        $presos = Preso::with('delitos')->get();
        $presos = Preso::with('celda')->get(); 
        $celdas = Celda::where('estado', true)->get();  
        return view('presos.index', compact('presos', 'celdas'));
    }

   
public function store(Request $request)
{
    $validatedData = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'fechaNacimiento' => [
            'required',
            'date',
            'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
        ],
        'numeroIdentificacion' => 'required|string|max:255|unique:presos',
        'fechaIngreso' => 'required|date',
        'fechaLiberacion' => 'nullable|date',
        'estado' => 'required|boolean',
        'condena' => 'required|string|max:255',
        'id_celda' => 'required|exists:celdas,id_celda',
    ]);

 
    $preso = Preso::create($validatedData);

   
    $celda = Celda::find($preso->id_celda);
    $celda->increment('numeroDePresos');

    return response()->json($preso->load('celda'));
}

public function getDelitos($id)
{
   
    $preso = Preso::with('delitos')->find($id);

    if ($preso) {
        
        return response()->json(['delitos' => $preso->delitos]);
    } else {
        
        return response()->json(['error' => 'Preso no encontrado'], 404);
    }
}



public function update(Request $request, $id)
{
    $preso = Preso::findOrFail($id);

    $validatedData = $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'fechaNacimiento' => [
            'required',
            'date',
            'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
        ],
        'numeroIdentificacion' => 'required|string|max:255|unique:presos,numeroIdentificacion,' . $preso->id_preso . ',id_preso',
        'fechaIngreso' => 'required|date',
        'fechaLiberacion' => 'nullable|date',
        'estado' => 'required|boolean',
        'condena' => 'required|string|max:255',
        'id_celda' => 'required|exists:celdas,id_celda',
    ]);

    if ($preso->id_celda != $request->id_celda) {
        $oldCelda = Celda::find($preso->id_celda);
        $oldCelda->decrement('numeroDePresos');

        $newCelda = Celda::find($request->id_celda);
        $newCelda->increment('numeroDePresos');
    }

    $preso->update($validatedData);

    return response()->json($preso->load('celda'));
}

   
    public function destroy($id)
    {
        $preso = Preso::findOrFail($id);

        $celda = Celda::find($preso->id_celda);
        $celda->decrement('numeroDePresos');

        
        $preso->delete();

       
        return response()->json(['success' => 'Preso eliminado con éxito.']);
    }
    public function edit($id)
    {
       
        $preso = Preso::findOrFail($id);

       
        return response()->json($preso);
    }

}
