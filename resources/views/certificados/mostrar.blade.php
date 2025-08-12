<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificado de {{ $calificacion->alumno->name }}</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=Inter:wght@300;400;500;600&family=Dancing+Script:wght@400;700&family=Crimson+Text:wght@400;600&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --navy-primary: #0249BB;
            --navy-secondary: #003bb1;
            --navy-dark: #001a3d;
            --gold-primary: #d4af37;
            --gold-light: #f4e4a6;
            --gold-dark: #b8941f;
            --cream-bg: #fefcf8;
            --text-dark: #1a202c;
            --text-medium: #4a5568;
            --text-light: #718096;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .certificate-container {
            position: relative;
            width: 100%;
            max-width: 1300px;
            aspect-ratio: 16/10;
            background: var(--cream-bg);
            box-shadow: 0 25px 50px rgba(2, 73, 187, 0.2);
            overflow: hidden;
            border: 8px solid var(--gold-primary);
            border-image: linear-gradient(45deg, var(--gold-light), var(--gold-primary), var(--gold-dark), var(--gold-primary)) 1;
        }

        /* Borde dorado decorativo interno */
        .certificate-container::before {
            content: '';
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border: 2px solid var(--gold-primary);
            border-image: linear-gradient(45deg, var(--gold-primary), var(--gold-light), var(--gold-primary)) 1;
            z-index: 2;
            pointer-events: none;
        }

        /* Esquinas doradas decorativas */
        .corner-decoration {
            position: absolute;
            width: 80px;
            height: 80px;
            z-index: 3;
        }

        .corner-decoration::before,
        .corner-decoration::after {
            content: '';
            position: absolute;
            background: linear-gradient(45deg, var(--gold-primary), var(--gold-light));
        }

        .corner-top-left {
            top: 25px;
            left: 25px;
        }

        .corner-top-left::before {
            top: 0;
            left: 0;
            width: 30px;
            height: 3px;
        }

        .corner-top-left::after {
            top: 0;
            left: 0;
            width: 3px;
            height: 30px;
        }

        .corner-top-right {
            top: 25px;
            right: 25px;
        }

        .corner-top-right::before {
            top: 0;
            right: 0;
            width: 30px;
            height: 3px;
        }

        .corner-top-right::after {
            top: 0;
            right: 0;
            width: 3px;
            height: 30px;
        }

        .corner-bottom-left {
            bottom: 25px;
            left: 25px;
        }

        .corner-bottom-left::before {
            bottom: 0;
            left: 0;
            width: 30px;
            height: 3px;
        }

        .corner-bottom-left::after {
            bottom: 0;
            left: 0;
            width: 3px;
            height: 30px;
        }

        .corner-bottom-right {
            bottom: 25px;
            right: 25px;
        }

        .corner-bottom-right::before {
            bottom: 0;
            right: 0;
            width: 30px;
            height: 3px;
        }

        .corner-bottom-right::after {
            bottom: 0;
            right: 0;
            width: 3px;
            height: 30px;
        }

        /* Formas geométricas de fondo */
        .bg-shape-right {
            position: absolute;
            top: 0;
            right: 0;
            width: 20%;
            height: 100%;
            background: linear-gradient(120deg, var(--navy-primary) 0%, var(--navy-secondary) 100%);
            clip-path: polygon(0% 0%, 100% 0%, 100% 40%, 10% 0%);
            z-index: 1;
        }

        .bg-shape-left {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 20%;
            height: 55%;
            background: linear-gradient(45deg, var(--navy-secondary) 0%, var(--navy-dark) 100%);
            clip-path: polygon(0% 40%, 100% 100%, 100% 100%, 0% 100%);
            z-index: 1;
        }

        /* Patrones dorados decorativos */
        .gold-pattern-left,
        .gold-pattern-right {
            position: absolute;
            width: 120px;
            height: 120px;
            opacity: 0.1;
            z-index: 2;
        }

        .gold-pattern-left {
            top: 20%;
            left: 5%;
            background: radial-gradient(circle, var(--gold-primary) 1px, transparent 1px);
            background-size: 15px 15px;
        }

        .gold-pattern-right {
            bottom: 20%;
            right: 8%;
            background: conic-gradient(from 0deg, var(--gold-primary), transparent, var(--gold-primary));
            border-radius: 50%;
        }

        /* Botón de descarga */
        .download-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background: linear-gradient(45deg, var(--gold-primary), var(--gold-light));
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 25px;
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            z-index: 10;
            box-shadow: 0 6px 15px rgba(212, 175, 55, 0.4);
            border: 2px solid var(--gold-dark);
        }

        .download-btn:hover {
            background: linear-gradient(45deg, var(--gold-dark), var(--gold-primary));
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(212, 175, 55, 0.5);
        }

        /* Contenido principal */
        .certificate-content {
            position: relative;
            z-index: 5;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 60px 80px 50px;
        }

        /* Sección superior */
        .top-section {
            text-align: center;
            margin-bottom: 20px;
        }

        .university-icon {
            font-size: 2.5rem;
            color: var(--navy-primary);
            margin-bottom: 10px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .university-name {
            font-family: 'Crimson Text', serif;
            font-size: 1.1rem;
            color: var(--text-medium);
            margin-bottom: 30px;
            font-weight: 600;
        }

        .certificate-title {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            font-weight: 900;
            color: var(--navy-primary);
            margin: 0 0 20px 0;
            letter-spacing: 6px;
            text-transform: uppercase;
            text-shadow: 0 3px 6px rgba(0,0,0,0.1);
        }

        /* Línea decorativa mejorada */
        .decorative-line {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
        }

        .line-part {
            width: 100px;
            height: 3px;
            background: linear-gradient(90deg, transparent, var(--gold-primary), transparent);
            position: relative;
        }

        .line-part::before {
            content: '';
            position: absolute;
            top: -2px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 1px;
            background: var(--gold-light);
        }

        .diamond-center {
            width: 12px;
            height: 12px;
            background: linear-gradient(45deg, var(--gold-primary), var(--gold-light));
            transform: rotate(45deg);
            margin: 0 15px;
            border: 1px solid var(--gold-dark);
            position: relative;
        }

        .diamond-center::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            width: 4px;
            height: 4px;
            background: white;
            border-radius: 50%;
        }

        /* Sección central */
        .middle-section {
            text-align: center;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px 0;
        }

        .awarded-text {
            font-family: 'Crimson Text', serif;
            font-size: 1.2rem;
            color: var(--text-medium);
            margin-bottom: 15px;
            font-style: italic;
        }

        .student-name {
            font-family: 'Dancing Script', cursive;
            font-size: 3.5rem;
            color: var(--navy-primary);
            font-weight: 700;
            margin: 0 0 25px 0;
            line-height: 1.1;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            position: relative;
        }

        .student-name::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold-primary), transparent);
        }

        .description-text {
            font-family: 'Crimson Text', serif;
            font-size: 1rem;
            color: var(--text-medium);
            line-height: 1.6;
            max-width: 650px;
            margin: 0 auto;
        }

        .description-text strong {
            color: var(--navy-primary);
            font-weight: 600;
        }

        /* Sección inferior mejorada */
        .bottom-section {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            margin-top: 30px;
            padding-top: 20px;
        }

        .signature-block {
            text-align: center;
            flex: 1;
            padding: 0 20px;
        }

        .signature-name {
            font-family: 'Dancing Script', cursive;
            font-size: 1.5rem;
            color: var(--navy-primary);
            margin-bottom: 5px;
        }

        .signature-line {
            width: 140px;
            height: 2px;
            background: linear-gradient(90deg, var(--gold-dark), var(--gold-primary), var(--gold-dark));
            margin: 0 auto 5px;
            position: relative;
        }

        .signature-line::before {
            content: '';
            position: absolute;
            left: -5px;
            top: -1px;
            width: 6px;
            height: 4px;
            background: var(--gold-primary);
            border-radius: 50%;
        }

        .signature-line::after {
            content: '';
            position: absolute;
            right: -5px;
            top: -1px;
            width: 6px;
            height: 4px;
            background: var(--gold-primary);
            border-radius: 50%;
        }

        .signature-title {
            font-family: 'Inter', sans-serif;
            font-size: 0.8rem;
            color: var(--text-light);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        /* Medallón central mejorado */
        .medal-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0 40px;
            padding: 0 20px;
        }

        .gold-medal {
            width: 80px;
            height: 80px;
            background: radial-gradient(circle at 30% 30%, var(--gold-light) 0%, var(--gold-primary) 70%, var(--gold-dark) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 
                0 8px 25px rgba(212, 175, 55, 0.5),
                inset 0 0 20px rgba(255, 255, 255, 0.3),
                0 0 0 4px var(--gold-primary),
                0 0 0 8px rgba(212, 175, 55, 0.2);
            margin-bottom: 12px;
            position: relative;
        }

        .gold-medal::before {
            content: '';
            position: absolute;
            top: -3px;
            left: -3px;
            right: -3px;
            bottom: -3px;
            border: 2px solid var(--gold-light);
            border-radius: 50%;
            opacity: 0.7;
        }

        .medal-icon {
            font-size: 28px;
            color: white;
            text-shadow: 0 3px 6px rgba(0, 0, 0, 0.4);
        }

        .course-info {
            text-align: center;
        }

        .course-title {
            font-family: 'Crimson Text', serif;
            font-size: 0.95rem;
            color: var(--navy-primary);
            font-weight: 600;
            margin-bottom: 3px;
        }

        .course-subtitle {
            font-family: 'Inter', sans-serif;
            font-size: 0.85rem;
            color: var(--text-medium);
        }

        /* Información de detalles mejorada */
        .details-overlay {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background: linear-gradient(135deg, rgba(254, 252, 248, 0.98), rgba(244, 228, 166, 0.95));
            padding: 12px 14px;
            border-radius: 8px;
            border: 2px solid var(--gold-primary);
            font-size: 0.7rem;
            color: var(--text-medium);
            z-index: 10;
            max-width: 200px;
            box-shadow: 0 4px 12px rgba(212, 175, 55, 0.3);
        }

        .detail-item {
            margin-bottom: 3px;
            display: flex;
            justify-content: space-between;
        }

        .detail-label {
            font-weight: 600;
            color: var(--navy-primary);
        }

        /* Estilos de impresión optimizados */
        @media print {
            @page {
                size: A4 landscape;
                margin: 0.3in;
            }

            .signature-image {
        height: 40px !important;
    }
            
            body {
                background: white !important;
                padding: 0 !important;
                display: block !important;
            }
            
            .certificate-container {
                box-shadow: none !important;
                max-width: none !important;
                width: 100% !important;
                height: 100vh !important;
                aspect-ratio: auto !important;
                page-break-inside: avoid;
                border: 1px solid var(--gold-primary) !important;
            }
            
            .certificate-content {
                padding: 50px 60px 40px !important;
                height: 100vh !important;
            }
            
            .download-btn,
            .details-overlay {
                display: none !important;
            }
            
            .certificate-title {
                font-size: 2.5rem !important;
                letter-spacing: 5px !important;
            }
            
            .student-name {
                font-size: 3rem !important;
            }
            
            .description-text {
                font-size: 0.95rem !important;
            }
            
            * {
                -webkit-print-color-adjust: exact !important;
                color-adjust: exact !important;
            }
        }

        /* Responsive mejorado */
        @media (max-width: 1024px) {
            .certificate-content {
                padding: 50px 60px 40px;
            }
            
            .certificate-title {
                font-size: 3.5rem;
                letter-spacing: 5px;
            }
            
            .student-name {
                font-size: 3rem;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 15px;
            }
            
            .certificate-container {
                aspect-ratio: 3/4;
                border: 4px solid var(--gold-primary);
            }
            
            .certificate-container::before {
                top: 10px;
                left: 10px;
                right: 10px;
                bottom: 10px;
            }
            
            .corner-decoration {
                width: 60px;
                height: 60px;
            }
            
            .corner-top-left,
            .corner-top-right {
                top: 18px;
            }
            
            .corner-top-left {
                left: 18px;
            }
            
            .corner-top-right {
                right: 18px;
            }
            
            .corner-bottom-left,
            .corner-bottom-right {
                bottom: 18px;
            }
            
            .corner-bottom-left {
                left: 18px;
            }
            
            .corner-bottom-right {
                right: 18px;
            }
            
            .corner-decoration::before,
            .corner-decoration::after {
                width: 25px !important;
                height: 2px !important;
            }
            
            .corner-decoration::after {
                width: 2px !important;
                height: 25px !important;
            }
            
            .bg-shape-right {
                width: 20%;
                clip-path: polygon(0% 0%, 100% 0%, 100% 20%, 5% 0%);
            }
            
            .certificate-content {
                padding: 40px 35px 30px;
                justify-content: space-evenly;
            }
            
            .university-icon {
                font-size: 2rem;
                margin-bottom: 8px;
            }
            
            .university-name {
                font-size: 1rem;
                margin-bottom: 20px;
            }
            
            .certificate-title {
                font-size: 2.8rem;
                letter-spacing: 4px;
                margin-bottom: 15px;
            }
            
            .decorative-line {
                margin-bottom: 20px;
            }
            
            .line-part {
                width: 70px;
            }
            
            .diamond-center {
                width: 10px;
                height: 10px;
                margin: 0 10px;
            }
            
            .awarded-text {
                font-size: 1.1rem;
                margin-bottom: 10px;
            }
            
            .student-name {
                font-size: 2.5rem;
                margin-bottom: 20px;
            }
            
            .description-text {
                font-size: 0.9rem;
                line-height: 1.5;
                max-width: 100%;
            }
            
            .bottom-section {
                margin-top: 20px;
                flex-direction: column;
                align-items: center;
                gap: 20px;
            }
            
            .signature-block {
                order: 2;
                display: flex;
                justify-content: space-around;
                width: 100%;
                padding: 0 10px;
            }
            
            .medal-section {
                order: 1;
                margin: 0;
                padding: 0;
            }
            
            .gold-medal {
                width: 65px;
                height: 65px;
                margin-bottom: 8px;
            }
            
            .medal-icon {
                font-size: 24px;
            }
            
            .course-title {
                font-size: 0.9rem;
            }
            
            .course-subtitle {
                font-size: 0.8rem;
            }
            
            .signature-name {
                font-size: 1.3rem;
            }
            
            .signature-line {
                width: 110px;
            }
            
            .signature-title {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 480px) {
            .certificate-container {
                aspect-ratio: 2/3;
                border: 3px solid var(--gold-primary);
            }
            
            .certificate-content {
                padding: 30px 25px 25px;
            }
            
            .university-icon {
                font-size: 1.8rem;
            }
            
            .university-name {
                font-size: 0.9rem;
                margin-bottom: 15px;
            }
            
            .certificate-title {
                font-size: 2.2rem;
                letter-spacing: 3px;
            }
            
            .line-part {
                width: 50px;
            }
            
            .student-name {
                font-size: 2rem;
                margin-bottom: 15px;
            }
            
            .description-text {
                font-size: 0.85rem;
            }
            
            .gold-medal {
                width: 55px;
                height: 55px;
            }
            
            .medal-icon {
                font-size: 20px;
            }
            
            .signature-name {
                font-size: 1.1rem;
            }
            
            .signature-line {
                width: 90px;
            }
            
            .course-title {
                font-size: 0.85rem;
            }
            
            .course-subtitle {
                font-size: 0.75rem;
            }
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <!-- Formas geométricas de fondo -->
        <div class="bg-shape-right"></div>
        <div class="bg-shape-left"></div>
        
        <!-- Patrones dorados decorativos -->
        <div class="gold-pattern-left"></div>
        <div class="gold-pattern-right"></div>
        
        <!-- Esquinas doradas decorativas -->
        <div class="corner-decoration corner-top-left"></div>
        <div class="corner-decoration corner-top-right"></div>
        <div class="corner-decoration corner-bottom-left"></div>
        <div class="corner-decoration corner-bottom-right"></div>
        
        <!-- Botón de descarga -->
        <button class="download-btn" onclick="window.print()">
            <i class="fas fa-download"></i>
            <span>Descargar</span>
        </button>
        
        <!-- Detalles del certificado -->
        <div class="details-overlay">
            <div class="detail-item">
                <span class="detail-label">DNI:</span> 
                <span>{{ $calificacion->alumno->dni }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Código:</span> 
                <span>{{ $calificacion->codigo_certificado }}</span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Promedio:</span> 
                <span>{{ $calificacion->promedio_final }}</span>
            </div>
        </div>
        
        <!-- Contenido principal -->
        <div class="certificate-content">
            <!-- Sección superior -->
            <div class="top-section">
                <div class="university-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3 class="university-name">{{ optional($calificacion->cursoPeriodo->curso->carrera->facultad)->nombre }}</h3>
                
                <h1 class="certificate-title">Certificado</h1>
                
                <div class="decorative-line">
                    <div class="line-part"></div>
                    <div class="diamond-center"></div>
                    <div class="line-part"></div>
                </div>
            </div>
            
            <!-- Sección central -->
            <div class="middle-section">
                <p class="awarded-text">Otorgado a</p>
                
                <h2 class="student-name">
                    {{ $calificacion->alumno->name }} {{ $calificacion->alumno->apellido_p }} {{ $calificacion->alumno->apellido_m }}
                </h2>
                
                <p class="description-text">
                    En reconocimiento a su esfuerzo, dedicación y logro académico, 
                    la Universidad otorga el presente certificado como símbolo 
                    de éxito y superación en el curso de <strong>{{ optional($calificacion->cursoPeriodo->curso)->nombre }}</strong>
                    durante el periodo <strong>{{ optional($calificacion->cursoPeriodo->periodo)->nombre }}</strong>.
                </p>
            </div>
            
    


            <!-- Sección inferior -->

            <style>
                .signature-image {
    max-height: 50px; /* Ajusta la altura según lo necesites */
    display: block;
    margin: 0 auto 5px auto;
}
            </style>
            <div class="bottom-section">
                <div class="signature-block">
                    
        <div>
            <!-- Imagen de la firma -->
            <img src="https://upload.wikimedia.org/wikipedia/commons/9/95/Firma_Burgos_MAzo_sin_fondo.png" alt="Firma" class="signature-image">
            
            <div class="signature-line"></div>
            <p class="signature-title"><strong style="color:black">Directora: Julia Ordóñez</strong></p>
        </div>
    </div>



    <style>
        .qr-corner {
    position: absolute;
    bottom: 80px;
    right: 25px;
    background: rgba(255, 255, 255, 0.9);
    padding: 8px;
    border-radius: 8px;
    border: 2px solid var(--gold-primary);
    z-index: 8;
    text-align: center;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.qr-corner svg {
    width: 60px;
    height: 60px;
    display: block;
}

.qr-corner p {
    font-size: 9px;
    color: var(--text-medium);
    margin: 4px 0 0 0;
    font-weight: 500;
}
    </style>
    <!-- QR en esquina -->
<div class="qr-corner">
    {!! $qrCode !!}
    <p>Verificar</p>
</div>


                <div class="medal-section">
                    <div class="gold-medal">
                        <i class="fas fa-award medal-icon"></i>
                    </div>
                    <div class="course-info">
                        <p class="course-title">{{ optional($calificacion->cursoPeriodo->curso->carrera)->nombre }}</p>
                        <p class="course-subtitle">{{ optional($calificacion->cursoPeriodo->curso)->nombre }}</p>
                    </div>
                </div>
                <div class="signature-block">
    <!-- vacío -->
</div>
        

            
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>