<?php
  /*******************************
   ** Crea el archivo de errores
   *******************************/
    ini_set('display_errors', 1);
    ini_set('log_errors', 1);
    ini_set('error_log', "C:/xampp/htdocs/Deliveries/api/api.error.log");
  /*******************************
   ** Cors
   *******************************/
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, content-type, Accept");
    header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
    header("Allow: GET, POST, OPTIONS, PUT, DELETE");
    header('content-type: application/json; charset=utf-8');
  /*******************************
   ** Requerimientos
   *******************************/
    require_once "controllers/router.controller.php";
  /*******************************
   ** Index
   *******************************/
    $index = new RouterController();
    $index->index();
?>