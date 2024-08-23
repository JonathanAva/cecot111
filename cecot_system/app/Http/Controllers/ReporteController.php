<?php

namespace App\Http\Controllers;

use App\Models\Reporte;
use App\Models\User;
use App\Models\Preso;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    // Mostrar todos los reportes
    public function index()
    {
        $reportes = Reporte::with('usuario', 'preso')->get();
        return view('reportes.index', compact('reportes'));
    }

    // Mostrar el formulario para crear un nuevo reporte
    public function create()
    {
        $usuarios = User::all();
        $presos = Preso::all();
        return view('reportes.create', compact('usuarios', 'presos'));
    }

    // Almacenar un nuevo reporte
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'id_preso' => 'required|exists:presos,id_preso',
            'tipo_reporte' => 'required|string|max:255',
            'fecha_reporte' => 'required|date',
            'hora_reporte' => 'required|date_format:H:i', // Cambia aquí
            'descripcion' => 'required|string|max:1000',
        ]);
        
            

        Reporte::create($request->all());
        return redirect()->route('reportes.index')->with('success', 'Reporte creado exitosamente.');
    }


    public function edit($id)
    {
        $reporte = Reporte::findOrFail($id);
        $usuarios = User::all();
        $presos = Preso::all();
        return view('reportes.edit', compact('reporte', 'usuarios', 'presos'));
    }


    public function print($id)
    {
        $reporte = Reporte::with('usuario', 'preso')->findOrFail($id);
        return view('reportes.print', compact('reporte'));
    }
    
        
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'id_preso' => 'required|exists:presos,id_preso',
            'tipo_reporte' => 'required|string|max:255',
            'fecha_reporte' => 'required|date',
            'hora_reporte' => 'required|date_format:H:i',
            'descripcion' => 'required|string',
        ]);
    
        $reporte = Reporte::findOrFail($id);
        $reporte->update($validatedData);
    
        return redirect()->route('reportes.index')->with('success', 'Reporte actualizado correctamente.');
    }
    
    // Eliminar un reporte
    public function destroy($id)
    {
        $reporte = Reporte::findOrFail($id);
        $reporte->delete();
        return redirect()->route('reportes.index')->with('success', 'Reporte eliminado exitosamente.');
    }
}
