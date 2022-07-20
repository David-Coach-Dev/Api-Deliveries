<?php
  /*******************************
   ** Api Deliveries
  ********************************/
    $arrayRouters = explode("/", $_SERVER['REQUEST_URI']);
    $arrayRouters = array_filter($arrayRouters);
  /********************************
   ** No hay Petición en la api
   ********************************/
    if (count($arrayRouters) < 1 || count($arrayRouters) >1) {
      $json = array(
        "status" => 404,
        "detalle" => "not found...",
        "method" => "Router"
      );
      echo json_encode($json, http_response_code($json["status"]));
    }
  /********************************
   ** Petición en la api
   ********************************/
    if (count($arrayRouters) == 1 && isset($_SERVER['REQUEST_METHOD'])){
      /********************************
       *? Set table
      ********************************/
        $table=explode("?",$arrayRouters[1])[0];
      /*************************************
       *? Set DB. 1 -> Sql - 2 -> PgSql
      *************************************/
        $db=2;
      /********************************
       ** Petición GET
      ********************************/
        if ($_SERVER['REQUEST_METHOD']=='GET'){
          include "services/get.php";
        }
      /*******************************
       ** Petición POST
      ********************************/
        if ($_SERVER['REQUEST_METHOD']=='POST'){
          include "services/post.php";
        }
      /********************************
       ** Petición PUT
      ********************************/
        if ($_SERVER['REQUEST_METHOD']=='PUT'){
          include "services/put.php";
        }
      /********************************
       ** Petición DELETE
      ********************************/
        if ($_SERVER['REQUEST_METHOD']=='DELETE'){
          include "services/delete.php";
        }
    }
?>