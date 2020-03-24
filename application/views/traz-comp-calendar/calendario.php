<!DOCTYPE html>
<html lang='en'>

<head>
   <meta charset='utf-8' />

   <link href='lib/fullcalendar/core/main.css' rel='stylesheet' />
   <link href='lib/fullcalendar/daygrid/main.css' rel='stylesheet' />
   <!-- <link href='lib/fullcalendar/timegrid/main.css' rel='stylesheet' /> -->
   <link href='lib/fullcalendar/list/main.css' rel='stylesheet' />

   <link href='https://use.fontawesome.com/releases/v5.0.6/css/all.css' rel='stylesheet'>
   <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet' />
   <!-- <link rel="stylesheet" href="https://bootswatch.com/4/solar/bootstrap.min.css"> -->
   <link rel="stylesheet" href="https://bootswatch.com/4/superhero/bootstrap.min.css">
   <!-- <link rel="stylesheet" href="https://bootswatch.com/4/materia/bootstrap.min.css"> -->

   <link href='lib/fullcalendar/bootstrap/main.css' rel='stylesheet' />
</head>

<body>

   <section class="content">
      <style>
         input.prevent {
            border: none;
            padding-left: 5px;
            width: 100%;
         }

         .selmes {
            margin-bottom: 10px;
         }
      </style>

      <!-- CALENDARIO -->
      <div class="col-md-7">
         <div class="box box-primary">
            <div class="box-body">
               <div class="fa fa-fw fa-print text-light-blue" style="cursor: pointer; margin-left:10px;" title="Imprimir"></div>
               <button class="btn btn-link" title="Filtrar OT" onclick="openPanel()">
                  <i class="fa fa-fw fa-filter text-light-blue"></i>
               </button>
               <div id="calendar"></div>
            </div><!-- /.box-body -->
         </div><!-- /. box -->
      </div><!-- /.col -->

      <div id="tablas">
      </div>

   </section><!-- /.content -->

</body>

<script src='lib/fullcalendar/core/main.js'></script>
<script src='lib/fullcalendar/daygrid/main.js'></script>
<script src='lib/fullcalendar/interaction/main.js'></script>
<!-- <script src='fullcalendar/timegrid/main.js'></script> -->
<script src='lib/fullcalendar/list/main.js'></script>
<!-- <script src='fullcalendar/google-calendar/main.js'></script> -->
<script src='lib/fullcalendar/core/locales/es.js'></script>
<script src='lib/fullcalendar/bootstrap/main.js'></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script> -->
<script>
   // document.addEventListener('DOMContentLoaded', function() {
   // var calendarEl = $('#calendar');
   // var calendarEl = document.getElementById('calendar');
   var calendarEl = $('#calendar');
   // console.log('calendar');
   // console.table(calendarEl);

   var calendar = new FullCalendar.Calendar(calendarEl, {
      plugins: ['interaction', 'dayGrid', 'list', 'bootstrap'],
      header: {
         left: 'prev,next, today',
         center: 'title',
         right: 'dayGridDay,dayGridWeek,dayGridMonth,list'
      },
      // buttonText: {
      //    today: 'Hoy',
      //    month: 'Mes',
      //    week: 'Semana',
      //    day: 'Día',
      //    list: 'Lista'
      // },
      locale: 'es',
      themeSystem: 'bootstrap',
      // events: [{
      //       title: 'Nacho = Judas',
      //       start: '2020-03-10 14:30',
      //       // end: '2019-03-12T11:30:00',
      //       extendedProps: {
      //          department: 'BioChemistry'
      //       },
      //       description: 'Lecture',
      //    }
      //    // mas eventos ...
      // ],
      // events: getEvents(tipo_evento, callback),
      events: getEvents(),
      selectable: true,
      editable: true,
      droppable: true
   });

   calendar.render();

   /* MAYUSCULAS */
   var str = $('#calendar').find('h2');
   str.text($(str).text().charAt(0).toUpperCase() + $(str).text().slice(1).toLowerCase());

   // function getEvents(tipo_evento, callback) {
   function getEvents() {
      var eventos = [];
      // var titulo = 'hola';
      // var descripcion = 'como';
      // var dia_incicio = '2020-03-10';
      // var hora_inicio = '14:30';
      // var hora_duracion = '15:00';
      // var dia_fin = '2020-03-15';
      // var hora_fin = '17:00';
      // var color = '#f56954';

      // for (let i = 0; i < eventos.length; i++) {
      //    if (diaNoLaboral(dia_incicio)) {
      //       alert('Dia no laborable.');
      //    } else {
      //       hs = hora_duracion - hs_jornada;
      //       if (hs > 0) {
      //          hora_fin_jornada - hs;
      //          jornada_lab_sig = diaLaboralSiguiente(dia_incicio_sig);
      //       }
      //    }
      // }

      // eventos.push({
      //    title: titulo + '|' + descripcion,
      //    start: dia_incicio + ' ' + hora_inicio,
      //    // end: dia_fin + ' ' + hora_fin,
      //    end: getFin(),
      //    backgroundColor: color,
      //    duracion: hora_duracion
      // });
      // return eventos;

      $.ajax({
         type: 'GET',
         dataType: 'JSON',
         url: 'Calendario/getEventos/',
         success: function(e) {
            console.log(e);
            // var eventos = [];
            e = JSON.parse(e);
            for (let i = 0; i < e.length; i++) {
               eventos.push({
                  title: e.titulo + '|' + e.descripcion,
                  start: e.dia_incicio + ' ' + e.hora_inicio,
                  end: e.dia_fin + ' ' + e.hora_fin,
                  // backgroundColor: color,
                  duracion: e.hora_duracion
               });
            }

            // eventos.push({
            //    title: titulo + '|' + descripcion,
            //    start: dia_incicio + ' ' + hora_inicio,
            //    end: dia_fin + ' ' + hora_fin,
            //    backgroundColor: color,
            //    duracion: hora_duracion
            // });
            // $(e).each(function() {
            // var titulo = $(this);
            // var descripcion = $(this);
            // var dia_incicio = $(this);
            // var hora_inicio = $(this);
            // var hora_duracion = $(this);
            // var dia_fin = $(this);
            // var hora_fin = $(this);
            // })
         },
         error: function(e) {

         }
      });
   }

   function cargarHoras() {

   }

   function diaLaboralSiguiente(diaEvent) {
      var diaLabSig = '';
      $.ajax({
         type: 'GET',
         dataType: 'json',
         url: 'Calendario/getDiaLabSig/' + diaEvent,
         success: function(dia) {

         },
         error: function(dia) {
            alert('Error al traer día.');
         }
      });
      // while (diaNoLaboral(diaEvent)) {
      //    diaLabSig = diaEvent;
      // }
      // return diaLabSig;
   }

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

</html>
