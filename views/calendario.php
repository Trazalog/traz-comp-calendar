<link href='lib/fullcalendar/core/main.css' rel='stylesheet' />
<link href='lib/fullcalendar/daygrid/main.css' rel='stylesheet' />
<!-- <link href='lib/fullcalendar/timegrid/main.css' rel='stylesheet' /> -->
<link href='lib/fullcalendar/list/main.css' rel='stylesheet' />



<link href='lib/fullcalendar/bootstrap/main.css' rel='stylesheet' />

<div id="calendar"></div>

<script src='lib/fullcalendar/core/main.js'></script>
<script src='lib/fullcalendar/daygrid/main.js'></script>
<script src='lib/fullcalendar/interaction/main.js'></script>
<!-- <script src='fullcalendar/timegrid/main.js'></script> -->
<script src='lib/fullcalendar/list/main.js'></script>
<!-- <script src='fullcalendar/google-calendar/main.js'></script> -->
<script src='lib/fullcalendar/core/locales/es.js'></script>
<script src='lib/fullcalendar/bootstrap/main.js'></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script> -->
<script>
var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: ['interaction', 'dayGrid', 'list', 'bootstrap'],
    header: {
        left: 'prev,next, today',
        center: 'title',
        right: 'dayGridDay,dayGridWeek,dayGridMonth,list'
    },
    locale: 'es',
    themeSystem: 'bootstrap',
    events: getEvents(),
    selectable: true,
    editable: true,
    droppable: true,
    dateClick: function(info) {
        clickCalendario(info);
    }
});

function getEvents() {
   var eventos = [];

   $.ajax({
      async: false,
      type: 'GET',
      dataType: 'JSON',
      url: '<?php echo base_url(CAL) ?>calendario/getEventos/tareas_planificadas',
      success: function(e) {
         console.log(e);
         for (let i = 0; i < e.length; i++) {
            eventos.push({
               title: e[i].titulo,
               description: e[i].descripcion,
               start: e[i].dia_inicio + 'T00:00' ,//+ e[i].hora_inicio,
               end: e[i].dia_fin + 'T00:00',// + e[i].hora_fin,
               backgroundColor: 'red',
               duracion: e[i].hora_duracion
            });
         }
      },
      error: function(e) {
         alert("Error al cargar los eventos.");
      }
   });
   console.log(eventos);
   return eventos;
}

calendar.render();

// /* MAYUSCULAS */
// var str = $('#calendar').find('h2');
// str.text($(str).text().charAt(0).toUpperCase() + $(str).text().slice(1).toLowerCase());

// calendar.render();

// function diaLaboralSiguiente(diaEvent) {
//    var diaLabSig = '';
//    $.ajax({
//       type: 'GET',
//       dataType: 'json',
//       url: 'Calendario/getDiaLabSig/' + diaEvent,
//       success: function(dia) {

//       },
//       error: function(dia) {
//          alert('Error al traer día.');
//       }
//    });
//    // while (diaNoLaboral(diaEvent)) {
//    //    diaLabSig = diaEvent;
//    // }
//    // return diaLabSig;
// }

// function diaNoLaboral(diaEvent) {
//    diasNoLaborables = []; //TODO: cargar dias no laborales
//    for (let i = 0; i < diasNoLaborables.length; i++) {
//       if (diasNoLaborables[i] == diaEvent) {
//          return true;
//       }
//    }
//    return false;
// }
</script>