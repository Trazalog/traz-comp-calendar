<link href='lib/fullcalendar/core/main.css' rel='stylesheet' />
<link href='lib/fullcalendar/daygrid/main.css' rel='stylesheet' />
<link href='lib/fullcalendar/timegrid/main.css' rel='stylesheet' />
<link href='lib/fullcalendar/list/main.css' rel='stylesheet' />



<link href='lib/fullcalendar/bootstrap/main.css' rel='stylesheet' />

<div id="calendar"></div>

<script src='lib/fullcalendar/core/main.js'></script>
<script src='lib/fullcalendar/daygrid/main.js'></script>
<script src='lib/fullcalendar/interaction/main.js'></script>
<script src='lib/fullcalendar/timegrid/main.js'></script>
<script src='lib/fullcalendar/list/main.js'></script>
<!-- <script src='fullcalendar/google-calendar/main.js'></script> -->
<script src='lib/fullcalendar/core/locales/es.js'></script>
<script src='lib/fullcalendar/bootstrap/main.js'></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script> -->
<!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script> -->
<script>
//View_opciones = dayGridDay,timeGridWeek,timeGrid(custom)
var calendarEl = document.getElementById('calendar');
var calendar = new FullCalendar.Calendar(calendarEl, {
    plugins: ['interaction', 'dayGrid', 'list', 'bootstrap','timeGrid'],
    header: {
        left: 'prev,next, today',
        center: 'title',
        right: 'timeGrid,dayGridWeek,dayGridMonth,list'
    },
    views: {
        timeGrid: {
            type: 'timeGrid',
            minTime: '<?php echo HORA_INICIO_JORNADA ?>:00',
            maxTime: '<?php echo HORA_FIN_JORNADA ?>:00',
            buttonText: 'Día'
        }
    },
    // weekends: false,
    locale: 'es',
    themeSystem: 'bootstrap',
    events: function(info, successCallback, failureCallback) {
        data = {};
        data.tipoEvento = 'tareas_planificadas';
        if ( $('#seccionFiltros').children().length > 0 ) {
            $('#seccionFiltros div.permTransito').each(function(i, obj) {
                aux = $(obj).attr('data-json');
                json = JSON.parse(aux);
            });
            data.filtros = {"algo":"eso mismo"};
        }
        
        $.ajax({
            type: 'POST',
            dataType: 'JSON',
            data: data,
            url: '<?php echo base_url(CAL) ?>calendario/getEventos',
            success: function(e) {
                var eventos = [];
                for (let i = 0; i < e.length; i++) {
                    eventos.push({
                        title: e[i].titulo,
                        description: e[i].descripcion,
                        start: e[i].dia_inicio,
                        end: e[i].dia_fin,
                        backgroundColor: 'red',
                        duracion: e[i].hora_duracion
                    });
                }
                successCallback(eventos);
            },
            error: function(e) {
                alert("Error al cargar los eventos.");
            }
        });
    },
    selectable: true,
    editable: true,
    droppable: true,
    dateClick: function(info) {
        clickCalendario(info);
    }
});

var getEvents = function() {
    var eventos = [];
    $.ajax({
        type: 'GET',
        dataType: 'JSON',
        url: '<?php echo base_url(CAL) ?>calendario/getEventos/tareas_planificadas',
        success: function(e) {
            console.log(e);
            for (let i = 0; i < e.length; i++) {
                eventos.push({
                    title: e[i].titulo,
                    description: e[i].descripcion,
                    start: e[i].dia_inicio,
                    end: e[i].dia_fin,
                    backgroundColor: 'red',
                    duracion: e[i].hora_duracion
                });
            }
            successCallback(eventos);
        },
        error: function(e) {
            alert("Error al cargar los eventos.");
        }
    });

}

function calendarRefetchEvents(){
  $('.fc-prev-button').click();
  $('.fc-next-button').click();
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