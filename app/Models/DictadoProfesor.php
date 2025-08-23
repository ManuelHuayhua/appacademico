<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class DictadoProfesor extends Model
{
   use HasFactory;

    protected $table = 'dictado_profesor'; // importante: coincide con tu migration

    protected $fillable = [
        'profesor_id',
        'estado_dictado',
        'fecha_inicio',
        'fecha_fin',
        'fecha_calificacion',
        'hora_calificacion',
    ];

    public function profesor()
    {
        return $this->belongsTo(User::class, 'profesor_id');
    }
}
