<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Retiro extends Model
{
      protected $table = 'retiros';

    protected $fillable = [
        'user_id',
        'curso_periodo_id',
        'periodo_id',
        'matricula_id',
        'motivo',
        'fecha_retiro',
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cursoPeriodo()
    {
        return $this->belongsTo(CursoPeriodo::class);
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }
}
