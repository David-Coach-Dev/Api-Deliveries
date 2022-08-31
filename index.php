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
    header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, XMLHttpRequest, Content-Type, Accept");
    header('Access-Control-Allow-Methods: GET, POST,OPTIONS, OPTIONS, PUT, DELETE');
    header('Access-Control-Allow-Credentials: true');
    header('content-type: application/json; application/x-www-form-urlencoded; multipart/form-data;boundary=something; text/plain; charset=utf-8;');
    header("Allow: GET, POST, OPTIONS, PUT,  DELETE");
    if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {header("HTTP/1.1 200 OK");}
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