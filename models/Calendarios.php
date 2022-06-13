<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Calendarios extends CI_Model{

   function __construct(){
      parent::__construct();
   }
   /**
	* Recibe un tipo de evento y los filtros seleccionados, busca las tareas relacionadas con ese tipo coincidentes con los filtros
	* @param string $tipoEvento y array $filtros
	* @return array listado de tareas coincidentes con el parámetro
	*/
   public function getEventos($data){
      switch ($data['tipoEvento']) {
         case 'tareas_planificadas':
            $url = REST_TST.'/tareas/eventos/'.empresa();
            break;
         case 'tareas_planificadas_filtradas':
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
   /**
	* Formatea los eventos recibidos, co nel formato requerido por el plugin del calendario
	* @param array $data con eventos
	* @return array listado de tareas formateadas	
   */
   public function map($data){
      foreach ($data as $key => $o) {
         $data[$key]->dia_inicio = str_replace('+', 'T', $o->dia_inicio);
         $data[$key]->dia_fin = str_replace('+', 'T', $o->dia_fin);
         if(!empty($o->hora_duracion)){$data[$key]->hora_duracion = $o->hora_duracion;}else{$data[$key]->hora_duracion = "0";}
         $data[$key]->hora_inicio = date("H:i",strtotime($o->hora_inicio));
      }
      return $data;
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
