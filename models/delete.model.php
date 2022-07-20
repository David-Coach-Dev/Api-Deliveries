<?php
    /****************************************
     *todo Delete Model.
     ****************************************/
        /****************************************
         *! Requerimientos.
        ****************************************/
            require_once "connection.php";
            require_once "get.model.php";
        /****************************************
         *? Class DELETE model.
         ****************************************/
            class DeleteModel{
                /******************************************
                 ** Petición DELETE para borrar datos.
                 ******************************************/
                    static public function deleteData($db, $table,$id, $nameId){
                        /************************************
                         *? Validación del ID
                         ************************************/
                            $response=GetModel::getDataFilter($db, $table, $nameId,
                            $nameId,$id, null, null, null, null);
                            if(empty($response)){
                                return null;
                            }
                            /********************************
                             *? Armando sentencia sql
                            ********************************/
                                $sql = "DELETE FROM $table WHERE $nameId = :$nameId";
                            /********************************
                             *? Contención con sql
                            ********************************/
                                $link=Connection::connect($db);
                                $stmt = $link->prepare($sql);
                            /********************************
                             *? Armado los parámetros.
                            ********************************/
                                $stmt -> bindParam(":".$nameId, $id, PDO::PARAM_STR);
                            /********************************
                             *? Ejecutar sentencia sql.
                            ********************************/
                                if($stmt->execute()){
                                    $response = array(
                                        "comment" => "The process was successful"
                                    );
                                    return $response;
                                }else{
                                    return $link->errorInfo();
                                }
                    }
            }

?>