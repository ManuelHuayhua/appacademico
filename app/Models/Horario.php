<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
     protected $fillable = [
        'curso_id', 'profesor_id',
        'dia_semana', 'hora_inicio', 'hora_fin',
        'periodo_id' // 👈 ESTE FALTABA
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
}
