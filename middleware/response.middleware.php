<?php
  /********************************
   *todo middleware Response
   ********************************/
    /*********************************
     *? Class Response Middleware
    *********************************/
      class responseMiddleware{
      /*****************************************
       ** Respuesta para los controladores
       *****************************************/
        public function fncResponse($status, $method, $response){
          $json = array(
            "status" => $status,
            "method" => $method,
            "total" => count($response),
            "response" => $response
          );
          echo json_encode($json, http_response_code($json["status"]));
        }
  }
?>