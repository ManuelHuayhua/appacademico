<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $fillable = ['nombre', 'facultad_id'];

    public function facultad()
    {
        return $this->belongsTo(Facultad::class);
    }

    public function cursos()
    {
        return $this->hasMany(Curso::class);
    }
}
