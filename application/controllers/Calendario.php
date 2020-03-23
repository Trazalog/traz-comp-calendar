<?php defined('BASEPATH') or exit('No direct script access allowed');

class Calendario extends CI_Controller
{
   function __construct()
   {
      parent::__construct();
      $this->load->model('traz-comp-calendar/Calendarios');
   }
   public function index()
   {
      // $data['eventos'] = $this->Calendarios->getEventos();
      $this->load->view('traz-comp-calendar/calendario');
      // $this->getEventos();
   }

   public function getEventos()
   {
      $rsp = $this->Calendarios->getEventos();
      $seFracciono = false;
      foreach ($rsp as $key) {
         // if ($rsp['status']) {
         $minTask = $this->hoursToMinutes($key['data']->hora_duracion);
         $jornada = '08:00'; //duracion de la jornada laboral
         $minJornada = $this->hoursToMinutes($jornada);

         $horaFinJornada = '19:00';
         $minFinJornada = $this->hoursToMinutes($horaFinJornada);

         $horaActual = date("G"); //hora actual de la jornada en curso
         $minActualJornada = $this->hoursToMinutes($horaActual);
         //tiempo restante jornada en curso
         $minRestantesJornada = $minFinJornada - $minActualJornada;
         // $minHoy = $minRestantesJornada - $minTask;
         if ($minTask <= $minRestantesJornada) {
            //carga los minutos en lo que resta del dia
            $key['data']->hora_fin = $this->minutesToHours($minActualJornada + $minTask);
         } else {
            $key['data']->hora_fin = $this->minutesToHours($minRestantesJornada);
            $minRestanteTask = $minTask - $minRestantesJornada;
            // $hoy = getdate();
            $hoy = time(); //fecha actual expresada en segundos
            while ($minRestanteTask >= $minJornada) {
               $diaLaboralSig = $this->getDiaLabSig($hoy);
               //cargo la parte de la tarea
               $this->Calendarios->setEvento($diaLaboralSig, $minJornada); //completo dia siguiente con el total de horas, jornada completa. Sigue quedando tiempo remanente para cargar el proximo dia laboral siguiente.
               $minRestanteTask -= $minJornada;
               $hoy = $diaLaboralSig;
            }
            if ($minRestanteTask > 0) {
               $diaLaboralSig = $this->getDiaLabSig($hoy);
               //carga la ultima parte del ramanente de tiempo. Es el ultimo dia laboral.
               $this->Calendarios->setEvento($diaLaboralSig, $minRestanteTask);
            }

            $seFracciono = true;
         }
      }
      //recargo los eventos ya fraccionados.
      if ($seFracciono) {
         $this->getEventos(); //si al menos un evento fue fraccionado, recarga los eventos.
      }

      $this->load->view('traz-comp-calendar/calendario', $rsp);
   }

   public function getDiaLabSig($dia = null)
   {
      $unDiaEnSegundos = 24 * 60 * 60;
      $manana = $dia + $unDiaEnSegundos;
      $mananaLegible = date("Y-m-d", $manana);
      $dEvento = $this->getDiaNoLab($mananaLegible);

      if ($dEvento) { //si es un dia no laborable
         $this->getDiaLabSig($manana);
      } else {
         return $mananaLegible;
      }
   }

   public function getDiaNoLab($dia = null)
   {
      $diasNoLab = $this->Calendarios->getDiasNoLab();
      foreach ($diasNoLab as $key) {
         if ($key == $dia) {
            return true;
         }
      }
      return false;
   }

   function hoursToMinutes($hours)
   {
      $minutes = 0;
      if (strpos($hours, ':') !== false) {
         // Divide horas y minutos
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
