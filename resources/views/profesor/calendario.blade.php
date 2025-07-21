<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario del Profesor</title>

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f2f5;
            padding: 20px;
        }

        h2 {
            text-align: center;
        }

        #calendario {
            max-width: 1100px;
            margin: 30px auto;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <h2>🗓️ Calendario de clases del profesor</h2>
    <div id="calendario"></div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendario');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                locale: 'es',
                allDaySlot: false,
                slotMinTime: '07:00:00',
                slotMaxTime: '22:00:00',
                firstDay: 1, // lunes
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: ''
                },
                events: @json($eventos)
            });

            calendar.render();
        });
    </script>

</body>
</html>
