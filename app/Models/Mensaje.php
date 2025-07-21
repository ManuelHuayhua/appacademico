<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensaje extends Model
{
    protected $fillable = [
        'remitente_id',
        'destinatario_id',
        'curso_periodo_id',
        'titulo',
        'contenido',
        'fecha_inicio',
        'fecha_fin',
        'leido',
    ];

    public function remitente() {
        return $this->belongsTo(User::class, 'remitente_id');
    }

    public function destinatario() {
        return $this->belongsTo(User::class, 'destinatario_id');
    }

    public function curso() {
        return $this->belongsTo(CursoPeriodo::class, 'curso_periodo_id');
    }
    public function cursoPeriodo()
{
    return $this->belongsTo(CursoPeriodo::class);
}
}
