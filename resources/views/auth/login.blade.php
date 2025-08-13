<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ACEMPERU - Iniciar Sesión</title>
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Inter', sans-serif;
    background: #f8fafc;
    min-height: 100vh;
    overflow-x: hidden;
}

.login-container {
    min-height: 100vh;
    display: flex;
    align-items: stretch;
    padding: 0;
}

.login-wrapper {
    width: 100%;
    min-height: 100vh;
    display: grid;
    grid-template-columns: 60% 40%;
}

/* Sección de imagen de estudiantes (60%) */
.students-section {
    background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), 
                url('https://cdn.create.vista.com/api/media/medium/190788524/stock-photo-group-multicultural-teenage-high-school-students-sitting-classroom?token=') center/cover;
    position: relative;
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    padding: 2rem;
}

.logo-container {
    position: absolute;
    top: 2rem;
    left: 2rem;
}

.logo-img {
    height: 60px;
    width: auto;
    filter: brightness(0) invert(1);
    transition: all 0.3s ease;
}

.logo-img:hover {
    transform: scale(1.05);
}

/* Sección del formulario (40%) */
.form-section {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
    padding: 3rem 2.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
    color: white;
    position: relative;
    overflow: hidden;
}

.form-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></svg>');
    opacity: 0.3;
}

.form-content {
    max-width: 400px;
    width: 100%;
    position: relative;
    z-index: 2;
}

.welcome-header {
    margin-bottom: 3rem;
    text-align: center;
}

.welcome-text {
    font-size: 2.2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    line-height: 1.2;
    background: linear-gradient(45deg, #ffffff, #e0f2fe);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.brand-name {
    font-size: 2.5rem;
    font-weight: 800;
    color: #fbbf24;
    text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    margin-bottom: 1rem;
    letter-spacing: 1px;
}

.subtitle {
    font-size: 1.2rem;
    font-weight: 400;
    opacity: 0.95;
    margin-bottom: 2rem;
    color: #e0f2fe;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
}

/* Formulario */
.form-floating {
    margin-bottom: 1.5rem;
    position: relative;
}

.form-floating .form-control {
    border: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    padding: 1rem 1rem 1rem 3rem;
    font-size: 1rem;
    background: rgba(255, 255, 255, 0.95);
    height: 58px;
    color: #1f2937;
    transition: all 0.3s ease;
}

.form-floating .form-control:focus {
    background: white;
    box-shadow: 0 0 0 0.2rem rgba(255, 255, 255, 0.25);
    border-color: rgba(255, 255, 255, 0.5);
}

.form-floating .form-control.is-invalid {
    border: 2px solid #ef4444;
}

.form-floating .form-control::placeholder {
    color: #6b7280;
    opacity: 1;
}

.form-floating label {
    display: none;
}

.input-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    color: #3b82f6;
    z-index: 10;
    font-size: 1.1rem;
}

.password-toggle {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #6b7280;
    cursor: pointer;
    z-index: 10;
    font-size: 1.1rem;
    padding: 0.25rem;
    border-radius: 4px;
    transition: all 0.2s ease;
}

.password-toggle:hover {
    color: #3b82f6;
    background: rgba(59, 130, 246, 0.1);
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875rem;
    color: #fecaca;
    background: rgba(239, 68, 68, 0.1);
    padding: 0.5rem;
    border-radius: 8px;
}

/* Selector de rol */
.role-selector {
    margin-bottom: 1.5rem;
}

.role-selector label.form-label {
    color: white;
    font-weight: 500;
    margin-bottom: 1rem;
    font-size: 0.95rem;
}

