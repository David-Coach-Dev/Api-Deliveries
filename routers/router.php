<?php
  /****************************************
     *todo Router.
     ****************************************/
      /********************************************
       *! Requerimientos.
      ********************************************/
        require_once "models/connection.php";
        require_once "controllers/get.controller.php";
        require_once "middleware/response.middleware.php";
      /*******************************
       ** Api Deliveries
      ********************************/
        $arrayRouters = explode("/", $_SERVER['REQUEST_URI']);
        $arrayRouters = array_filter($arrayRouters);
        date_default_timezone_set('America/Guayaquil');
        $response = new GetController();
        $return = new responseMiddleware();
      /*************************************
       *? Set DB
       ** 1 -> Sql-local
       ** 2 -> Sql-Heroku
       ** 3 -> PgSql-local
       ** 4 -> PgSql-Heroku
       *************************************/
        $db=2;
      /********************************
       ** No hay Petición en la api
      ********************************/
        if (count($arrayRouters) < 1 || count($arrayRouters) >1) {
          $return->fncResponse(404, "Router", "No se encontrar la ruta solicitado");
          return;
        }
      /********************************
       ** Petición en la api
      ********************************/
        if (count($arrayRouters) == 1 && isset($_SERVER['REQUEST_METHOD'])){
          /********************************
           *? Set table
          ********************************/
            $table=explode("?",$arrayRouters[1])[0];
          /********************************
           *? Validación de la Api Key
          ********************************/
            if (!isset(getallheaders()["Authorization"]) || getallheaders()["Authorization"] != Connection::apiKey()) {
                  /********************************
                   *? Tabla es privada
                  ********************************/
                  if(in_array($table, Connection::publicAccess())==0){
                    $return->fncResponse(401, "Router", "No está autorizado para realizar esta solicitud...");
                    return;
                  }else{
                    /********************************
                     *? Tabla es publica
                     ********************************/
                      $response->getData($db, $table, "*", null, null, null, null);
                      return;
                  }
            }
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