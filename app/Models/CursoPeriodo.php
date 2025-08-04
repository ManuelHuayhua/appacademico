<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CursoPeriodo extends Model
{
   protected $table = 'curso_periodo';
    protected $fillable = [
        'curso_id',
        'periodo_id',
        'seccion',
        'fecha_apertura_matricula',
        'fecha_cierre_matricula',
        'fecha_inicio_clases',
        'fecha_fin_clases',
        'vacantes',
        'turno', 
        'monto_total',
        'url_clase_virtual',
    

    ];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }

    public function asistencias()
{
    return $this->hasMany(Asistencia::class);
}

public function matriculas()
{
    return $this->hasMany(Matricula::class);
}

public function calificaciones()
{
    return $this->hasMany(Calificacion::class);
}

public function profesor()
{
    return $this->belongsTo(User::class, 'profesor_id');
}
}
