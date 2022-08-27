<?php
  /********************************
   *todo middleware Response
   ********************************/
    /*********************************
     *? Class Response Middleware
    *********************************/
      class ResponseMiddleware{
        /*************************************************************
         ** Response Validation.
         *************************************************************/
          static public function fncResponseValidation($response,  $method){
            ($response==null ? ResponseMiddleware::fncResponse(400, $method, array("error"=>"Sintaxis invalida...")) : ResponseMiddleware::fncResponse(200, $method, $response));
          }
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