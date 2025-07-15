<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'curso_periodo_id',
        'fecha',
        'asistio',
    ];

    // Relaciones
    public function alumno()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function curso()
    {
        return $this->belongsTo(CursoPeriodo::class, 'curso_periodo_id');
    }

    public function asistencias()
{
    return $this->hasMany(Asistencia::class);
}


}
