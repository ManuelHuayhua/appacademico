<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periodo;

class PeriodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        $periodos = Periodo::orderBy('fecha_inicio', 'desc')->get();
        return view('admin.periodo', compact('periodos'));
    }

   public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|unique:periodos,nombre',
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
    ]);

    // Validar solapamiento
    $superpuesto = Periodo::where(function ($query) use ($request) {
        $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin])
              ->orWhereBetween('fecha_fin', [$request->fecha_inicio, $request->fecha_fin])
              ->orWhere(function ($query) use ($request) {
                  $query->where('fecha_inicio', '<=', $request->fecha_inicio)
                        ->where('fecha_fin', '>=', $request->fecha_fin);
              });
    })->exists();

    if ($superpuesto) {
        return back()->withErrors(['fecha_inicio' => 'Las fechas se superponen con un periodo existente.'])->withInput();
    }

    Periodo::create($request->all());

    return redirect()->back()->with('success', 'Periodo creado correctamente.');
}

 public function update(Request $request, $id)
{
    $periodo = Periodo::findOrFail($id);

    $request->validate([
        'nombre' => 'required|string|unique:periodos,nombre,' . $periodo->id,
        'fecha_inicio' => 'required|date',
        'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
    ]);

    // Validar solapamiento excluyendo el actual
    $superpuesto = Periodo::where('id', '!=', $periodo->id)
        ->where(function ($query) use ($request) {
            $query->whereBetween('fecha_inicio', [$request->fecha_inicio, $request->fecha_fin])
                  ->orWhereBetween('fecha_fin', [$request->fecha_inicio, $request->fecha_fin])
                  ->orWhere(function ($query) use ($request) {
                      $query->where('fecha_inicio', '<=', $request->fecha_inicio)
                            ->where('fecha_fin', '>=', $request->fecha_fin);
                  });
        })->exists();

    if ($superpuesto) {
        return back()->withErrors(['fecha_inicio' => 'Las fechas se superponen con otro periodo.'])->withInput();
    }

    $periodo->update($request->all());

    return redirect()->back()->with('success', 'Periodo actualizado correctamente.');
}

    public function destroy($id)
    {
        $periodo = Periodo::findOrFail($id);
        $periodo->delete();

        return redirect()->back()->with('success', 'Periodo eliminado correctamente.');
    }
}
