<?php
  /************************
   *! Requerimientos.
  ************************/
    require_once "models/post.model.php";
    require_once "models/get.model.php";
    require_once "models/put.model.php";
    require_once "models/connection.php";
    require_once "vendor/autoload.php";
  /************************
   *! Use.
   ************************/
    use Firebase\JWT\JWT;
  /******************************
   *todo Class Controller POST
  ******************************/
    class PostController{
      /****************************************
       ** Petición Post para crear datos.
      ****************************************/
        static public function postData($db, $table, $data){
          /***********************************************
           *? Variables
          ***********************************************/
            $responde = new PostController();
            $return = new PostController();
          /***********************************************
           *? Validación del suffix
           ***********************************************/
            $val=explode("_",(array_keys($data)[0]));
            if(count($val)>1){
              $val=end($val);
            }else{
              $val=$val[0];
            }
            if($suffix == null || $suffix!=$val){
              $suffix=$val;
            }
          /**************************************************
           *? Generando la facha de creación.
           **************************************************/
            $data["date_create_".$suffix]=date("Y-m-d H:i:s");
          /*****************************************************
           *? Llamado al modelo del postData.
          *****************************************************/
            $response = PostModel::postData($db, $table, $data);
          /***********************************************
           *? Retorno del postData.
          ***********************************************/
            $return -> fncResponse($response,"postData",null);
        }
      /****************************************
       ** Petición Post para registra usuario.
      ****************************************/
        static public function postRegister($db, $table, $data, $suffix){
          /***********************************************
           *? Variables
            ***********************************************/
              $return = new PostController();
              $pass_crypt='$2a$07$use1pass2table3base5$';
              $key="user20pass22bd1";
              $cod='HS256';
          /***********************************************
           *? Validación del suffix
           ***********************************************/
            $val=explode("_",(array_keys($data)[0]));
            if(count($val)>1){
              $val=end($val);
            }else{
              $val=$val[0];
            }
            if($suffix == null || $suffix!=$val){
              $suffix=$val;
            }
          /**************************************************
           *? validamos el password
           **************************************************/
            if(isset($data["password_".$suffix]) && $data["password_".$suffix]!=null){
              /**************************************************
               *? Encriptar el password
              **************************************************/
                $crypt = crypt($data["password_".$suffix],$pass_crypt);
                $data["password_".$suffix]=$crypt;
              /**************************************************
               *? Generando la fecha de creación.
              **************************************************/
                $data["date_create_".$suffix]=date("Y-m-d H:i:s");
              /*****************************************************
               *? Registro del usuario en la DB.
              *****************************************************/
                $response = PostModel::postData($db, $table, $data);
              /***********************************************
               *? Retorno del postRegister.
              ***********************************************/
                $return->fncResponse($response,"postData",null);
            }else{
              /**************************************************
               *? Generando la fecha de creación.
              **************************************************/
                $data["date_create_".$suffix]=date("Y-m-d H:i:s");
              /**************************************************
              /**************************************************
               *? registro indirecto de usuario.
              **************************************************/
                $data["direct_method_".$suffix]=false;
              /*****************************************************
               *? Registros de usuario desde una app externas.
               *****************************************************/
                $response = PostModel::postData($db, $table, $data);
              /**************************************************
               *? validando la creación en DB
               **************************************************/
                if(isset($response["comment"])&&$response["comment"]=="The process was successful"){
                  /***********************************************
                   *? Validación del usuario en DB
                   ***********************************************/
                    $response=GetModel::getDataFilter($db, $table, "*", "email_".$suffix, $data["email_".$suffix], null, null, null, null);
                    if(!empty($response)){
                      /***********************************************
                       *? Armando el JWT
                       ***********************************************/
                        $token=Connection::jwt($response[0]->{"id_".$suffix}, $response[0]->{"email_".$suffix});
                        $jwt=JWT::encode($token, $key, $cod);
                      /***********************************************
                       *? Armado la data a actualizar en DB
                      ***********************************************/
                        $data=array(
                          "token_".$suffix=>$jwt,
                          "token_exp_".$suffix=>$token["exp"]
                        );
                      /***********************************************
                       *? Registro de la data en la DB
                      ***********************************************/
                        $update=PutModel::putData($db, $table, $data, $response[0]->{"id_".$suffix}, "id_".$suffix);
                      /**********************************************
                       *? validando del la data en la DB
                      ***********************************************/
                        if(isset($update["comment"])&&$update["comment"]=="The process was successful"){
                          /*************************************************
                           *? Armando el response del registro en la DB.
                          **************************************************/
                            $response[0]->{"token_".$suffix}=$jwt;
                            $response[0]->{"token_exp_".$suffix}=$token["exp"];
                            $response[0]->{"date_create_".$suffix}=date("Y-m-d H:i:s");
                            unset($response[0]->{"password_".$suffix});
                          /*********************************************
                           *? Retorno del registro en la DB.
                          **********************************************/
                            $return -> fncResponse($response, "postLogin", null);
                        }else{
                          /**********************************************************
                           *? Retorno si no se actualizo la data en la DB.
                          **********************************************************/
                            $return -> fncResponse(null,"postLogin", "Data not updated");
                        }
                    }else{
                      /***********************************************
                       *? Retorno si el Email no existe.
                        ***********************************************/
                        $return -> fncResponse(null,"postLogin", "Wrong email");
                    }
                }else{
                  /***********************************************
                   *? Retorno si el usuario no fue creado.
                    ***********************************************/
                    $return -> fncResponse(null,"postLogin", "User creation error");
                }
            }
        }
      /****************************************
       ** Petición Post para login usuario.
      ****************************************/
        static public function postLogin($db, $table, $data, $suffix){
          /***********************************************
           *? Variables
          ***********************************************/
            $return = new PostController();
            $pass_crypt='$2a$07$use1pass2table3base5$';
            $key="user20pass22bd1";
            $cod='HS256';
          /***********************************************
           *? Validación del suffix
          ***********************************************/
            $val=array_keys($data)[0];
            $val=explode("_",$val)[1];
            if($suffix == null || $suffix!=$val){
              $suffix=$val;
            }
          /***********************************************
           *? Validación del usuario existe en DB
          ***********************************************/
            $response=GetModel::getDataFilter($db, $table, "*",
            "email_".$suffix, $data["email_".$suffix], null, null, null, null);
            if(!empty($response)){
              /***********************************************
               *? login de usuario desde una app externas
               ***********************************************/
                if($response[0]->{"password_".$suffix} != null){
                  /***********************************************
                   *? Validación del password.
                  ***********************************************/
                    $crypt=crypt($data["password_".$suffix],$pass_crypt);
                    if($response[0]->{"password_".$suffix} == $crypt){
                      /***********************************************
                       *? Armando el JWT
                      ***********************************************/
                        $token=Connection::jwt($response[0]->{"id_".$suffix}, $response[0]->{"email_".$suffix});
                        $jwt=JWT::encode($token, $key, $cod);
                      /***********************************************
                       *? Armado la data a actualizar en DB
                      ***********************************************/
                        $data=array(
                          "token_".$suffix=>$jwt,
                          "token_exp_".$suffix=>$token["exp"],
                          "logged_in_".$suffix=>true
                        );
                      /***********************************************
                       *? Actualizando del JWT en la DB
                      ***********************************************/
                        $update=PutModel::putData($db, $table, $data, $response[0]->{"id_".$suffix}, "id_".$suffix);
                      /************************************************************
                       *? validando la actualización del JWT en la DB
                      ************************************************************/
                        if(isset($update["comment"])&&$update["comment"]=="The process was successful"){
                          $response[0]->{"token_".$suffix}=$jwt;
                          $response[0]->{"token_exp_".$suffix}=$token["exp"];
                          unset($response[0]->{"password_".$suffix});
                          /******************************************************
                           *? Retorno de la actualización del JWT en la DB.
                          ******************************************************/
                          $return -> fncResponse($response, "postLogin", null);
                        }else{
                          /**********************************************************
                           *? Retorno si no se actualiza el JWT en la DB.
                          **********************************************************/
                            $return -> fncResponse(null,"postLogin", "JWT not updated");
                          }
                    }else{
                      /***********************************************
                       *? Retorno si el password no existe.
                      ***********************************************/
                        $return -> fncResponse(null,"postLogin", "Wrong password");
                    }
                }else{
                  /***********************************************
                   *? Armando el JWT
                   ***********************************************/
                    $token=Connection::jwt($response[0]->{"id_".$suffix}, $response[0]->{"email_".$suffix});
                    $jwt=JWT::encode($token, $key, $cod);
                  /***********************************************
                   *? Armado la data a actualizar en DB
                   ***********************************************/
                    $data=array(
                      "token_".$suffix=>$jwt,
                      "token_exp_".$suffix=>$token["exp"],
                      "logged_in_".$suffix=>true
                    );
                  /***********************************************
                   *? Actualizando del JWT en la DB
                   ***********************************************/
                    $update=PutModel::putData($db, $table, $data, $response[0]->{"id_".$suffix}, "id_".$suffix);
                  /************************************************************
                   *? validando la actualización del JWT en la DB
                   ************************************************************/
                    if(isset($update["comment"])&&$update["comment"]=="The process was successful"){
                      $response[0]->{"token_".$suffix}=$jwt;
                      $response[0]->{"token_exp_".$suffix}=$token["exp"];
                      unset($response[0]->{"password_".$suffix});
                      /******************************************************
                       *? Retorno de la actualización del JWT en la DB.
                       ******************************************************/
                        $return -> fncResponse($response, "postLogin", null);
                    }else{
                      /**********************************************************
                       *? Retorno si no se actualiza el JWT en la DB.
                      **********************************************************/
                        $return -> fncResponse(null,"postLogin", "JWT not updated");
                      }
                }
            }else{
              /***********************************************
               *? Retorno si el Email no existe.
               ***********************************************/
                $return -> fncResponse(null,"postLogin", "Wrong email");
            }
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
                "error" => $error,
                "method" => $method
            );
            }else{
            $json = array(
              "status" => 404,
              "detalle" => "not found...",
              "method" => $method
            );
            }
          }
            echo json_encode($json, http_response_code($json["status"]));
          }
    }
?>