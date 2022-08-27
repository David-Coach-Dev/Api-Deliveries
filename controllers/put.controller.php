<?php
    /************************
     *! Requerimientos.
     ************************/
        require_once "models/put.model.php";
        require_once "middleware/response.middleware.php";
    /******************************
     *todo Class Controller PUT
     ******************************/
        class PutController{
            /********************************************
             ** Petición Put para editar datos.
             ********************************************/
                static public function putData($db, $table, $data, $id, $nameId){
                    $response = PutModel::putData($db, $table, $data, $id, $nameId);
                    $return = new responseMiddleware();
                    ($response==null ? $return -> fncResponse(400,  $method, array("error"=>"Sintaxis invalida...")) : $return -> fncResponse(201 , $method, $response));
                }
        }
?>