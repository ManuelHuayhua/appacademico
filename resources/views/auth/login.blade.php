<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Académico - Iniciar Sesión</title>
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
            background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        .bg-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            z-index: -1;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-wrapper {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            animation: slideUp 0.8s ease-out;
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 600px;
        }

       

        /* Sección de ilustración */
        .illustration-section {
            background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 3rem 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .illustration-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="20" cy="20" r="2" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1.5" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="60" cy="15" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="15" cy="70" r="1.5" fill="rgba(255,255,255,0.1)"/></svg>');
            opacity: 0.3;
        }

        .academic-illustration {
            width: 280px;
            height: 280px;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }

        .welcome-text {
            text-align: center;
            position: relative;
            z-index: 1;
        }

        .welcome-text h2 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .welcome-text p {
            font-size: 1.1rem;
            opacity: 0.9;
            line-height: 1.6;
            font-weight: 300;
        }

        /* Sección del formulario */
        .form-section {
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h3 {
            color: #2d3748;
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #718096;
            font-size: 1rem;
        }

        .form-floating {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-floating .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 1rem 1rem 1rem 3rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            height: 58px;
        }

        .form-floating .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
            background: white;
        }

        .form-floating .form-control.is-invalid {
            border-color: #dc3545;
        }

        .form-floating label {
            padding-left: 3rem;
            color: #718096;
            font-weight: 500;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #003bb1 ;
            z-index: 10;
            font-size: 1.1rem;
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.25rem;
            font-size: 0.875rem;
            color: #dc3545;
        }

        /* Selector de rol optimizado */
        .role-selector {
            margin-bottom: 1.5rem;
        }

        .role-selector label.form-label {
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 0.95rem;
        }

        .role-options {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .role-option {
            flex: 1;
            min-width: 100px;
        }

        .role-option input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .role-card {
            background: white;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            padding: 0.75rem 0.5rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            height: 70px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .role-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.15);
            border-color: #003bb1;
        }

        .role-option input[type="radio"]:checked + .role-card {
            border-color: #003bb1;
            background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
        }

        .role-icon {
            font-size: 1.2rem;
            margin-bottom: 0.25rem;
        }

        .role-name {
            font-size: 0.8rem;
            font-weight: 500;
            line-height: 1;
        }

        .btn-login {
            background: linear-gradient(120deg, #0249BB 0%, #003bb1 100%);
            border: none;
            border-radius: 12px;
            padding: 1rem;
            font-size: 1.1rem;
            font-weight: 600;
            color: white;
            width: 100%;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            height: 56px;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }

        .alert {
            border-radius: 12px;
            border: none;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
        }

        .alert-danger {
            background: linear-gradient(135deg, #f8d7da, #f5c6cb);
            color: #721c24;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .login-wrapper {
                grid-template-columns: 1fr;
                max-width: 450px;
                border-radius: 20px;
            }

            .illustration-section {
                padding: 2rem 1.5rem;
                min-height: 300px;
            }

            .academic-illustration {
                width: 200px;
                height: 200px;
                margin-bottom: 1rem;
            }

            .welcome-text h2 {
                font-size: 1.8rem;
            }

            .welcome-text p {
                font-size: 1rem;
            }

            .form-section {
                padding: 2rem 1.5rem;
            }

            .form-header h3 {
                font-size: 1.5rem;
            }

            .role-options {
                flex-direction: column;
                gap: 0.5rem;
            }

            .role-option {
                flex: none;
            }

            .role-card {
                height: 60px;
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

        @media (max-width: 480px) {
            .login-container {
                padding: 15px;
            }

            .form-section {
                padding: 1.5rem 1rem;
            }

            .illustration-section {
                padding: 1.5rem 1rem;
            }

            .form-floating .form-control {
                padding: 0.9rem 0.9rem 0.9rem 2.8rem;
            }

            .input-icon {
                left: 0.9rem;
            }

            .form-floating label {
                padding-left: 2.8rem;
            }
        }

        /* Animaciones */
       

.form-floating {
    animation: fadeInUp 0.6s ease-out forwards;
    opacity: 0; /* ← Esta línea causa el problema */
}

.form-floating:nth-child(1) { animation-delay: 0.1s; }
.form-floating:nth-child(2) { animation-delay: 0.2s; }
.role-selector { animation: fadeInUp 0.6s ease-out 0.3s forwards; opacity: 0; } /* ← Y esta */
.btn-login { animation: fadeInUp 0.6s ease-out 0.4s forwards; opacity: 0; } /* ← Y esta */

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
       
    </style>
</head>
<body>
    <div class="bg-overlay"></div>
    
    <div class="login-container">
        <div class="login-wrapper">
            <!-- Sección de Ilustración -->
            <div class="illustration-section">
                <div class="academic-illustration">
                    <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                        <!-- Fondo circular -->
                        <circle cx="200" cy="200" r="180" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.2)" stroke-width="2"/>
                        
                        <!-- Estudiante -->
                        <g transform="translate(200,200)">
                            <!-- Cuerpo -->
                            <ellipse cx="0" cy="40" rx="35" ry="50" fill="#4A90E2"/>
                            
                            <!-- Cabeza -->
                            <circle cx="0" cy="-20" r="25" fill="#FFD4A3"/>
                            
                            <!-- Cabello -->
                            <path d="M -20 -35 Q 0 -45 20 -35 Q 15 -25 0 -30 Q -15 -25 -20 -35" fill="#8B4513"/>
                            
                            <!-- Ojos -->
                            <circle cx="-8" cy="-25" r="2" fill="#333"/>
                            <circle cx="8" cy="-25" r="2" fill="#333"/>
                            
                            <!-- Sonrisa -->
                            <path d="M -8 -15 Q 0 -10 8 -15" stroke="#333" stroke-width="2" fill="none"/>
                            
                            <!-- Brazos -->
                            <ellipse cx="-25" cy="20" rx="8" ry="25" fill="#FFD4A3" transform="rotate(-20)"/>
                            <ellipse cx="25" cy="20" rx="8" ry="25" fill="#FFD4A3" transform="rotate(20)"/>
                            
                            <!-- Piernas -->
                            <ellipse cx="-15" cy="75" rx="8" ry="25" fill="#4A90E2"/>
                            <ellipse cx="15" cy="75" rx="8" ry="25" fill="#4A90E2"/>
                            
                            <!-- Certificado en la mano -->
                            <g transform="translate(35,10) rotate(15)">
                                <rect x="0" y="0" width="30" height="40" fill="white" stroke="#FFD700" stroke-width="2" rx="2"/>
                                <line x1="5" y1="8" x2="25" y2="8" stroke="#333" stroke-width="1"/>
                                <line x1="5" y1="15" x2="25" y2="15" stroke="#333" stroke-width="1"/>
                                <line x1="5" y1="22" x2="20" y2="22" stroke="#333" stroke-width="1"/>
                                <circle cx="15" cy="32" r="3" fill="#FFD700"/>
                                <path d="M 12 32 L 15 35 L 18 29" stroke="white" stroke-width="1.5" fill="none"/>
                            </g>
                            
                            <!-- Gorro de graduación -->
                            <g transform="translate(0,-45)">
                                <rect x="-20" y="0" width="40" height="8" fill="#1a1a1a" rx="2"/>
                                <rect x="-25" y="-3" width="50" height="3" fill="#1a1a1a"/>
                                <line x1="20" y1="-1" x2="35" y2="-15" stroke="#FFD700" stroke-width="2"/>
                                <rect x="33" y="-18" width="6" height="6" fill="#FFD700" transform="rotate(45 36 -15)"/>
                            </g>
                        </g>
                        
                        <!-- Elementos decorativos -->
                        <g opacity="0.3">
                            <circle cx="80" cy="100" r="3" fill="white"/>
                            <circle cx="320" cy="150" r="2" fill="white"/>
                            <circle cx="100" cy="300" r="2.5" fill="white"/>
                            <circle cx="300" cy="320" r="2" fill="white"/>
                            <path d="M 60 200 L 70 190 L 80 200 L 70 210 Z" fill="white"/>
                            <path d="M 320 250 L 330 240 L 340 250 L 330 260 Z" fill="white"/>
                        </g>
                    </svg>
                </div>
                
                <div class="welcome-text">
                    <h2>¡Bienvenido!</h2>
                    <p>Accede a tu plataforma educativa y continúa tu camino hacia el éxito académico</p>
                </div>
            </div>
            
            <!-- Sección del Formulario -->
            <div class="form-section">
                <div class="form-header">
                    <h3>Iniciar Sesión</h3>
                    <p>Ingresa tus credenciales para continuar</p>
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
                               placeholder="Ingresa tu DNI" required autofocus>
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
                               name="password" placeholder="Ingresa tu contraseña" required>
                        <label for="password">{{ __('Contraseña') }}</label>
                        @error('password')
                            <div class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </div>
                        @enderror
                    </div>
                    
                    {{-- Selector de Rol Mejorado --}}
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
                        {{ __('Ingresar al Sistema') }}
                    </button>
                </form>
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
                        this.style.transform = 'translateY(-3px)';
                        this.style.boxShadow = '0 6px 20px rgba(102, 126, 234, 0.15)';
                    }
                });
                
                card.addEventListener('mouseleave', function() {
                    if (!this.previousElementSibling.checked) {
                        this.style.transform = 'translateY(0)';
                        this.style.boxShadow = 'none';
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
    </script>
</body>
</html>
