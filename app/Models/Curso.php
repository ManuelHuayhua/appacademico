<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
     protected $fillable = ['nombre', 'descripcion', 'carrera_id'];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
    public function periodo()
{
    return $this->belongsTo(Periodo::class);
}
}
