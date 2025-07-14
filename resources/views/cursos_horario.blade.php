<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Horario</title>

    <!-- ✅ FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f4f4f4;
        }

        #calendar {
            max-width: 1000px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

    <h2>🗓️ Mi calendario semanal</h2>
    <div id="calendar"></div>

    <!-- ✅ FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                locale: 'es',
                allDaySlot: false,
                slotMinTime: "07:00:00",
                slotMaxTime: "22:00:00",
                slotEventOverlap: false,
                eventOverlap: false,
                height: 'auto',
                nowIndicator: true,
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay'
                },
                events: {!! $eventosJson !!},
                eventClick: function(info) {
                    alert(
                        "📘 Curso: " + info.event.title +
                        "\n👨‍🏫 Profesor: " + info.event.extendedProps.profesor +
                        "\n📆 Fecha: " + info.event.start.toLocaleDateString() +
                        "\n🕐 Hora: " + info.event.start.toLocaleTimeString()
                    );
                }
            });

            calendar.render();
        });
    </script>

</body>
</html>
