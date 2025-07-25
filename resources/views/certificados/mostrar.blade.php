<p><strong>Nombre del Alumno:</strong> {{ $calificacion->alumno->name }} {{ $calificacion->alumno->apellido_p }} {{ $calificacion->alumno->apellido_m }}</p>
<p><strong>DNI:</strong> {{ $calificacion->alumno->dni }}</p>

<p><strong>Curso:</strong> {{ optional($calificacion->cursoPeriodo->curso)->nombre }}</p>
<p><strong>Periodo:</strong> {{ optional($calificacion->cursoPeriodo->periodo)->nombre }}</p>

<p><strong>Carrera:</strong> {{ optional($calificacion->cursoPeriodo->curso->carrera)->nombre }}</p>
<p><strong>Facultad:</strong> {{ optional($calificacion->cursoPeriodo->curso->carrera->facultad)->nombre }}</p>

<p><strong>Promedio Final:</strong> {{ $calificacion->promedio_final }}</p>
<p><strong>Código del certificado:</strong> {{ $calificacion->codigo_certificado }}</p>