<?php
  /****************************************
   *todo Petición DELETE.
  ****************************************/
    /********************************************
     *! Requerimientos.
    ********************************************/
      require_once "models/connection.php";
      require_once "controllers/delete.controller.php";
      require_once "middleware/response.middleware.php";
    /********************************************
     *? Variables
    ********************************************/
      $columns=array();
      $id=$_GET["id"]?? null;
      $nameId=$_GET["nameId"]?? null;
      $suffix=$_GET["suffix"]?? null;
      $desactive=$_GET["desactive"]?? null;
      $response = new DeleteController();
      $return = new responseMiddleware();
    /***************************************************************
     *? Validando variables de DELETE
     ***************************************************************/
      if(isset($_GET["id"]) && isset($_GET["nameId"])){
        /********************************************
         *? Validar la tabla y columnas
         ********************************************/
          $columns = array($_GET["nameId"]);
          if (empty(Connection::getColumnsData($db, $table, $columns))){
            $return -> fncResponse(null,"Delete","Tabla o Columna invalida..");
            return;
          }
        /***********************************************************************************
         *? Petición Delete para usuarios autorizados con JWT
          ***********************************************************************************/
            if(isset($_GET["token"])){
              $tableToken=$_GET["tableToken"]?? "users";
              $suffixToken=$_GET["suffixToken"]?? "user";
              $validate=Connection::valideToken($db, $tableToken, $suffixToken, $_GET["token"]);
              /***********************************************************************************
               *? Ok -> si el token existe y no esta expirado.
               ***********************************************************************************/
                if($validate=="ok"){
                  /***********************************************************************************
                   *? Validación si Desactiva o borra
                   ***********************************************************************************/
                    if(isset($_GET["desactive"]) && $_GET["desactive"]==true){
                      /***********************************************************************************
                       *? Petición para cambizar el active a false
                       ***********************************************************************************/
                        $response->deleteDataDesactive($db, $table, $id, $nameId, $suffix);
                    }else{
                      /***********************************************************************************
                       *? solicitud Para borrar dato en cualquier tabla
                       ***********************************************************************************/
                        $response->deleteData($db, $table, $id, $nameId);
                    }
                  /***********************************************************************************
                   *? Exp -> si el token existe pero esta expirado.
                   ***********************************************************************************/
                    if($validate=="exp"){
                        $return->fncResponse(null,"DELETE","El token a expirado." );
                    }
                  /***********************************************************************************
                   *? No-out -> si el token no coincide en DB.
                   ***********************************************************************************/
                    if($validate=="no-aut"){
                        $return->fncResponse(null,"DELETE","El usuario no esta autorizado." );
                    }
                }else{
                  /***********************************************************************************
                   *? No consta con un token de autorización.
                   ***********************************************************************************/
                      $return->fncResponse(null,"DELETE","Autorización requerida.");
            }
    }
      }
?>