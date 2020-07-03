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
   var calendarEl = document.getElementById('calendar');
   var calendar = new FullCalendar.Calendar(calendarEl, {
      timeZone: 'local',
      dateClick: function(arg) {
         console.log(arg.date.toString()); // use *local* methods on the native Date Object
         // will output something like 'Sat Sep 01 2018 00:00:00 GMT-XX:XX (Eastern Daylight Time)'
      },
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
      droppable: true
   });

   function getEvents() {
      var eventos = [
         // {
         //    title: 'Nacho = Judas',
         //    start: '2020-03-26 14:30',
         //    end: '2010-03-26 17:30:00'
         // },
         // {
         //    title: 'Nacho = Judas',
         //    start: '2020-03-27 14:30',
         //    end: '2010-03-27 17:30:00'
         // },
         // {
         //    title: 'Nacho = Judas',
         //    start: '2020-03-28 14:30'
         // }
      ];

      $.ajax({
         async: false,
         type: 'GET',
         dataType: 'JSON',
         url: 'Calendario/getEventos/',
         success: function(e) {
            console.log(e);
            // var eventos = [];
            // e = JSON.parse(e);
            for (let i = 0; i < e.length; i++) {
               eventos.push({
                  title: e[i].titulo,
                  description: e[i].descripcion,
                  start: e[i].dia_incicio + 'T' + e[i].hora_inicio,
                  end: e[i].dia_fin + 'T' + e[i].hora_fin,
                  // backgroundColor: color,
                  duracion: e[i].hora_duracion
               });
            }
            console.log("despues del for");
            console.table(eventos);
         },
         error: function(e) {
            alert("Error al cargar los eventos.");
         }
      });
      return eventos;
   }

   calendar.render();

   /* MAYUSCULAS */
   var str = $('#calendar').find('h2');
   str.text($(str).text().charAt(0).toUpperCase() + $(str).text().slice(1).toLowerCase());

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

   function openPanel() {

   }
</script>

</html>
