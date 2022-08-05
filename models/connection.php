<?php
  /****************************************
   *todo Connection.
   ****************************************/
    /****************************************
     *! Requerimientos.
    ****************************************/
      require_once "models/get.model.php";
    /******************************
     *?Class Connection
    ******************************/
      class Connection{
        /********************************
         ** Información de la DB.
        ********************************/
          static public function infoDatabase($db){
            /*********************************************
             *? Información de la DB Sql Local.
             *********************************************/
              $infoSqlDBLocal = array(
                "base"=>"mysql",
                "host"=>"localhost",
                "database" => "deliveries",
                "user" => "root",
                "pass" => "",
                "port"=>3306
              );
            /********************************************
             *? Información de la DB Sql Heroku.
             ********************************************/
              $infoSqlDBHeroku = array(
                "base"=>"mysql",
                "host"=>"us-cdbr-east-06.cleardb.net",
                "database" => "heroku_38c964e95de6f41",
                "user" => "bf34cb7b4936d7",
                "pass" => "0087b518",
                "port"=>3306
              );
            /****************************************
             *? Información de la DB PgSql Local.
             ****************************************/
              $infoPgSqlDBHeroku = array(
                "base"=>"pgsql",
                "host"=>"localhost",
                "database" => "",
                "user" => "",
                "pass" => "",
                "port"=> 5432,
              );
            /****************************************
             *? Información de la DB PgSql Heroku.
             ****************************************/
              $infoPgSqlDBHeroku = array(
                "base"=>"pgsql",
                "host"=>"ec2-3-223-169-166.compute-1.amazonaws.com",
                "database" => "d1mvga7irad67n",
                "user" => "dbcwalnvizknns",
                "pass" => "5cfded1cccb6f48ad3ca1a1ecd3714bbccbd0910e35d120af63770804155ce49",
                "port"=> 5432,
              );
            /***************************************
             *? Retorno de la DB seleccionada.
            ***************************************/
              // 1 - SQL
              if($db == 1){
                return $infoSqlDBLocal;
              }
              // 2 - PGSQL
              if($db == 2){
                return $infoSqlDBHeroku;
              }
              if($db == 3){
                return $infoPgSqlDBLocal;
              }
              // 2 - PGSQL
              if($db == 4){
                return $infoPgSqlDBHeroku;
              }
          }
        /********************************
         ** Conexión a la DB.
        ********************************/
          static public function connect($db){
            /************************************************
             *? Colección a la DB.
            ************************************************/
              try {
                /********************************
                 *? Conexión a la DB.
                ********************************/
                $dboptions = array(
                  PDO::ATTR_PERSISTENT => FALSE,
                  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                  PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                  );    
                $link=new PDO(Connection::infoDatabase($db)["base"].":host="
                                    .Connection::infoDatabase($db)["host"]
                                    .";port=".Connection::infoDatabase($db)["port"]
                                    .";dbname=".Connection::infoDatabase($db)["database"],
                                    Connection::infoDatabase($db)["user"],
                                    Connection::infoDatabase($db)["pass"],$dboptions);
                    if($db==1 && $db==2){
                      $link->exec("set names utf8");
                    }
              /************************************************
               *? Capturar error de confección a la DB.
              ************************************************/
                }catch (PDOException $e){
                  die("Error: ".$e->getMessage());
                }
              /************************************************
               *? Retorno de la función conectar.
              ************************************************/
                return $link;
              }
        /*************************************************
         ** validar existencia de una tabla en la DB
        *************************************************/
          static public function getColumnsData($db, $table, $columns){
            /*****************************************
            *? Traer nombre de la base de la DB
            ******************************************/
              $database=Connection::infoDatabase($db)["database"];
            /*****************************************
            *? traer el nombre la columnas de la DB
            ******************************************/
              $validate = Connection::Connect($db)
                ->query("SELECT COLUMN_NAME AS item
                        FROM information_schema.columns WHERE table_schema ='$database'
                        AND table_name = '$table'")
                ->fetchAll(PDO::FETCH_OBJ);
            /**********************************************
            *? Validación de la existencia de la tabla.
            ***********************************************/
              if(empty($validate)){
                return null;
              }else{
                /*******************************
                 *? Validación select = *
                *******************************/
                  if($columns[0] == "*"){
                    array_shift($columns);
                  }
                /***************************************************
                 *? Validación de la existencia de las columnas.
                ***************************************************/
                  $sum=0;
                  foreach ($validate as $key => $value) {
                    $sum+=in_array($value->item, $columns);
                  }
                return $sum == count($columns) ? $validate : null;
              }
          }
        /*************************************************
         ** Generar token de autorización de usuario
        *************************************************/
          static public function jwt($id, $email){
            $time=time();
            $token= array(
              //tiempo en que inicia el token en el email
              "init"=>$time,
              //tiempo de expiración del token
              "exp"=>$time+(60*60*24),//(60*5)
              //Datos del usurario para el token
              "data" =>[
                "id" => $id,
                "email"=>$email
              ]
            );
            return $token;
          }
        /*************************************************
         ** Generar code de autorización de usuario
        *************************************************/
          static public function code($id, $email){
            $time=time();
            $code= array(
              //tiempo en que inicia el code en el email
              "init"=>$time,
              //tiempo de expiración del code
              "exp"=>$time+(60*5),
              //Datos del usurario para el code
              "data" =>[
                "id" => $id,
                "email"=>$email
              ]
            );
            return $code;
          }
        /*************************************************
         ** validar token
         *************************************************/
          static public function valideToken($db, $table, $suffix, $token){
            /*************************************************
             ** validar usuario del token.
             *************************************************/
              $user = GetModel::getDataFilter($db, $table, "*", "token_".$suffix, $token, null, null, null, null);
                if(!empty($user)){
                  /*************************************************
                   ** validar usuario del token.
                   *************************************************/
                    $time=time();
                    if($time < $user[0]->{"token_exp_".$suffix}){
                      return "ok";
                    }else{
                      return "exp";
                    }
                }else{
                  return "no-aut";
                }
          }
      }
?>