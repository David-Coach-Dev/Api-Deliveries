<?php
    /****************************************
     *todo Petición POST.
     ****************************************/
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
         *? Separar propiedades en un arreglo
         ********************************************/
            if(isset($_POST)){
                foreach(array_keys($_POST) as $key => $value){
                    array_push($columns, $value);
                }
            }
        /********************************************
         *? Validar la tabla y columnas
         ********************************************/
            if (empty(Connection::getColumnsData($db, $table, $columns))){
                $return->fncResponse(null,"POST","Files not match the DB" );
                return;
            }
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
                     *? Verificando si exited el token
                     ***********************************************************************************/
                        if(isset($_GET["token"])){
                            /***********************************************************************************
                             *? Petición POST para usuarios no autorizados con JWT
                             ***********************************************************************************/
                                if($_GET["token"]=="no" && isset($_GET["except"])){
                                    /********************************************
                                     *? Validar la tabla y columnas
                                     ********************************************/
                                        $columns=array($_GET["except"]);
                                        if (empty(Connection::getColumnsData($db, $table, $columns))){
                                            $return->fncResponse(null,"POST","Files not match the DB" );
                                            return;
                                        }
                                    /***********************************************************************************
                                     *? Solicitud de creación de dato en cualquier tabla
                                     ***********************************************************************************/
                                        $response->postData($db, $table, $_POST);
                                }else{
                                    /***********************************************************************************
                                     *? Petición POST para usuarios autorizados con JWT
                                     ***********************************************************************************/
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
                                }
                        }else{
                            /***********************************************************************************
                             *? No consta con un token de autorización.
                             ***********************************************************************************/
                                $return->fncResponse(null,"POST","Autorización requerida.");
                        }
                }
?>