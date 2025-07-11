
<!-- Mostrar mensaje de éxito -->
@if (session('success'))
    <div style="color: green; font-weight: bold;">
        {{ session('success') }}
    </div>
@endif

<!-- Mostrar errores de validación -->
@if ($errors->any())
    <div style="color: red;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form action="{{ route('admin.usuarios.store') }}" method="POST">
    @csrf

    <label>Nombre:</label>
    <input type="text" name="name" required>

    <label>Apellido paterno:</label>
    <input type="text" name="apellido_p" required>

    <label>Apellido materno:</label>
    <input type="text" name="apellido_m" required>

    <label>DNI:</label>
    <input type="text" name="dni" required>

    <label>Email:</label>
    <input type="email" name="email">

    <label>Fecha de nacimiento:</label>
    <input type="date" name="fecha_nacimiento">

    <label>Género:</label>
    <select name="genero">
        <option value="masculino">Masculino</option>
        <option value="femenino">Femenino</option>
        <option value="otro">Otro</option>
    </select>

    <label>Teléfono:</label>
    <input type="text" name="telefono">

    <label>Tipo de usuario:</label><br>
    <input type="checkbox" name="admin"> Admin<br>
    <input type="checkbox" name="profesor"> Profesor<br>
    <input type="checkbox" name="usuario"> Alumno<br>

    <button type="submit">Crear usuario</button>
</form>
