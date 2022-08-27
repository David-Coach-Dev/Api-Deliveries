<?php
  /*********************************
   *todo middleware Validation.
   *********************************/
    /************************
     *! Requerimientos.
     ************************/
      require_once "connection.php";
      require_once "middleware/response.middleware.php";
    /**********************************
     *? Class Validation Middleware.
     **********************************/
    class validationMiddleware{
      /*****************************************
       ** Respuesta para los controladores
       *****************************************/
        public function fncTableAndColumnValidation($db, $method, $table, $columns){
          $return = new responseMiddleware();
          if (empty(Connection::getColumnsData($db, $table, $columns))){
                $return->fncResponse(400, $method , "Tabla o Columna invalida...");
            }
          return;
        }
        /*************************************************************
         ** 9.- Response Validation.
         *************************************************************/
          static public function fncResponseValidation($response,  $method){
            $return = new responseMiddleware();
            ($response==null ? $return -> fncResponse(400,  $method, "Sintaxis invalida...") : $return -> fncResponse(200, $method, $response));
          }
  }
?>