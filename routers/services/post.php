<?php
    /****************************************
     *todo Petición POST.
    ****************************************/
        /********************************************
         *! Header.
        ********************************************/
            header('Access-Control-Allow-Origin: *');
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type,Accept');
            header('Access-Control-Allow-Headers: Special-Request-Header');
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        /********************************************
         *! Requerimientos.
        ********************************************/
            require_once "models/connection.php";
            require_once "controllers/post.controller.php";
        /********************************************
         *? Variables
         ********************************************/
            $suffix=$_GET["suffix"]?? "user";
            $columns=array();
            $response = new PostController();
            $return = new PostController();
        /********************************************
         *? Validar la tabla y columnas
         ********************************************/
            if(isset($_POST)){
                foreach(array_keys($_POST) as $key => $value){
                    array_push($columns, $value);
                }
                if (empty(Connection::getColumnsData($db, $table, $columns))){
                    $return->fncResponse(null,"POST","Files not match the DB" );
                }else{
                /***********************************************************************************
                 *? Petición POST para el registro de usuarios
                 ***********************************************************************************/
                    if(isset($_GET["register"]) && $_GET["register"]==true){
                        $response->postRegister($db, $table, $_POST, $suffix);
                    }else
                    /***********************************************************************************
                     *? Petición POST para el registro de usuarios
                     ***********************************************************************************/
                    if(isset($_GET["login"]) && $_GET["login"]==true){
                            $response->postLogin($db, $table, $_POST, $suffix);
                        }else{
                            /***********************************************************************************
                             *? Petición POST para usuarios autorizados con JWT
                             ***********************************************************************************/
                                if(isset($_GET["token"])){
                                    $tableToken=$_GET["tableToken"]?? "users";
                                    $suffixToken=$_GET["suffixToken"]?? "user";
                                    $validate=Connection::valideToken($db, $tableToken, $suffixToken, $_GET["token"]);
                                    /***********************************************************************************
                                     *? Ok -> si el token existe y no esta expirado.
                                     ***********************************************************************************/
                                    if($validate=="ok"){
                                        /***********************************************************************************
                                         *? Solicitud de creación de dato en cualquier tabla
                                         ***********************************************************************************/
                                            $response->postData($db, $table, $_POST);
                                    }
                                    /***********************************************************************************
                                     *? Exp -> si el token existe pero esta expirado.
                                     ***********************************************************************************/
                                        if($validate=="exp"){
                                            $return->fncResponse(null,"POST","El token a expirado." );
                                        }
                                    /***********************************************************************************
                                     *? No-out -> si el token no coincide en DB.
                                     ***********************************************************************************/
                                        if($validate=="no-aut"){
                                            $return->fncResponse(null,"POST","El usuario no esta autorizado." );
                                        }
                                }else{
                                    /***********************************************************************************
                                     *? No consta con un token de autorización.
                                     ***********************************************************************************/
                                        $return->fncResponse(null,"POST","Autorización requerida.");
                                }
                        }
                }
            }
?>