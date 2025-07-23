<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalificacionProfesor extends Model
{
    protected $table = 'calificaciones_profesor';
  protected $fillable = [
    'calificacion_id',
    'profesor_id', // <- agregado
    'pregunta_1',
    'pregunta_2',
    'pregunta_3',
    'pregunta_4',
    'pregunta_5',
    'comentario'
];
}
