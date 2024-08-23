<?php

namespace App\Http\Controllers;

use App\Models\Planilla;
use App\Models\User;
use Illuminate\Http\Request;

class PlanillaController extends Controller
{
    

    public function index()
    {
        $planillas = Planilla::all(); 
        
        if (auth()->user()->rol === 'admin') {
            return view('planillas.planillas_admin', compact('planillas'));
        } elseif (auth()->user()->rol === 'usuario') {
            return view('planillas.planillas_user', compact('planillas'));
        } else {
            abort(403, 'No tienes acceso a esta sección.');
        }
    }

   
    public function create()
    {
        if (auth()->user()->rol !== 'admin') {
            return redirect()->route('planillas.index');
        }

      
        $empleados = User::all();

        return view('planillas.create', compact('empleados'));
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario', 
            'turnos_Asignados' => 'required|string|max:255',
            'fechas_turno' => 'required|date',
            'actividades_asignadas' => 'required|string|max:255',
        ]);
    
       
        Planilla::create($validatedData);
    
        return redirect()->route('planillas.index')->with('success', 'Planilla creada exitosamente.');
    }
    

    public function edit($id)
    {
        $planilla = Planilla::findOrFail($id);
        $empleados = User::all();
        
        return view('planillas.edit', compact('planilla', 'empleados')); 
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'turnos_asignados' => 'required|string',
            'fechas_turno' => 'required|date',
            'actividades_asignadas' => 'required|string',
        ]);

        $planilla = Planilla::findOrFail($id);
        $planilla->update($validatedData);

        return redirect()->route('planillas.index')->with('success', 'Planilla actualizada correctamente.');
    }

   
    public function destroy($id)
    {
        if (auth()->user()->rol !== 'admin') {
            return redirect()->route('planillas.index');
        }

        $planilla = Planilla::findOrFail($id);
        $planilla->delete();

        return redirect()->route('planillas.index')->with('success', 'Planilla eliminada correctamente.');
    }
}
