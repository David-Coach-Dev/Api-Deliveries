<?php
  /****************************************
     *todo Router.
     ****************************************/
      /********************************************
       *! Requerimientos.
      ********************************************/
        require_once "models/connection.php";
        require_once "controllers/router.controller.php";
        require_once "controllers/get.controller.php";
      /*******************************
       ** Api Deliveries
      ********************************/
        $arrayRouters = explode("/", $_SERVER['REQUEST_URI']);
        $arrayRouters = array_filter($arrayRouters);
        date_default_timezone_set('America/Guayaquil');
        $response = new GetController();
        $return = new RouterController();
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
          $return->fncResponse(null,"Router",null);
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
                    $return->fncResponse(null,"Router","You are not authorized to make this request...");
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