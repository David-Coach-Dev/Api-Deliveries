<?php
  /*****************************
   *todo middleware ROUTER
   ****************************/
    class responseMiddleware{
      /*****************************************
       ** Respuesta para los controladores
       *****************************************/
        public function fncResponse($response, $method, $error){
          if(!empty($response)){
            $json = array(
              "status" => 201,
              "method" => $method,
              "total" => count($response),
              "detalle" => $response
            );
          }else{
          if($error != null){
            $json = array(
              "status" => 400,
              "method" => $method,
              "error" => $error,
          );
          }else{
          $json = array(
            "status" => 404,
            "method" => $method,
            "detalle" => "not found...",
          );
          }
        }
          echo json_encode($json, http_response_code($json["status"]));
        }
  }
?>