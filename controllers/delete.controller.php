<?php
  /************************
   *! Requerimientos.
    ************************/
      require_once "models/delete.model.php";
      require_once "models/put.model.php";
  /******************************
   *todo Class Controller delete
    ******************************/
    class DeleteController{
      /********************************************
       ** Petición DELETE.
       ********************************************/
        static public function deleteData($db, $table, $id, $nameId){
            $response = DeleteModel::deleteData($db, $table, $id, $nameId);
            $return = new DeleteController();
            $return -> fncResponse($response,"deleteData",null);
        }
      /********************************************
       ** Petición DELETE para cambizar el active
       ********************************************/
        static public function deleteDataDesactive($db, $table, $id, $nameId, $suffix){
          /********************************************
           *? armando la data a actualizar en la DB
           ********************************************/
            $val=explode("_",$nameId)[1];
            if($suffix == null || $suffix!=$val){
              $suffix=$val;
            }
            $data=array(
                "active_".$suffix => false
            );
            $update=PutModel::putData($db, $table, $data, $id, $nameId);
            $return = new DeleteController();
            $return -> fncResponse($update,"deleteDataActive", null);
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