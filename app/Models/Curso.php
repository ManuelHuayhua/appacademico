<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
     protected $fillable = ['nombre', 'descripcion', 'carrera_id', 'silabus_url'];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

  
    public function periodo()
{
    return $this->belongsTo(Periodo::class);
}

public function cursoPeriodos()
{
    return $this->hasMany(CursoPeriodo::class);
}
}
