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
      $data = $rsp['data'];
      $seFracciono = false;
      $i = 0;
      foreach ($data as $key) {
         // if ($rsp['status']) {
         $minTask = $this->hoursToMinutes($data[$i]->hora_duracion);
         $jornada = '08:00'; //duracion de la jornada laboral
         $minJornada = $this->hoursToMinutes($jornada);

         $horaFinJornada = '19:00';
         $minFinJornada = $this->hoursToMinutes($horaFinJornada);

         if (isset($data[$i]->hora_inicio)) { //si el evento está cargado con hora de inicio, comienza ahi
            $horaActualSimple = $data[$i]->hora_inicio;
         } else {//sino quiere decir que va a comezar en el momento actual
            // $horaActual = date("G"); //hora actual de la jornada en curso //marca solo la hora no los min
            // $horaActual = getdate();
            // $horaActualSimple = $horaActual['hours'] . ':' .  $horaActual['minutes'];
            $horaActualSimple = "13:00";
         }

         $minActualJornada = $this->hoursToMinutes($horaActualSimple);
         //tiempo restante jornada en curso
         $minRestantesJornada = $minFinJornada - $minActualJornada;
         // $minHoy = $minRestantesJornada - $minTask;
         if ($minTask <= $minRestantesJornada) {
            //carga los minutos en lo que resta del dia
            $hora_fin = $minActualJornada + $minTask;
            $data[$i]->hora_fin = $this->minutesToHours($hora_fin);
         } else {
            $data[$i]->hora_fin = $this->minutesToHours($minRestantesJornada);
            $minRestanteTask = $minTask - $minRestantesJornada;
            // $hoy = getdate();
            if (isset($data[$i]->dia_incicio)) { //si el evento está cargado con dia de inicio, comienza ahi
               $hoy = strtotime($data[$i]->dia_incicio);//convierte la fecha en segundos
            } else {
               $hoy = time(); //fecha actual expresada en segundos
            }

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
         $i++;
      }
      //recargo los eventos ya fraccionados.
      if ($seFracciono) {
         $this->getEventos(); //si al menos un evento fue fraccionado, recarga los eventos.
      }

      // $this->load->view('traz-comp-calendar/calendario', $rsp);
      echo json_encode($data);
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
      $i = 0;
      foreach ($diasNoLab as $key => $value) {
         if ($diasNoLab[$key]->fecha == $dia) {
            return true;
         }
         $i++;
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
