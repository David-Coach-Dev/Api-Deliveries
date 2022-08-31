<?php
    /****************************************
     *todo Petición PUT.
    ****************************************/
        /********************************************
         *! Requerimientos.
        ********************************************/
            require_once "models/connection.php";
            require_once "controllers/put.controller.php";
            require_once "middleware/response.middleware.php";
        /********************************************
         *? Variables
        ********************************************/
            $data=array();
            $dataTem=array();
            $data1=array();
            $dato="";
            $columns=array();
            $id=$_GET["id"]?? null;
            $nameId=$_GET["nameId"]?? null;
            $response = new PutController();
            $return = new responseMiddleware();
        /********************************************
         *? Validando variables de PUt
         ********************************************/
            if(isset($_GET["id"]) && isset($_GET["nameId"])){
                /********************************************
                 *? Capturar los datos del formulario
                 ********************************************/
                    echo "-> Input : ";print_r(file_get_contents('php://input'));echo"\n";
                    $dataTem = explode("=",file_get_contents('php://input'));
                    echo"====================\n";
                    echo "-> Data : ";print_r($dataTem);echo"\n";
                    foreach($dataTem as $k1 => $value){
                        if($k1!=0){
                            $data1 = explode("------WebKitFo",$dataTem[$k1]);
                            echo"====================\n";
                            echo "-> Data1 = ";print_r($data1);echo"\n";
                            foreach($data1 as $k2 => $value){
                                if(($k2%2)==0){
                                    echo"====================\n";
                                    echo "-> Data1[ ";print_r($k2);echo"]\n";
                                    $dato= $data1[$k2];
                                    echo"====================\n";
                                    echo "-> Dato-P1 = ";print_r($dato);echo"]\n";
                                    $dato= explode("------WebKitFormBoundary",$dato);
                                    echo"====================\n";
                                    echo "-> Dato-P2 = ";print_r($dato);echo"\n";
                                    $dato= explode('"',$dato[0]);
                                    echo"====================\n";
                                    echo "-> Dato-P3 = ";print_r($dato);echo"\n";
                                    $data += [$dato[1]=>$dato[2]];
                                    echo"====================\n";
                                    echo "-> Data = ";print_r($data);echo"\n";
                                }
                            }
                        }
                    }
                /********************************************
                 *? Separar propiedades en un arreglo
                 ********************************************/
                    foreach(array_keys($data) as $key => $value){
                        array_push($columns,$value);
                    }
                    array_push($columns,$_GET["nameId"]);
                /********************************************
                 *? Validar la tabla y columnas
                 ********************************************/
                    $columns=array_unique($columns);
                    if (empty(Connection::getColumnsData($db, $table, $columns))){
                        ResponseMiddleware::fncResponseValidation("PUT", null);
                        //$return -> fncResponse(400, "PUT", array("error"=>"Tabla o columna invalida..."));
                        return;
                    }
                /***********************************************************************************
                 *? Verificando si exited el token
                 ***********************************************************************************/
                    if(isset($_GET["token"])){
                        /***********************************************************************************
                         *? Petición PUT para usuarios no autorizados con JWT
                         ***********************************************************************************/
                            if($_GET["token"]=='no' && isset($_GET["except"])){
                                /********************************************
                                 *? Validar la tabla y columnas
                                 ********************************************/
                                    $columns=array($_GET["except"]);
                                    if (empty(Connection::getColumnsData($db, $table, $columns))){
                                        ResponseMiddleware::fncResponseValidation("PUT", null);
                                        //$return->fncResponse(400, "PUT", array("error"=>"Tabla o columna invalida..."));
                                        return;
                                    }
                                /***********************************************************************************
                                 *? Solicitud de creación de dato en cualquier tabla
                                ***********************************************************************************/
                                    $response->putData($db, $table, $data, $id, $nameId);
                            }else{
                                /***********************************************************************************
                                 *? Petición PUT para usuarios autorizados con JWT
                                 ***********************************************************************************/
                                    $tableToken=$_GET["tableToken"]?? "users";
                                    $suffixToken=$_GET["suffixToken"]?? "user";
                                    $validate=Connection::valideToken($db, $tableToken, $suffixToken, $_GET["token"]);
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
                                            $return->fncResponse(403, "PUT", array("error"=>"El token a expirado..."));
                                        }
                                    /***********************************************************************************
                                     *? No-out -> si el token no coincide en DB.
                                     ***********************************************************************************/
                                        if($validate=="no-aut"){
                                            $return->fncResponse(403, "PUT", array("error"=>"El usuario no esta autorizado..."));
                                        }
                            }
                    }else{
                        /***********************************************************************************
                         *? No consta con un token de autorización.
                         ***********************************************************************************/
                            $return->fncResponse(403, "PUT", array("error"=>"Autorización requerida..."));
                    }
            }
?>