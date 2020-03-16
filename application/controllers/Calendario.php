<?php defined('BASEPATH') or exit('No direct script access allowed');

class Calendario extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('Calendarios');
   }
   public function index()
   {
      // $data['eventos'] = $this->Calendarios->getEventos();
      $this->load->view('traz-comp-calendar/calendario', $data);
   }

   // public function getEventos($tipo_evento)
   // {
   //    $data = $this->Calendarios->getEventos($tipo_evento);
   //    if (!$data) {
   //       log_message('ERROR', 'Calendario | getEventos : >>' . json_decode($data));
   //       return;
   //    } else {
   //       log_message('DEBUG', 'Calendario | getEventos : >>' . json_decode($data));
   //       echo json_decode($data);
   //    }
   // }

   public function getEventos()
   {
      $rsp = $this->Calendarios->getEventos();
      if ($rsp['status']) {
         $minTask = $this->hoursToMinutes($rsp['data']->hora_duracion);
         $jornada = '08:00'; //duracion de la jornada laboral
         $minJornada = $this->hoursToMinutes($jornada);

         $horaFinJornada = '19:00';
         $minFinJornada = $this->hoursToMinutes($horaFinJornada);

         $horaActual = date("G"); //horaactual
         $minActual = $this->hoursToMinutes($horaActual);
         //tiempo restante jornada en curso
         $minRestantes = $horaFinJornada - $minActual;
         $minHoy = $minRestantes - $minTask;
         if ($minHoy <= 0) {
            //carga los minutos en lo que resta del dia
            $rsp['data']->hora_fin = $this->minutesToHours($minJornada - $minTask);
         } else {
            //se fija cual es el dia laboral siguiente
            $dia2 = '';
         }

         $rsp['data']->minTask = $minTask;
         echo $rsp['data'];
      }
   }

   public function getDiaLabSig($dia = null)
   {
      $dEvento = $this->getDiaNoLab($dia);

      return $dEvento;
   }

   public function getDiaNoLab($dia = null)
   {
      $dEvento = $dia;

      return $dEvento;
   }

   function hoursToMinutes($hours)
   {
      $minutes = 0;
      if (strpos($hours, ':') !== false) {
         // Split hours and minutes.
         list($hours, $minutes) = explode(':', $hours);
      }
      return $hours * 60 + $minutes;
   }

   function minutesToHours($minutes)
   {
      $hours = (int) ($minutes / 60);
      $minutes -= $hours * 60;
      return sprintf("%d:%02.0f", $hours, $minutes);
   }
}
