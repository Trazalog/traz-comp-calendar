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
      $resource = 'getEventos/';
      $url = REST9 . $resource;
      $rsp = $this->rest->callApi('GET', $url);
      if ($rsp['status']) {
         $rsp['data'] = json_decode($rsp['data'])->eventos->evento;
      }
      return $rsp;
   }

   public function getDiaNoLab()
   {
   }
}
