<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Calendarios extends CI_Model
{
   function __construct()
   {
      parent::__construct();
      // $this->load->library('REST');
   }

   public function getEventos($tipoEvento)
   {
      switch ($tipoEvento) {
         case 'tareas_planificadas':
            $url = REST_TST.'/tareas/eventos/'.empresa();
            break;
         
         default:
            # code...
            break;
      }

      $rsp = wso2($url);
      if($rsp['status']){
         $rsp['data'] = $this->map($rsp['data']);
      }
      
      log_message("DEBUG","#TRAZA | MODEL Calendarios | getEventos() | data >>". json_encode($rsp['data']));
      return $rsp;
   }

   public function map($data)
   {
      foreach ($data as $key => $o) {
         $data[$key]->dia_inicio = str_replace('+', 'T', $o->dia_inicio);
         $data[$key]->dia_fin = str_replace('+', 'T', $o->dia_fin);
         if(!empty($o->hora_duracion)){$data[$key]->hora_duracion = $o->hora_duracion;}else{$data[$key]->hora_duracion = "0";}
         // $data[$key]->hora_duracion = $o->tiempo_duracion;
         $data[$key]->hora_inicio = date("H:i",strtotime($o->hora_inicio));
      }
      return $data;
   }

   public function xgetEventos($tipoEvento)
   {
      $resource = 'eventos';
      $url = REST8 . $resource;
      $rsp = $this->rest->callApi('GET', $url);
      if ($rsp['status']) {
         $rsp['data'] = json_decode($rsp['data'])->eventos->evento;
      }
      return $rsp;
   }

   public function setEvento($dia, $minTask)
   {
      log_message('DEBUG', 'Calendarios/setEvento($dia)-> ' . $dia);
      log_message('DEBUG', 'Calendarios/setEvento($minTask)-> ' . $minTask);

      $arrayDatos['dia'] = $dia;
      $arrayDatos['minTask'] = $minTask;
      $data['_post_evento'] = $arrayDatos;
      $datos = json_encode($data);
      log_message('DEBUG', 'Calendarios/setEvento-> ' . $datos);

      $resource = 'dias/dividir'; //cargar patch
      $url = REST8 . $resource;

      $array = $this->rest->callAPI("POST", $url, $data);
      // wso2Msj($array);
      return json_decode($array['status']);
   }

   public function getDiasNoLab()
   {
      //falta desarrollar
      $diasNoLab = array("2021-05-25","2021-05-01","2021-05-02","2021-05-09");
      $rsp = array();
      foreach ($diasNoLab as $key => $value) {
         $rsp[$key] = new stdClass();
         $rsp[$key]->fecha = $value;
      }

      // $resource = 'dias/nolaborables';
      // $url = REST8 . $resource;
      // $array = $this->rest->callAPI("GET", $url);
      // $rsp = json_decode($array['data'])->dias->dia;
      // $rsp = json_decode($array)->dias->dia;
      // log_message('DEBUG', 'Calendarios/getDiaNoLab'.json_encode($rsp));
      return $rsp;
   }
}
