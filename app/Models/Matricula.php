<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Matricula extends Model
{
    use HasFactory;

    protected $table = 'matriculas';

    protected $fillable = [
        'user_id',
        'curso_periodo_id',
        'fecha_matricula',
        'estado',
    ];

    // Relaciones
 public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function alumno()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function cursoPeriodo()
    {
        return $this->belongsTo(CursoPeriodo::class);
    }
}
