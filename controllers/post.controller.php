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
          /***********************************************
           *? Validación del suffix
           ***********************************************/
            $val=array_keys($data)[0];
            if(count(array_keys($data))>1){
              $val=explode("_",$val)[2];
            }else{
              $val=explode("_",$val)[1];
            }
            if($suffix == null || $suffix!=$val){
              $suffix=$val;
            }
          /**************************************************
           *? Encriptar el password
           **************************************************/
              if(isset($data["password_".$suffix]) && $data["password_".$suffix]!=null){
                $crypt = crypt($data["password_".$suffix],$pass_crypt);
                $data["password_".$suffix]=$crypt;
              }
          /*****************************************************
           *? Llamado al modelo del postData.
          *****************************************************/
            $response = PostModel::postData($db, $table, $data);
          /***********************************************
           *? Retorno del postRegister.
          ***********************************************/
            $return->fncResponse($response,"postData",null);
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
          /***********************************************
           *? Validación del password existe en DB
          ***********************************************/
            if(!empty($response)){
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
                    "token_exp_".$suffix=>$token["exp"]
                  );
                /***********************************************
                 *? Actualizando del JWT del usuario en la DB
                ***********************************************/
                  $update=PutModel::putData($db, $table, $data, $response[0]->{"id_".$suffix}, "id_".$suffix);
                  $return -> fncResponse($update,"pilas - postLogin", null);
              }else{
                $return -> fncResponse(null,"postLogin", "Wrong password");
              }
            }else{
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
              echo json_encode($json, http_response_code($json["status"]));
            }
          }
    }
?>