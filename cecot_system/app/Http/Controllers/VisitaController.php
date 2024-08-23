<?php

namespace App\Http\Controllers;

use App\Models\Visita;
use App\Models\Preso;
use Illuminate\Http\Request;

class VisitaController extends Controller
{
    public function index(Request $request)
    {
        $query = Visita::query();

        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('preso', function ($presoQuery) use ($searchTerm) {
                    $presoQuery->where('nombre', 'like', "%$searchTerm%")
                               ->orWhere('numeroIdentificacion', 'like', "%$searchTerm%");
                })
                ->orWhere('fechaDeVisita', 'like', "%$searchTerm%");
            });
        }

        $visitas = $query->paginate(10);

        return view('visitas.index', compact('visitas'));
    }

    public function create()
    {
        $presos = Preso::all();
        return view('visitas.create', compact('presos'));
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'nombre' => 'required|string|max:255',
            'parentesco' => 'required|string|max:255',
            'fecha_visita' => 'required|date',
            'hora_visita' => 'required|date_format:H:i',
            'dui_preso' => 'required|string|max:10',
            'id_preso' => 'required|exists:presos,id_preso',
        ]);
    
      
        $preso = Preso::where('id_preso', $request->id_preso)
                       ->where('numeroIdentificacion', $request->dui_preso)
                       ->first();
    
        if (!$preso) {
           
            return redirect()->back()->withErrors(['dui_preso' => 'DUI no encontrado o no coincide con el preso seleccionado.'])->withInput();
        }
    
       
        Visita::create([
            'nombreDelVisitante' => $request->nombre,
            'relacionConElPreso' => $request->parentesco,
            'fechaDeVisita' => $request->fecha_visita,
            'horaDeVisita' => $request->hora_visita,
            'id_preso' => $request->id_preso,
        ]);
    
       
        return redirect()->route('visitas.index')->with('success', 'Visita registrada exitosamente.');
    }
    

    public function edit($id)
    {
        $visita = Visita::findOrFail($id);
        $presos = Preso::all();
        return view('visitas.edit', compact('visita', 'presos'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombreDelVisitante' => 'required|string|max:255',
            'relacionConElPreso' => 'required|string|max:255',
            'fechaDeVisita' => 'required|date',
            'horaDeVisita' => 'required|date_format:H:i',
            'id_preso' => 'required|exists:presos,id_preso',
        ]);

        $visita = Visita::findOrFail($id);
        $visita->update($validatedData);

        return redirect()->route('visitas.index')->with('success', 'Visita actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $visita = Visita::findOrFail($id);
        $visita->delete();

        return redirect()->route('visitas.index')->with('success', 'Visita eliminada exitosamente.');
    }
}
