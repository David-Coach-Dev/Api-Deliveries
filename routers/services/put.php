<?php
    /****************************************
     *todo Petición PUT.
    ****************************************/
        /********************************************
         *! Requerimientos.
        ********************************************/
            require_once "models/connection.php";
            require_once "controllers/put.controller.php";
        /********************************************
         *? Variables
        ********************************************/
            $data=array();
            $columns=array();
            $id=$_GET["id"]?? null;
            $nameId=$_GET["nameId"]?? null;
            $response = new PutController();
            $return = new PutController();
        /********************************************
         *? Validando variables de PUt
         ********************************************/
            if(isset($_GET["id"]) && isset($_GET["nameId"])){
                /********************************************
                 *? Capturar los datos del formulario
                 ********************************************/
                    parse_str(file_get_contents('php://input'), $data);
                /********************************************
                 *? Validar la tabla y columnas
                 ********************************************/
                    foreach(array_keys($data) as $key => $value){
                        array_push($columns,$value);
                    }
                    array_push($columns,$_GET["nameId"]);
                    $columns=array_unique($columns);
                    if (empty(Connection::getColumnsData($db, $table, $columns))){
                        $return -> fncResponse(null,"PUT");
                        return;
                    }
                    /***********************************************************************************
                     *? Petición PUT para usuarios autorizados con JWT
                     ***********************************************************************************/
                        if(isset($_GET["token"])){
                            $tableToken=$_GET["table"]?? "users";
                            $suffix=$_GET["suffix"]?? "user";
                            $validate=Connection::valideToken($db, $tableToken, $suffix, $_GET["token"]);
                            /***********************************************************************************
                             *? Ok -> si el token existe y no esta expirado.
                                ***********************************************************************************/
                                if($validate=="ok"){
                                    /***********************************************************************************
                                     *? solicitud de repuestas del controlador para editar datos en cualquier tabla
                                        ***********************************************************************************/
                                        $response->putData($db, $table, $data, $id, $nameId);
                                }
                                /***********************************************************************************
                                 *? Exp -> si el token existe pero esta expirado.
                                    ***********************************************************************************/
                                    if($validate=="exp"){
                                        $return->fncResponse(null,"PUT","El token a expirado." );
                                    }
                                /***********************************************************************************
                                 *? No-out -> si el token no coincide en DB.
                                    ***********************************************************************************/
                                    if($validate=="no-aut"){
                                        $return->fncResponse(null,"PUT","El usuario no esta autorizado." );
                                    }
                        }else{
                            /***********************************************************************************
                             *? No consta con un token de autorización.
                             ***********************************************************************************/
                                $return->fncResponse(null,"PUT","Autorización requerida.");
                        }
                }
?>