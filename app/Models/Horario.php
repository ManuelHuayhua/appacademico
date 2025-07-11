<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    protected $fillable = [
    'curso_periodo_id', // ✅ Este es el correcto
    'profesor_id',
    'dia_semana',
    'hora_inicio',
    'hora_fin',
];

    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    public function profesor()
{
    return $this->belongsTo(User::class, 'profesor_id');
}

public function periodo()
{
    return $this->belongsTo(Periodo::class);
}

public function cursoPeriodo()
{
    return $this->belongsTo(CursoPeriodo::class);
}
}
