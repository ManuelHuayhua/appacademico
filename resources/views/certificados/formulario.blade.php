<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Certificado</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Opcional: Google Fonts para una tipografía más elegante -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Roboto:wght@400;500&display=swap" rel="stylesheet"> -->
    <!-- O para un estilo de certificado más clásico: -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"> -->

    <style>
        /* Definición de variables CSS para colores */
        :root {
            --certificate-blue-start: #0249BB;
            --certificate-blue-end: #003bb1;
            --certificate-gold-light: #FFD700; /* Oro brillante */
            --certificate-gold-medium: #DAA520; /* Oro medio */
            --certificate-gold-dark: #B8860B; /* Oro oscuro para sombras */
            --certificate-bg-pattern-color: #f0f0f0; /* Gris muy claro para el patrón de fondo */
            --certificate-text-color: #333333;
        }

        body {
            background-color: #e0e5ec; /* Fondo general más suave */
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            font-family: 'Roboto', sans-serif; /* Fuente moderna y legible */
            color: var(--certificate-text-color);
        }

        .certificate-frame {
            position: relative;
            background-color: #ffffff;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.35); /* Sombra más profunda */
            border-radius: 20px; /* Bordes más redondeados */
            overflow: hidden;
            width: 100%;
            max-width: 1100px; /* Ancho máximo ligeramente mayor */
            aspect-ratio: 3 / 2;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 0;

            /* Patrón sutil de fondo más visible */
            background-image: repeating-linear-gradient(
                45deg,
                var(--certificate-bg-pattern-color) 0,
                var(--certificate-bg-pattern-color) 2px,
                transparent 2px,
                transparent 15px
            );
            background-size: 15px 15px;
        }

        /* Contenedor para las decoraciones diagonales */
        .certificate-decoration-layer {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        /* Franjas superiores (azul y oro) */
        .certificate-decoration-layer::before {
            content: '';
            position: absolute;
            top: -20%; /* Ajuste para que la franja empiece más arriba */
            left: -20%; /* Ajuste para que la franja empiece más a la izquierda */
            width: 100%;
            height: 100%;
            transform: rotate(15deg); /* Ángulo de las franjas */
            transform-origin: top left;
            background:
                /* Capa de sombra/borde dorado oscuro */
                linear-gradient(to right, transparent 0%, transparent 10%, var(--certificate-gold-dark) 10%, var(--certificate-gold-dark) 12%, transparent 12%, transparent 100%),
                /* Capa principal azul */
                linear-gradient(to right, transparent 0%, transparent 12%, var(--certificate-blue-start) 12%, var(--certificate-blue-end) 30%, transparent 30%, transparent 100%),
                /* Capa de borde dorado claro */
                linear-gradient(to right, transparent 0%, transparent 30%, var(--certificate-gold-light) 30%, var(--certificate-gold-light) 32%, transparent 32%, transparent 100%);
            background-size: 100% 100%;
            background-repeat: no-repeat;
            filter: drop-shadow(5px 5px 10px rgba(0, 0, 0, 0.2)); /* Sombra para la franja */
        }

        /* Franjas inferiores (azul y oro, espejadas) */
        .certificate-decoration-layer::after {
            content: '';
            position: absolute;
            bottom: -20%; /* Ajuste para que la franja empiece más abajo */
            right: -20%; /* Ajuste para que la franja empiece más a la derecha */
            width: 100%;
            height: 100%;
            transform: rotate(195deg); /* Ángulo espejado (15 + 180) */
            transform-origin: bottom right;
            background:
                /* Capa de sombra/borde dorado oscuro */
                linear-gradient(to right, transparent 0%, transparent 10%, var(--certificate-gold-dark) 10%, var(--certificate-gold-dark) 12%, transparent 12%, transparent 100%),
                /* Capa principal azul */
                linear-gradient(to right, transparent 0%, transparent 12%, var(--certificate-blue-start) 12%, var(--certificate-blue-end) 30%, transparent 30%, transparent 100%),
                /* Capa de borde dorado claro */
                linear-gradient(to right, transparent 0%, transparent 30%, var(--certificate-gold-light) 30%, var(--certificate-gold-light) 32%, transparent 32%, transparent 100%);
            background-size: 100% 100%;
            background-repeat: no-repeat;
            filter: drop-shadow(-5px -5px 10px rgba(0, 0, 0, 0.2)); /* Sombra para la franja */
        }

        /* Sello de premio (Font Awesome con fondo circular y capas) */
        .award-badge {
            position: absolute;
            top: 8%; /* Posición ajustada */
            left: 8%; /* Posición ajustada */
            width: 130px; /* Tamaño del badge */
            height: 130px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, var(--certificate-gold-light) 0%, var(--certificate-gold-medium) 50%, var(--certificate-gold-dark) 100%); /* Degradado dorado con punto de luz */
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4), inset 0 0 15px rgba(255, 255, 255, 0.5); /* Sombra y brillo interno */
            z-index: 10;
            border: 4px solid rgba(255, 255, 255, 0.7); /* Borde blanco más pronunciado */
            transition: transform 0.3s ease-in-out;
        }
        .award-badge:hover {
            transform: scale(1.05) rotate(5deg); /* Pequeña animación al pasar el ratón */
        }
        .award-icon {
            font-size: 65px; /* Tamaño del icono */
            color: white;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6); /* Sombra más fuerte para el icono */
        }

        /* Contenedor del formulario */
        .form-container-wrapper {
            position: relative;
            z-index: 5;
            background-color: rgba(255, 255, 255, 0.95); /* Fondo casi opaco para el formulario */
            backdrop-filter: blur(5px); /* Desenfoque más fuerte */
            padding: 50px; /* Más padding */
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            max-width: 500px; /* Ancho máximo ligeramente mayor */
            width: 100%;
            text-align: center;
        }

        h3 {
            /* font-family: 'Playfair Display', serif; */ /* Descomentar si usas Google Fonts */
            color: var(--certificate-text-color);
            font-weight: 700;
            margin-bottom: 2rem;
            font-size: 2.5rem; /* Título más grande */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Estilos para el mensaje de error de Bootstrap */
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
            padding: 1rem;
            border-radius: 0.25rem;
            margin-bottom: 1.5rem; /* Más espacio */
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
        }
        .alert-danger .fa-exclamation-triangle {
            color: #dc3545;
            font-size: 1.2rem;
        }

        /* Ajustes para los elementos del formulario de Bootstrap */
        .form-label {
            /* font-family: 'Open Sans', sans-serif; */ /* Descomentar si usas Google Fonts */
            font-weight: 600;
            color: var(--certificate-text-color);
            text-align: left;
            display: block;
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
        }
        .form-control-lg {
            padding: 1rem 1.5rem; /* Más padding */
            font-size: 1.2rem; /* Fuente más grande */
            border-radius: 0.75rem; /* Bordes más redondeados */
            border: 2px solid #ced4da; /* Borde más grueso */
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.08);
            transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
        }
        .form-control-lg:focus {
            border-color: var(--certificate-blue-start);
            box-shadow: 0 0 0 0.3rem rgba(2, 73, 187, 0.35), inset 0 2px 4px rgba(0, 0, 0, 0.1);
            outline: none;
        }
        .btn-primary {
            background-image: linear-gradient(120deg, var(--certificate-blue-start) 0%, var(--certificate-blue-end) 100%);
            border: none;
            font-weight: 700; /* Más negrita */
            padding: 1rem 2rem; /* Más padding */
            font-size: 1.2rem; /* Fuente más grande */
            border-radius: 0.75rem; /* Bordes más redondeados */
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out, background-image 0.3s ease-in-out;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        .btn-primary:hover {
            transform: translateY(-3px); /* Se levanta más */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3); /* Sombra más grande */
            background-image: linear-gradient(120deg, var(--certificate-blue-end) 0%, var(--certificate-blue-start) 100%); /* Invertir degradado al hover */
        }
        .btn-primary:active {
            transform: translateY(0);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        /* Responsividad */
        @media (max-width: 992px) {
            .certificate-frame {
                max-width: 900px;
            }
            .award-badge {
                width: 110px;
                height: 110px;
                font-size: 55px;
            }
            .award-icon {
                font-size: 55px;
            }
            .form-container-wrapper {
                padding: 40px;
            }
            h3 {
                font-size: 2.2rem;
            }
        }

        @media (max-width: 768px) {
            .certificate-frame {
                border-radius: 15px;
                aspect-ratio: 4 / 3;
                padding: 15px;
            }
            .award-badge {
                width: 90px;
                height: 90px;
                top: 5%;
                left: 5%;
            }
            .award-icon {
                font-size: 45px;
            }
            .form-container-wrapper {
                padding: 30px;
            }
            h3 {
                font-size: 2rem;
            }
            .form-label {
                font-size: 1rem;
            }
            .form-control-lg {
                font-size: 1.1rem;
                padding: 0.8rem 1.2rem;
            }
            .btn-primary {
                font-size: 1.1rem;
                padding: 0.8rem 1.8rem;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 10px;
            }
            .certificate-frame {
                border-radius: 10px;
                aspect-ratio: 1 / 1.2; /* Más vertical en móviles muy pequeños */
                padding: 10px;
            }
            .award-badge {
                width: 70px;
                height: 70px;
                top: 3%;
                left: 3%;
            }
            .award-icon {
                font-size: 35px;
            }
            .form-container-wrapper {
                padding: 25px;
            }
            h3 {
                font-size: 1.8rem;
            }
            .form-label {
                font-size: 0.95rem;
            }
            .form-control-lg {
                font-size: 1rem;
                padding: 0.7rem 1rem;
            }
            .btn-primary {
                font-size: 1rem;
                padding: 0.7rem 1.5rem;
            }
            /* Ajuste de las franjas para móviles */
            .certificate-decoration-layer::before,
            .certificate-decoration-layer::after {
                width: 120%;
                height: 120%;
                top: -10%;
                left: -10%;
                transform: rotate(25deg); /* Ángulo más pronunciado para móviles */
            }
            .certificate-decoration-layer::after {
                transform: rotate(205deg); /* Ángulo espejado */
                bottom: -10%;
                right: -10%;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-frame">
        <!-- Capa para las decoraciones CSS -->
        <div class="certificate-decoration-layer"></div>

        <!-- Sello de premio (Font Awesome con fondo circular y capas) -->
        <div class="award-badge">
            <i class="fas fa-award award-icon"></i>
        </div>

        <!-- Contenedor del formulario -->
        <div class="form-container-wrapper">
            <!-- Mensaje de error de Laravel Blade -->
            @if(session('error'))
                <div class="alert alert-danger d-flex align-items-center" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> <!-- Icono de Font Awesome -->
                    <div>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <h3 class="mb-4">Verificar Certificado</h3>
            <form method="POST" action="{{ route('certificados.buscar') }}">
                @csrf
                <div class="mb-3">
                    <label for="codigo" class="form-label">Código del Certificado:</label>
                    <input type="text" name="codigo" id="codigo" class="form-control form-control-lg" required>
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100 mt-3">Ver Certificado</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS (opcional, solo si necesitas funcionalidades JS de Bootstrap) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
