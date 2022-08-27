<?php
  /************************
   *! Requerimientos.
   ************************/
    require_once "models/delete.model.php";
    require_once "models/put.model.php";
    require_once "middleware/response.middleware.php";
  /******************************
   *todo Class Controller delete
   ******************************/
    class DeleteController{
      /********************************************
       ** Petición DELETE.
       ********************************************/
        static public function deleteData($db, $table, $id, $nameId){
          $response = DeleteModel::deleteData($db, $table, $id, $nameId);
          ResponseMiddleware::fncResponseValidation("deleteData", $response);
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
            ResponseMiddleware::fncResponseValidation("deleteDataDesactive", $update);
        }
    }
?>