<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
    'name',
    'apellido_p',
    'apellido_m',
    'fecha_nacimiento',
    'genero',
    'telefono',
    'dni',
    'email',
    'password',
    'usuario',
    'admin',
    'profesor',
    'estado',
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'   => 'hashed',

        // que realmente se interpreten como bool
        'usuario'  => 'boolean',
        'admin'    => 'boolean',
        'profesor' => 'boolean',
    ];

    // Usaremos DNI para identificar al usuario
    public function username() { return 'dni'; }
    


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function defaultRoute(): string
{
    if ($this->admin)    return route('admin.dashboard');
    if ($this->profesor) return route('profesor.dashboard');
    return route('home');                 // alumno
}


public function matriculas()
{
    return $this->hasMany(Matricula::class, 'user_id');
}

public function calificaciones()
{
    return $this->hasMany(Calificacion::class);
}

public function asistencias()
{
    return $this->hasMany(Asistencia::class);
}

public function cursoPeriodo()
{
    return $this->belongsTo(CursoPeriodo::class);
}



}
