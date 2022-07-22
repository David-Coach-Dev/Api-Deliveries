<?php
  /****************************************
   *todo Petición DELETE.
  ****************************************/
    /********************************************
     *! Requerimientos.
    ********************************************/
      require_once "models/connection.php";
      require_once "controllers/delete.controller.php";
    /********************************************
     *? Variables
    ********************************************/
      $columns=array();
      $id=$_GET["id"]?? null;
      $nameId=$_GET["nameId"]?? null;
      $suffix=$_GET["suffix"]?? null;
      $active=$_GET["active"]?? null;
      $response = new DeleteController();
      $return = new DeleteController();
    /***************************************************************
     *? Validando variables de DELETE
     ***************************************************************/
      if(isset($_GET["id"]) && isset($_GET["nameId"])){
        /********************************************
         *? Validar la tabla y columnas
         ********************************************/
          $columns = array($_GET["nameId"]);
          if (empty(Connection::getColumnsData($db, $table, $columns))){
            $return -> fncResponse(null,"Delete");
            return;
          }
        /***********************************************************************************
         *? Petición Delete para cambizar el active a false em DB
         ***********************************************************************************/
          if(isset($_GET["desactive"]) && $_GET["desactive"]==true){
              $response->deleteDataActive($db, $table, $id, $nameId, $suffix);
            }else{
              /***********************************************************************************
               *? solicitud de repuestas del controlador para borrar datos en cualquier tabla
               ***********************************************************************************/
                $response->deleteData($db, $table, $id, $nameId);
          }
      }
?>