.role-options {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.role-option {
    flex: 1;
    min-width: 90px;
}

.role-option input[type="radio"] {
    position: absolute;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.role-card {
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 10px;
    padding: 0.75rem 0.5rem;
    text-align: center;
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
    height: 65px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: white;
}

.role-card:hover {
    background: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
    transform: translateY(-2px);
}

.role-option input[type="radio"]:checked + .role-card {
    background: white;
    color: #1e40af;
    border-color: white;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.role-icon {
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}

.role-name {
    font-size: 0.75rem;
    font-weight: 500;
    line-height: 1;
}

.btn-login {
    background: linear-gradient(135deg, #1f2937 0%, #374151 100%);
    border: none;
    border-radius: 12px;
    padding: 1rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: white;
    width: 100%;
    transition: all 0.3s ease;
    height: 56px;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.btn-login:hover {
    background: linear-gradient(135deg, #111827 0%, #1f2937 100%);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
}

.forgot-password {
    text-align: center;
}

.forgot-password a {
    color: #e0f2fe;
    text-decoration: underline;
    font-size: 0.9rem;
    opacity: 0.9;
    transition: all 0.2s ease;
}

.forgot-password a:hover {
    opacity: 1;
    color: white;
}

.alert {
    border-radius: 12px;
    border: none;
    margin-bottom: 1.5rem;
    font-size: 0.9rem;
}

.alert-success {
    background: rgba(34, 197, 94, 0.2);
    color: #dcfce7;
    border: 1px solid rgba(34, 197, 94, 0.3);
}

.alert-danger {
    background: rgba(239, 68, 68, 0.2);
    color: #fecaca;
    border: 1px solid rgba(239, 68, 68, 0.3);
}

/* NUEVO: Media query para pantallas muy pequeñas (menos de 360px) */
@media (max-width: 360px) {
    .form-section {
        padding: 1rem 0.75rem;
        padding-top: 1.5rem;
    }

    .welcome-text {
        font-size: 1.4rem;
    }

    .brand-name {
        font-size: 1.6rem;
    }

    .subtitle {
        font-size: 0.9rem;
    }

    .mobile-logo .logo-img {
        height: 50px;
    }

    .form-floating .form-control {
        padding: 0.75rem 0.75rem 0.75rem 2.5rem; /* PADDING REDUCIDO */
        height: 48px;
    }

    .input-icon {
        left: 0.75rem; /* AJUSTE DE POSICIÓN */
    }

    .password-toggle {
        right: 0.75rem; /* AJUSTE DE POSICIÓN */
    }

    .btn-login {
        height: 48px;
        font-size: 1rem;
    }
}


/* Responsive Design */
/* Responsive Design CORREGIDO */
@media (max-width: 992px) {
    .login-wrapper {
        grid-template-columns: 1fr;
    }

    .students-section {
        display: none;
    }

    .form-section {
        padding: 2rem 1.5rem;
        justify-content: center; /* CENTRADO VERTICAL */
        align-items: center; /* CENTRADO HORIZONTAL */
        min-height: 100vh; /* ALTURA COMPLETA */
    }

    .form-content {
        max-width: 450px; /* ANCHO MÁXIMO MEJORADO */
        width: 100%;
    }

    /* Logo móvil */
    .mobile-logo {
        display: block;
        text-align: center;
        margin-bottom: 2rem; /* REDUCIDO */
    }

    .mobile-logo .logo-img {
        height: 70px; /* TAMAÑO INTERMEDIO */
        width: auto;
        filter: brightness(0) invert(1);
    }

    .welcome-text {
        font-size: 1.9rem; /* TAMAÑO INTERMEDIO */
    }

    .brand-name {
        font-size: 2.3rem; /* TAMAÑO INTERMEDIO */
    }

    .subtitle {
        font-size: 1.1rem;
        margin-bottom: 1.5rem; /* REDUCIDO */
    }

    .welcome-header {
        margin-bottom: 2rem; /* REDUCIDO */
    }
}

/* NUEVO: Media query para tablets (768px - 991px) */
@media (max-width: 991px) and (min-width: 768px) {
    .form-section {
        padding: 3rem 3rem; /* MÁS PADDING EN TABLETS */
    }

    .form-content {
        max-width: 500px; /* ANCHO MAYOR EN TABLETS */
    }

    .mobile-logo .logo-img {
        height: 80px; /* LOGO MÁS GRANDE EN TABLETS */
    }

    .welcome-text {
        font-size: 2rem;
    }

    .brand-name {
        font-size: 2.4rem;
    }
}

/* NUEVO: Media query para móviles grandes (481px - 767px) */
@media (max-width: 767px) and (min-width: 481px) {
    .form-section {
        padding: 2.5rem 2rem;
        justify-content: center;
        align-items: center;
    }

    .form-content {
        max-width: 400px;
    }

    .mobile-logo .logo-img {
        height: 65px;
    }

    .welcome-text {
        font-size: 1.7rem;
    }

    .brand-name {
        font-size: 2rem;
    }

    .subtitle {
        font-size: 1rem;
    }

    /* Roles en una sola columna para móviles medianos */
    .role-options {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .role-option {
        flex: none;
    }

    .role-card {
        height: 55px;
        flex-direction: row;
        justify-content: flex-start;
        padding: 0.75rem 1rem;
        text-align: left;
    }

    .role-icon {
        margin-right: 0.75rem;
        margin-bottom: 0;
    }
}

@media (min-width: 993px) {
    .mobile-logo {
        display: none;
    }
}

@media (min-width: 993px) {
    .mobile-logo {
        display: none;
    }
}

/* MEJORADO: Media query para móviles pequeños */
@media (max-width: 480px) {
    .form-section {
        padding: 1.5rem 1rem;
        justify-content: flex-start; /* CAMBIO A FLEX-START PARA MÓVILES PEQUEÑOS */
        padding-top: 2rem;
    }

    .form-content {
        max-width: 100%;
    }

    .welcome-text {
        font-size: 1.5rem; /* REDUCIDO */
    }

    .brand-name {
        font-size: 1.8rem;
    }

    .subtitle {
        font-size: 0.95rem; /* REDUCIDO */
    }

    .mobile-logo {
        margin-bottom: 1.5rem; /* REDUCIDO */
    }

    .mobile-logo .logo-img {
        height: 55px; /* REDUCIDO */
    }

    .welcome-header {
        margin-bottom: 1.5rem; /* REDUCIDO */
    }

    .role-options {
        flex-direction: column;
        gap: 0.5rem;
    }

    .role-option {
        flex: none;
    }

    .role-card {
        height: 50px;
        flex-direction: row;
        justify-content: flex-start;
        padding: 0.75rem 1rem;
        text-align: left;
    }

    .role-icon {
        margin-right: 0.75rem;
        margin-bottom: 0;
    }

    /* Formulario más compacto en móviles pequeños */
    .form-floating {
        margin-bottom: 1.2rem; /* REDUCIDO */
    }

    .form-floating .form-control {
        height: 52px; /* REDUCIDO */
    }

    .btn-login {
        height: 50px; /* REDUCIDO */
        margin-bottom: 1.2rem; /* REDUCIDO */
    }
}
/* Animaciones */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-floating {
    animation: fadeInUp 0.6s ease-out forwards;
}

.form-floating:nth-child(1) { animation-delay: 0.1s; }
.form-floating:nth-child(2) { animation-delay: 0.2s; }
.role-selector { animation: fadeInUp 0.6s ease-out 0.3s forwards; }
.btn-login { animation: fadeInUp 0.6s ease-out 0.4s forwards; }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-wrapper">
            <!-- Sección de Estudiantes (60%) -->
            <div class="students-section">
                <div class="logo-container">
                    <img src="https://acemperu.edu.pe/wp-content/uploads/2025/06/cropped-LOGO-ACEMPERU-EDITABLE-OK-165x105.png" alt="Logo ACEMPERU" class="logo-img">
                </div>
            </div>

            <!-- Sección del Formulario (40%) -->
            <div class="form-section">
                <!-- Logo móvil -->
                <div class="mobile-logo">
                    <img src="https://acemperu.edu.pe/wp-content/uploads/2025/06/cropped-LOGO-ACEMPERU-EDITABLE-OK-165x105.png" alt="Logo ACEMPERU" class="logo-img">
                </div>

                <div class="form-content">
                    <div class="welcome-header">
                        <div class="welcome-text">¡Hola somos</div>
                        <div class="brand-name">UNAT!</div>
                        <div class="subtitle">¡Que tu día sea excelente!</div>
                    </div>

                    {{-- 🔔 Mensaje de éxito o información --}}
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- 🔔 Mensaje de error genérico --}}
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        {{-- Campo DNI --}}
                        <div class="form-floating">
                            <i class="fas fa-id-card input-icon"></i>
                            <input id="dni" type="text"
                                   class="form-control @error('dni') is-invalid @enderror"
                                   name="dni" value="{{ old('dni') }}"
                                   placeholder="Por favor, ingresa tu número de DNI" required autofocus>
                            <label for="dni">{{ __('Número de DNI') }}</label>
                            @error('dni')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        {{-- Campo Contraseña --}}
                        <div class="form-floating">
                            <i class="fas fa-lock input-icon"></i>
                            <input id="password" type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   name="password" placeholder="Y aquí tu contraseña" required>
                            <button type="button" class="password-toggle" onclick="togglePassword()">
                                <i class="fas fa-eye" id="password-icon"></i>
                            </button>
                            <label for="password">{{ __('Contraseña') }}</label>
                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        {{-- Selector de Rol --}}
                        <div class="role-selector">
                            <label class="form-label">
                                <i class="fas fa-user-tag me-2"></i>Selecciona tu rol
                            </label>
                            <div class="role-options">
                                <div class="role-option">
                                    <input type="radio" name="role" value="usuario" id="role-usuario"
                                           {{ old('role', 'usuario') == 'usuario' ? 'checked' : '' }} required>
                                    <label for="role-usuario" class="role-card">
                                        <i class="fas fa-user role-icon"></i>
                                        <div class="role-name">Usuario</div>
                                    </label>
                                </div>

                                <div class="role-option">
                                    <input type="radio" name="role" value="profesor" id="role-profesor"
                                           {{ old('role') == 'profesor' ? 'checked' : '' }}>
                                    <label for="role-profesor" class="role-card">
                                        <i class="fas fa-chalkboard-teacher role-icon"></i>
                                        <div class="role-name">Profesor</div>
                                    </label>
                                </div>

                                <div class="role-option">
                                    <input type="radio" name="role" value="admin" id="role-admin"
                                           {{ old('role') == 'admin' ? 'checked' : '' }}>
                                    <label for="role-admin" class="role-card">
                                        <i class="fas fa-user-shield role-icon"></i>
                                        <div class="role-name">Admin</div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        {{-- Botón Ingresar --}}
                        <button type="submit" class="btn btn-login">
                            <i class="fas fa-sign-in-alt me-2"></i>
                            Comencemos
                        </button>

                        {{-- Enlace olvidé contraseña --}}
                        <div class="forgot-password">
    <a href="tel:999999999">
        Si olvidó contraseña comuníquese con este número: 999-999-999
    </a>
</div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Animación suave para los elementos del formulario
            const formElements = document.querySelectorAll('.form-floating, .role-selector, .btn-login');
            formElements.forEach((element, index) => {
                element.style.animationDelay = `${0.1 * (index + 1)}s`;
            });

            // Efecto hover mejorado para las tarjetas de rol
            const roleCards = document.querySelectorAll('.role-card');
            roleCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    if (!this.previousElementSibling.checked) {
                        this.style.transform = 'translateY(-2px)';
                    }
                });

                card.addEventListener('mouseleave', function() {
                    if (!this.previousElementSibling.checked) {
                        this.style.transform = 'translateY(0)';
                    }
                });
            });

            // Auto-dismiss alerts después de 5 segundos
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    const bsAlert = new bootstrap.Alert(alert);
                    if (bsAlert) {
                        bsAlert.close();
                    }
                }, 5000);
            });
        });

        // Función para mostrar/ocultar contraseña
        function togglePassword() {
            const passwordField = document.getElementById('password');
            const passwordIcon = document.getElementById('password-icon');
            
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordIcon.classList.remove('fa-eye');
                passwordIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                passwordIcon.classList.remove('fa-eye-slash');
                passwordIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
