<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $table = 'calificaciones';

    protected $fillable = [
        'user_id',
        'curso_periodo_id',
        'profesor_id',
        'carrera_id',
        'primer_avance',
        'segundo_avance',
        'presentacion_final',
        'promedio_avance',
        'oral_1',
        'oral_2',
        'oral_3',
        'oral_4',
        'oral_5',
        'promedio',
        'promedio_evaluacion_permanente',
        'examen_final',
        'promedio_final',
          'codigo_certificado',
    'pago_realizado',
    'califica_profesor',
        'permiso',
        'monto_pago', 
    ];

    public function alumno()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cursoPeriodo()
    {
        return $this->belongsTo(CursoPeriodo::class, 'curso_periodo_id');
    }

    public function profesor()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }
}
