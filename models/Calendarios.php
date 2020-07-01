<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Calendarios extends CI_Model
{
   function __construct()
   {
      parent::__construct();
      // $this->load->library('REST');
   }

   public function getEventos()
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
      log_message('DEBUG', 'Calendarios/getDiaNoLab');
      $resource = 'dias/nolaborables';
      $url = REST8 . $resource;
      $array = $this->rest->callAPI("GET", $url);
      $rsp = json_decode($array['data'])->dias->dia;
      return $rsp;
   }
}
