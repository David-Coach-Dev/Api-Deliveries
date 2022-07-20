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
                        print_r("postRegister");
                        $response->postRegister($db, $table, $_POST, $suffix);
                    }else
                    /***********************************************************************************
                     *? Petición POST para el registro de usuarios
                     ***********************************************************************************/
                    if(isset($_GET["login"]) && $_GET["login"]==true){
                            print_r("postLogin");
                            $response->postLogin($db, $table, $_POST, $suffix);
                        }else{
                            /***********************************************************************************
                             *? solicitud de repuestas del controlador para crear datos en cualquier tabla
                             ***********************************************************************************/
                                print_r("posData");
                                $response->postData($db, $table, $_POST);
                        }
                }
            }
?>