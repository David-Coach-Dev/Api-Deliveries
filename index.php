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
    header("Access-Control-Allow-Headers: Origin,Authorization,x-www-form-urlencoded, X-Requested-With, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST,OPTIONS, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Credentials: true');
    header('content-type: application/json; application/x-www-form-urlencoded; charset=utf-8');
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