<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Nombre -->
    <input type="text" name="name" placeholder="Nombre" required>

    <!-- Contraseña -->
    <input type="password" name="password" placeholder="Contraseña" required>

    <!-- Confirmar contraseña -->
    <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>

    <button type="submit">Registrarse</button>

    @if(session('status'))
        <p>{{ session('status') }}</p>
    @endif

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
</form>