<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calificacion;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificadoController extends Controller
{
  // Vista del formulario para ingresar código
    public function formulario()
    {
        return view('certificados.formulario');
    }

    // Procesar el código ingresado
    public function buscar(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string',
        ]);

        return redirect()->route('certificados.mostrar', ['codigo' => $request->codigo]);
    }

    // Mostrar el certificado si existe
  
public function mostrar($codigo)
{
    $calificacion = Calificacion::with([
        'alumno',
        'cursoPeriodo.curso.carrera.facultad',
        'cursoPeriodo.periodo',
    ])->where('codigo_certificado', $codigo)
      ->where('pago_realizado', true)
      ->first();

    if (!$calificacion) {
        return redirect()
            ->route('certificados.formulario')
            ->with('error', 'El código ingresado no es válido o el certificado aún no está disponible.');
    }

    // URL que el QR debe abrir
    $url = route('certificados.mostrar', ['codigo' => $codigo]);

    // Generar el QR en SVG (sin imagick)
    $qrCode = QrCode::size(150)->generate($url);

    return view('certificados.mostrar', compact('calificacion', 'qrCode'));
}
}
