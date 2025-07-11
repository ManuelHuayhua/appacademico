<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Periodo extends Model
{
   use HasFactory;

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
    ];

    // Un periodo puede tener muchos horarios
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
