<?php

namespace App\Http\Controllers;

use App\Models\Preso;
use App\Models\Delito;
use Illuminate\Http\Request;
use App\Models\PresoDelito;

class PresoDelitoController extends Controller
{
    
    public function index()
    {
       
        $presos = Preso::all();
        $delitos = Delito::all();
        return view('preso_delito.index', compact('presos', 'delitos'));
    }

   
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'id_preso' => 'required|exists:presos,id_preso',
            'id_delito' => 'required|exists:delitos,id_delito',
        ]);

    
        PresoDelito::create($validatedData);

      
        return response()->json(['success' => 'Delito asignado al preso exitosamente.']);
    }

   
    public function destroy($id)
    {
        
        $presoDelito = PresoDelito::findOrFail($id);
        $presoDelito->delete();

        
        return response()->json(['success' => 'Relación preso-delito eliminada exitosamente.']);
    }
}
