<?php

namespace App\Http\Controllers;

use Illuminate\Validation\Rule;
use App\Models\Preso;
use App\Models\Celda;
use Illuminate\Http\Request;

class PresoController extends Controller
{
    // Mostrar todos los presos
    public function index()
    {
        $presos = Preso::with('delitos')->get();
        $presos = Preso::with('celda')->get(); // Trae los presos junto con la información de la celda
        $celdas = Celda::where('estado', true)->get();  // Solo mostrar celdas activas
        return view('presos.index', compact('presos', 'celdas'));
    }

    // Guardar un nuevo preso
    // Guardar un nuevo preso
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

    // Crear el preso con los datos validados
    $preso = Preso::create($validatedData);

    // Incrementar el número de presos en la celda correspondiente
    $celda = Celda::find($preso->id_celda);
    $celda->increment('numeroDePresos');

    return response()->json($preso->load('celda'));
}

public function getDelitos($id)
{
    // Obtén el preso por ID
    $preso = Preso::with('delitos')->find($id);

    if ($preso) {
        // Devuelve los delitos asociados a este preso en formato JSON
        return response()->json(['delitos' => $preso->delitos]);
    } else {
        // Si no se encuentra el preso, devuelve un error
        return response()->json(['error' => 'Preso no encontrado'], 404);
    }
}


// Actualizar un preso existente
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

    // Eliminar un preso
    public function destroy($id)
    {
        $preso = Preso::findOrFail($id);

        // Decrementar el número de presos en la celda correspondiente
        $celda = Celda::find($preso->id_celda);
        $celda->decrement('numeroDePresos');

        // Eliminar el preso
        $preso->delete();

        // Retornar la respuesta de éxito
        return response()->json(['success' => 'Preso eliminado con éxito.']);
    }
    public function edit($id)
    {
        // Busca el preso por su ID, si no lo encuentra lanza un error 404
        $preso = Preso::findOrFail($id);

        // Retorna los datos del preso en formato JSON para ser usados en la vista
        return response()->json($preso);
    }

}
