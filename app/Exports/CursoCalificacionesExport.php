<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\CursoPeriodo;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;

class CursoCalificacionesExport implements FromCollection, WithMapping, WithHeadings, WithCustomStartCell
{
    protected $cursoPeriodoId;
    protected $curso;
    protected $periodo;
    protected $seccion;

    public function __construct($cursoPeriodoId)
{
    $cursoPeriodo = CursoPeriodo::with(['curso', 'periodo'])->findOrFail($cursoPeriodoId);

    $this->cursoPeriodoId = $cursoPeriodoId;
    $this->curso = $cursoPeriodo->curso->nombre ?? 'Curso';
    $this->periodo = $cursoPeriodo->periodo->nombre ?? 'Periodo';
    $this->seccion = $cursoPeriodo->seccion ?? 'Sección'; // 👈 campo directo de la tabla
}

    public function collection()
    {
        $cursoPeriodo = CursoPeriodo::with(['curso', 'periodo', 'calificaciones.alumno'])
            ->findOrFail($this->cursoPeriodoId);

        return $cursoPeriodo->calificaciones;
    }

    public function headings(): array
    {
        return [
            ["Curso: {$this->curso}"],
            ["Sección: {$this->seccion}"],
            ["Período: {$this->periodo}"],
            [], // Fila vacía
            ['Alumno', 'DNI', 'Email', 'Teléfono', 'Pagado', 'Deuda', 'Estado'], // Encabezados reales
        ];
    }

    // Para que empiece en A1 (sino duplica encabezados)
    public function startCell(): string
    {
        return 'A1';
    }

    public function map($calificacion): array
    {
        $cursoPeriodo = $calificacion->cursoPeriodo ?? null;
        $alumno = $calificacion->alumno;

        $pagado = $calificacion->monto_pago ?? 0;
        $montoTotal = $cursoPeriodo->monto_total ?? 0;
        $deuda = max(0, $montoTotal - $pagado);
        $estado = ($calificacion->pago_realizado || $deuda <= 0) ? 'Pagado' : 'Pendiente';

        return [
            ($alumno->name ?? '') . ' ' . ($alumno->apellido_p ?? '') . ' ' . ($alumno->apellido_m ?? ''),
            $alumno->dni ?? '',
            $alumno->email ?? '',
            $alumno->telefono ?? '',
            $pagado,
            $deuda,
            $estado,
        ];
    }
}