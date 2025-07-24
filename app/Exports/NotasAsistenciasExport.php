<?php

namespace App\Exports;

use App\Models\Matricula;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class NotasAsistenciasExport implements FromView
{
    protected $matriculas;
    protected $fechasClases;

    public function __construct($matriculas, $fechasClases)
    {
        $this->matriculas = $matriculas;
        $this->fechasClases = $fechasClases;
    }

    public function view(): View
    {
        return view('exports.notas_asistencias', [
            'matriculas' => $this->matriculas,
            'fechasClases' => $this->fechasClases,
        ]);
    }
}