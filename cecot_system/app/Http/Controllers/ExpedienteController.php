<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Preso;
use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
    
    public function index(Request $request)
    {
        $expedientes = Expediente::with('preso')->get();

        
        if ($request->has('id_expediente')) {
            $expedientes = Expediente::where('id_expediente', $request->id_expediente)
                            ->with('preso')
                            ->get();
        }

        return view('expedientes.index', compact('expedientes'));
    }

   
    public function create()
    {
        $presos = Preso::all();
        return view('expedientes.create', compact('presos'));
    }

   
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'descripcionDelCaso' => 'required|string|max:1000',
            'estadoDelCaso' => 'required|boolean',
            'id_preso' => 'required|exists:presos,id_preso',
        ]);

        Expediente::create($validatedData);

        return redirect()->route('expedientes.index')->with('success', 'Expediente creado exitosamente.');
    }

    public function show($id)
    {
      
        $expediente = Expediente::findOrFail($id);
        return view('expedientes.show', compact('expediente'));
    }
    

  
    public function edit($id)
    {
        $expediente = Expediente::findOrFail($id);
        $presos = Preso::all();
        return view('expedientes.edit', compact('expediente', 'presos'));
    }

   
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'descripcionDelCaso' => 'required|string|max:1000',
            'estadoDelCaso' => 'required|boolean',
            'id_preso' => 'required|exists:presos,id_preso',
        ]);

        $expediente = Expediente::findOrFail($id);
        $expediente->update($validatedData);

        return redirect()->route('expedientes.index')->with('success', 'Expediente actualizado correctamente.');
    }

    
    public function destroy($id)
    {
        $expediente = Expediente::findOrFail($id);
        $expediente->delete();

        return redirect()->route('expedientes.index')->with('success', 'Expediente eliminado exitosamente.');
    }
}
