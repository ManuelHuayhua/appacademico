<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
            'Nombre completo',
            'DNI',
            'Email',
            'Rol(es)',
            'Fecha de nacimiento',
            'Género',
            'Teléfono',
        ];
    }

    public function map($user): array
    {
        $roles = [];
        if ($user->admin) $roles[] = 'Admin';
        if ($user->profesor) $roles[] = 'Profesor';
        if ($user->usuario) $roles[] = 'Alumno';

        return [
            $user->name . ' ' . $user->apellido_p . ' ' . $user->apellido_m,
            $user->dni,
            $user->email,
            implode(', ', $roles),
            $user->fecha_nacimiento,
            $user->genero,
            $user->telefono,
        ];
    }
}
