<?php

namespace App\Http\Controllers;

use App\Models\Preso;
use App\Models\Delito;
use Illuminate\Http\Request;
use App\Models\PresoDelito;

class PresoDelitoController extends Controller
{
    // Método para mostrar el formulario de creación (si lo necesitas)
    public function index()
    {
        // Obtener todos los presos y delitos para el formulario
        $presos = Preso::all();
        $delitos = Delito::all();
        return view('preso_delito.index', compact('presos', 'delitos'));
    }

    // Método para almacenar la relación preso-delito
    public function store(Request $request)
    {
        // Validar la entrada
        $validatedData = $request->validate([
            'id_preso' => 'required|exists:presos,id_preso',
            'id_delito' => 'required|exists:delitos,id_delito',
        ]);

        // Crear la relación preso-delito
        PresoDelito::create($validatedData);

        // Retornar respuesta JSON para manejar con AJAX
        return response()->json(['success' => 'Delito asignado al preso exitosamente.']);
    }

    // Método para eliminar la relación preso-delito
    public function destroy($id)
    {
        // Eliminar la relación preso-delito
        $presoDelito = PresoDelito::findOrFail($id);
        $presoDelito->delete();

        // Retornar respuesta JSON para manejar con AJAX
        return response()->json(['success' => 'Relación preso-delito eliminada exitosamente.']);
    }
}
