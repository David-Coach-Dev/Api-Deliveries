<?php
    /************************
     *! Requerimientos.
     ************************/
        require_once "models/put.model.php";
    /******************************
     *todo Class Controller PUT
     ******************************/
        class PutController{
            /********************************************
             ** Petición Put para editar datos.
             ********************************************/
                static public function putData($db, $table, $data, $id, $nameId){
                    $response = PutModel::putData($db, $table, $data, $id, $nameId);
                    $return = new PutController();
                    $return -> fncResponse($response,"putData",null);
                }
            /*******************************
             ** Respuesta del controlador
             *******************************/
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